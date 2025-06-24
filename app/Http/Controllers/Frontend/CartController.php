<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function addToCar1t(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        $price = $product->discount_price === 0
            ? $product->selling_price
            : $product->price_after_discount;

        Cart::add([
            'id' => $id,
            'name' => $request->product_name,
            'qty' => $request->qty,
            'price' => $price,
            'weight' => 1,
            'options' => [
                'size' => $request->size,
                'color' => $request->color,
                'image' => $product->product_thumbnail,
            ],
        ]);

        return response()->json(['success' => 'success', 'message' => 'Data berhasil ditambahkan ke Keranjang']);
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $requestedQty = (int) $request->qty;
        
        // Ambil stok produk dari database (gunakan field yang benar)
        $stock = $product->product_qty;
    
        // Cek apakah produk sudah ada di dalam keranjang
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id == $id;
        })->first();
    
        $currentCartQty = $cartItem ? $cartItem->qty : 0;
    
        // Validasi stok
        if (($currentCartQty + $requestedQty) > $stock) {
            return response()->json(['error' => 'Stok tidak mencukupi!'], 400);
        }
    
        // Menentukan harga berdasarkan diskon
        $price = $product->discount_price === 0 ? $product->selling_price : $product->price_after_discount;
    
        Cart::add([
            'id' => $id,
            'name' => $request->product_name,
            'qty' => $requestedQty,
            'price' => $price,
            'weight' => 1,
            'options' => [
                'size' => $request->size,
                'color' => $request->color,
                'image' => Storage::url($product->product_thumbnail)
            ]
        ]);
    
        return response()->json(['success' => 'Data berhasil ditambahkan ke Keranjang']);
    }
    

    public function addMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal =  Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal
        ));
    }

    public function removeMiniCart($rowId)
    {
        Cart::remove($rowId);

        return response()->json(['success' => 'Data Keranjang Berhasil Dihapus']);
    }
}
