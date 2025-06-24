<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Ongkir;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserCheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Cart::total() > 0) {
                $carts = Cart::content();
                $cartQty = Cart::count();
                $total = Cart::total();

                // Fetch provinces from API
                $listProvince = $this->getProvince();

                $title = 'Checkout';

                return view('frontend.checkout.index', compact(
                    'title',
                    'carts',
                    'cartQty',
                    'total',
                    'listProvince'
                ));
            } else {
                return redirect()->to('/');
            }
        } else {
            $notification = array(
                'message' => 'Silahkan Login Terlebih Dahulu',
                'error' => 'Silahkan Login Terlebih Dahulu'
            );
            return redirect()->route('login')->with($notification);
        }
    }


    public function detail(Request $request)
    {

        // dd($request->all());
        $title = 'Detail Checkout';
        $carts = Cart::content();
        $total = Cart::total();
        $totalAmount = (int) str_replace(',', '', Cart::subtotal()) + $request->courier;

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $ongkir = $request->courier;
        $address = $request->address;
        $notes = $request->notes;


        $orderId = Order::insertGetId([
            'user_id' => Auth::id(),
            'province_id' => $request->province_id,
            'regency_id' => $request->city_id,
            'district_id' => $request->city_id,
            'village_id' => $request->city_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'post_code' => $request->post_code,
            'notes' => $request->notes,
            'amount' => $totalAmount,
            'invoice_no' => 'INV' . rand(100000000000, 999999999999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'ongkir' => $request->courier,
            'courir' => $request->courier_service,
            'status' => 'Pending',
        ]);

        foreach ($carts as $cart) {
            OrderItem::insert([
                'order_id' => $orderId,
                'product_id' => $cart->id,
                'color' => $cart->options->color,
                'size' => $cart->options->size,
                'qty' => $cart->qty,
                'price' => $cart->price,
            ]);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $totalAmount
            ),

            'customer_details' => array(
                'first_name' => $name,
                'email' => $email,
                'phone' => $phone
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        Cart::destroy();

        return view('frontend.checkout.detail', compact([
            'title',
            'carts',
            'name',
            'email',
            'phone',
            'address',
            'notes',
            'total',
            'snapToken',
            'orderId',
            'ongkir'
        ]));
    }

    public function searchProvince(Request $request)
    {
        $keyword = $request->q;
        $result = Province::where('name', 'like', '%' . $keyword . '%')->get();

        return response()->json($result);
    }

    public function searchRegence($province_id)
    {
        $result = Regency::where('province_id', 'like', '%' . $province_id . '%')->get();
        return response()->json($result);
    }

    public function searchDistrict($regency_id)
    {
        $districts = District::where('regency_id', $regency_id)->get(['id', 'name']);
        return response()->json($districts);
    }

    public function searchVillage($district_id)
    {
        $villages = Village::where('district_id', $district_id)->get(['id', 'name']);
        return response()->json($villages);
    }

    public function checkoutStore(Request $request)
    {
        $id_order = $request->id_order;
        $data = json_decode($request->get('json'));
        Order::findOrfail($id_order)->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id
        ]);

        $notification = [
            'message' => 'Pembayaran Success',
            'alert-type' => 'success',
        ];

        return redirect()->route('user.order')->with($notification);
    }

    public function getCouriers(Request $request)
    {
        $villageId = $request->input('village_id');

        // Fetch couriers from the Ongkir model based on the village (modify this as per your logic)
        $couriers = Ongkir::where('village_id', $villageId)->get();

        // Return couriers as JSON
        return response()->json([
            'couriers' => $couriers
        ]);
    }

    public function getProvince()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 1fd969e8011cefb27d112188e52248c4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // Log the error or handle it as needed
            return [];
        }

        // Decode the response
        $data = json_decode($response, true);

        // Check for proper response structure
        if (isset($data['rajaongkir']['results'])) {
            return response()->json([
                'status' => 'success',
                'data' => $data['rajaongkir']['results']
            ]);
        }

        return [];
    }

    public function getCity($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 1fd969e8011cefb27d112188e52248c4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // Return a JSON response indicating an error
            return response()->json([
                'status' => 'error',
                'message' => "cURL Error #: $err"
            ], 500);
        }

        $data = json_decode($response, true);

        // Validate and return the response
        if (isset($data['rajaongkir']['results'])) {
            return response()->json([
                'status' => 'success',
                'data' => $data['rajaongkir']['results']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch cities.'
        ], 500);
    }

    public function getOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => '1fd969e8011cefb27d112188e52248c4',
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()['rajaongkir']['results'],
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to fetch data'], 500);
    }

    public function destroy($id)
{
    $order = Order::findOrFail($id);

    // Pastikan hanya bisa menghapus order dengan status Pending
    if ($order->status == 'Pending') {
        $order->delete();

        return redirect()->back()->with('success', 'Order has been deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'You can only delete orders with status Pending.');
    }
}


    public function get_ongkir1(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $weight = $request->input('weight');
        $courier = $request->input('courier');

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query([
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ]),
            CURLOPT_HTTPHEADER => [
                "content-type: application/x-www-form-urlencoded",
                "key: 1fd969e8011cefb27d112188e52248c4"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['status' => 'error', 'message' => $err]);
        }

        $data = json_decode($response, true);
        return response()->json([
            'status' => 'success',
            'data' => $data['rajaongkir']['results']
        ]);
    }
}
