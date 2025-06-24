<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Exports\LaporanPenjualanExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class LaporanPenjualanController extends Controller
{
    public function index (Request $request)
    {
    $month = $request->input('month');

    $orderItems = OrderItem::with(['order', 'product'])
        ->when($month, function ($query) use ($month) {
            $query->whereHas('order', function ($q) use ($month) {
                $q->whereMonth('order_date', $month);
            });
        })
        ->get();

    return view('admin.laporanpenjualan.index', [
        'title' => 'Laporan Penjualan',
        'orderItems' => $orderItems,
        'selectedMonth' => $month
    ]);
    }


    public function data(Request $request)
{
    $query = OrderItem::with('product', 'order')
        ->when($request->month, function ($q) use ($request) {
            $q->whereMonth('order_date', $request->month);
        });

    return DataTables::of($query)
        ->addIndexColumn()
        ->editColumn('product_name', function ($item) {
            return $item->product->product_name ?? '-';
        })
        ->editColumn('price', function ($item) {
            return 'Rp' . number_format($item->price, 0, ',', '.');
        })
        ->addColumn('total', function ($item) {
            return 'Rp' . number_format($item->price * $item->qty, 0, ',', '.');
        })
        ->editColumn('order_date', function ($item) {
            return $item->order->order_date->format('d-m-Y');
        })
        ->make(true);
}
    public function export(Request $request)
{
    $month = $request->input('month');
    return Excel::download(new LaporanPenjualanExport($month), 'laporan-penjualan.xlsx');
}
}
