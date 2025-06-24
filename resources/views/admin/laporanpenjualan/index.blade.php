@extends('layouts.stisla')

@section('title', $title)

@section('content')
<div class="section-body">

    <!-- Filter & Export -->
    <form class="form-inline mb-3">

        <a href="{{ route('admin.laporanpenjualan.export', ['month' => request('month')]) }}" class="btn btn-success ml-2">
            Export Excel
        </a>
    </form>

    <x-card>
        <x-table>
            <x-slot name="thead">
                <th>No</th>
                <th>Produk</th>
                <th>Warna</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Tanggal</th>
            </x-slot>
        </x-table>
    </x-card>
</div>
@endsection

@include('includes.datatables')

@push('scripts')
<script>
    let table;
    table = $('.table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('admin.laporanpenjualan.data') }}',
            data: function (d) {
                d.month = $('#month').val(); // Kirim bulan yang terfilter
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'product_name', name: 'product.product_name' },
            { data: 'color', name: 'color' },
            { data: 'size', name: 'size' },
            { data: 'qty', name: 'qty' },
            { data: 'price', name: 'price' },
            { data: 'total', name: 'total', orderable: false, searchable: false },
            { data: 'order_date', name: 'order.order_date' }
        ]
    });

    // Reload saat filter bulan berubah
    $('#month').on('change', function () {
        table.ajax.reload();
    });
</script>
@endpush
