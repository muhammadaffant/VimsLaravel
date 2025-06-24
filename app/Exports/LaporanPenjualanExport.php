<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanPenjualanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $month;

    public function __construct($month = null)
    {
        $this->month = $month;
    }

    public function collection()
    {
        return OrderItem::with(['order', 'product'])
            ->when($this->month, function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->whereMonth('order_date', $this->month);
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'Produk' => $item->product->product_name ?? '-',
                    'Warna' => $item->color,
                    'Ukuran' => $item->size,
                    'Jumlah' => $item->qty,
                    'Harga' => $item->price,
                    'Total' => $item->price * $item->qty,
                    'Tanggal' => $item->order->order_date,
                ];
            });
    }

    public function headings(): array
    {
        return ['Produk', 'Warna', 'Ukuran', 'Jumlah', 'Harga', 'Total', 'Tanggal'];
    }
}

