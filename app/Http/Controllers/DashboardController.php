<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $title = $user->hasRole('admin') || $user->hasRole('owner') 
            ? 'Dashboard' 
            : 'UserDashboard';
    
        if ($user->hasRole('admin') || $user->hasRole('owner')) {
            $orderSuccess = Order::where('status', 'Success')->count();
            $orderPending = Order::where('status', 'Pending')->count();
            $totalUser    = User::role('user')->count();
            $totalProduct = Product::where('status', 1)->where('product_qty', '>=', 0)->count();
            // Tambahkan perhitungan pendapatan (asumsikan 'total_price' adalah kolom harga di tabel orders)
            $totalRevenue = Order::where('status', 'success')->sum('amount');


            // Transaksi sukses per bulan
            $monthlySuccess = Order::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
                ->where('status', 'Success')
                ->groupByRaw('MONTH(updated_at)')
                ->pluck('total', 'month');

            // Format data untuk grafik
            $months = [];
            $successCounts = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[] = Carbon::create()->month($i)->format('F'); // Nama bulan
                $successCounts[] = $monthlySuccess[$i] ?? 0; // Nilai sukses, 0 jika tidak ada
            }
    
            return view('admin.dashboard.index', compact(
                'title',
                'orderSuccess',
                'orderPending',
                'totalRevenue',
                'totalProduct',
                'totalUser',
                'months',
                'successCounts'
            ));
        } else {
            return view('user.dashboard', compact('title'));
        }
    }
}
