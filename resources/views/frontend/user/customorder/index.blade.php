@extends('frontend.main_master')

@section('title', 'Custom order')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>@yield('title')</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="container">
            <div class="checkout-box ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group checkout-steps" id="accordion">
                            <!-- checkout-step-01  -->
                            <div class="panel panel-default checkout-step-01">
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <!-- panel-body  -->
                                    <div class="panel-body">
                                        <div class="row justify-content-center">
                                            <!-- Custom Order Form -->
                                            <div class="col-md-8 col-sm-10">
                                                <div class="card shadow-sm">
                                                    <div class="card-header bg-primary text-white text-center">
                                                        <h4 class="checkout-subtitle mb-0"><b>Custom Order</b></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <form id="customOrderForm" class="register-form" role="form"
                                                            enctype="multipart/form-data">
                                                            @csrf

                                                            <input type="hidden" name="province_id" id="province_id">
                                                            <input type="hidden" name="city_id" id="city_id">
                                                            <input type="hidden" name="courier" id="courier_hidden">
                                                            <input type="hidden" name="courier_service"
                                                                id="courier_service_hidden">
                                                            <input type="hidden" name="shipping_cost"
                                                                id="shipping_cost_hidden">

                                                            <input type="hidden" name="selected_fabric"
                                                                id="selected_fabric">

                                                            <!-- Hidden Input for User ID -->
                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::user()->id }}">

                                                            <!-- Name Input -->
                                                            <div class="form-group">
                                                                <label for="name" class="info-title">Nama Lengkap</label>
                                                                <input id="name" class="form-control" type="text"
                                                                    name="name" autocomplete="off"
                                                                    placeholder="Input your name"
                                                                    value="{{ Auth::user()->name }}" required>
                                                            </div>

                                                            <!-- File Design Input -->
                                                            <div class="form-group">
                                                                <label for="file_design" class="info-title">Upload
                                                                    Design</label>
                                                                <input id="file_design" class="form-control" type="file"
                                                                    name="file_design" accept="image/*" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="position" class="info-title">Letak
                                                                    Logo</label>
                                                                <select name="position" id="" class="form-control">
                                                                    <option disabled selected>Pilih Letak Logo</option>
                                                                    <option value="Depan Tengah">Depan Tengah</option>
                                                                    <option value="Depan Samping Kiri">Depan Samping Kiri</option>
                                                                    <option value="Depan Samping Kanan">Depan Samping Kanan
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <!-- Design Description Input -->
                                                            <div class="form-group">
                                                                <label for="design_description" class="info-title">Design
                                                                    Description</label>
                                                                <textarea id="design_description" name="design_description" cols="30" rows="5" class="form-control"
                                                                    placeholder="Describe your design" required></textarea>
                                                            </div>


                                                            @php

                                                                $bahans = App\Models\Bahan::all();
                                                            @endphp

                                                            <!-- Fabric Type Input -->
                                                            <div class="form-group">
                                                                <label for="fabric_type" class="info-title">Fabric
                                                                    Type</label>
                                                                <select name="fabric_type" id=""
                                                                    class="form-control" onchange="updateHiddenInput()">
                                                                    <option disabled selected>Pilih Bahan</option>
                                                                    @foreach ($bahans as $bahan)
                                                                        <option value="{{ $bahan->nama_bahan }}">
                                                                            {{ $bahan->nama_bahan }} -
                                                                            {{ $bahan->price }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Size Input -->
                                                            <div class="form-group">
                                                                <label for="size" class="info-title">Size</label>
                                                                <input id="size" class="form-control" type="text"
                                                                    name="size"
                                                                    placeholder="Input size (e.g., S, M, L, XL)" required>
                                                            </div>

                                                            <!-- Quantity Input -->
                                                            <div class="form-group">
                                                                <label for="qty" class="info-title">Quantity</label>
                                                                <input id="qty" class="form-control" type="number"
                                                                    name="qty" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="address" class="info-title">Alamat
                                                                    Lengkap</label>
                                                                <textarea name="address" id="address" class="form-control" cols="30" rows="10"></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="courier_service" class="info-title">Pilih Jasa
                                                                    Pengiriman</label>
                                                                <select name="courier_service" id="courier_service"
                                                                    class="form-control" required>
                                                                    <option value="">-- Pilih Jasa Pengiriman --
                                                                    </option>
                                                                    <option value="jne">JNE</option>
                                                                    <option value="pos">POS Indonesia</option>
                                                                    <option value="tiki">TIKI</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="province_id" class="info-title">Pilih
                                                                    Provinsi</label>
                                                                <select name="province_id" id="province_id"
                                                                    class="form-control select2 province_id"
                                                                    style="width: 100%;">
                                                                    {{--  @foreach ($listProvince as $province)
                                                            <option value="{{ $province['province_id'] }}">
                                                                {{ $province['province'] }}
                                                            </option>
                                                        @endforeach  --}}
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="city_id" class="info-title">Pilih
                                                                    Kabupaten/Kota</label>
                                                                <select name="city_id" id="city_id"
                                                                    class="form-control select2 city_id"
                                                                    style="width: 100%;"></select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="courier" class="info-title">Pilih
                                                                    Kurir</label>
                                                                <select name="courier" id="courier"
                                                                    class="form-control" required>
                                                                    <option value="">-- Pilih Kurir --</option>
                                                                    <!-- Opsi kurir akan diisi secara dinamis melalui JavaScript -->
                                                                </select>
                                                            </div>




                                                            <!-- Submit Button -->
                                                            <div class="form-group text-center">
                                                                <button type="button" id="submitCustomOrder"
                                                                    class="btn btn-primary w-50">Submit Custom
                                                                    Order</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#submitCustomOrder').on('click', function(e) {
                e.preventDefault(); // Mencegah form dikirim secara tradisional

                // Ambil data form
                let formData = new FormData($('#customOrderForm')[0]);

                // Kirim data dengan AJAX
                $.ajax({
                    url: "{{ route('user.customorder.store') }}", // URL tujuan
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                    },
                    beforeSend: function() {
                        // Tambahkan loader atau nonaktifkan tombol submit
                        $('#submitCustomOrder').prop('disabled', true).text('Submitting...');
                    },
                    success: function(response) {
                        // Reset form
                        $('#customOrderForm')[0].reset();

                        if ($.isEmptyObject(response.error)) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                                showConfirmButton: false,
                                timer: 7000
                            });
                            window.location.href = "{{ route('user.customorder.history') }}";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.error,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        if ($.isEmptyObject(response.error)) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.error,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
                        // Aktifkan kembali tombol submit
                        $('#submitCustomOrder').prop('disabled', false).text(
                            'Submit Custom Order');
                    },
                    complete: function() {
                        // Aktifkan kembali tombol submit
                        $('#submitCustomOrder').prop('disabled', false).text(
                            'Submit Custom Order');
                    }
                });
            });
        });
    </script>
@endpush
@push('script')
    <script>
        $(function() {
            // Initialize Select2 for province_id
            $('.province_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Provinsi --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: '{{ route('user.checkout.getProvince') }}', // Endpoint untuk mencari provinsi
                    dataType: 'json',
                    delay: 300,
                    processResults: function(response) {
                        return {
                            results: response.data.map(function(item) {
                                return {
                                    id: item
                                        .province_id, // Gunakan id dari respons untuk province_id
                                    text: item.province // Gunakan name dari respons untuk teks
                                };
                            })
                        };
                    }
                }
            });

            // Initialize Select2 for city_id
            $('.city_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Kabupaten/Kota --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: function() {
                        let provinceId = $('.province_id').val(); // Ambil province_id terpilih
                        return provinceId ? `{{ route('user.checkout.searchRegence', ':provinceId') }}`
                            .replace(':provinceId', provinceId) : '';
                    },
                    dataType: 'json',
                    delay: 300,
                    processResults: function(response) {
                        return {
                            results: response.data.map(function(item) {
                                return {
                                    id: item.city_id, // Gunakan city_id dari respons
                                    text: item.city_name // Gunakan city_name dari respons
                                };
                            })
                        };
                    }
                }
            });

            // Handle province change to reset city dropdown
            $('.province_id').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    $('.city_id').prop('disabled', false).val(null).trigger(
                        'change'); // Enable city dropdown
                } else {
                    $('.city_id').val(null).trigger('change').prop('disabled',
                        true); // Disable city dropdown
                }
            });
        });

        $(document).on('change', '#city_id', function() {
            const origin = 501; // ID kota asal (ubah sesuai kebutuhan)
            const destination = $(this).val();
            const weight = 1; // Berat dalam gram (ubah sesuai kebutuhan)
            const courierService = $('#courier_service').val(); // Kurir yang dipilih

            if (!courierService) {
                alert('Silakan pilih jasa pengiriman terlebih dahulu.');
                return;
            }

            let selectedOption = $(this).find('option:selected');
            let shippingCost = selectedOption.val();
            let courierServiceText = selectedOption.text();

            $('#shipping_cost_hidden').val(shippingCost);
            $('#courier_service_hidden').val(courierServiceText);
            $('#courier_hidden').val(courierService);

            if (destination) {
                $.ajax({
                    url: '{{ route('user.checkout.getOngkir') }}',
                    type: 'POST',
                    data: {
                        origin: origin,
                        destination: destination,
                        weight: weight,
                        courier: courierService,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            const courierOptions = response.data[0].costs;
                            let courierHtml = '<option value="">-- Pilih Paket Kurir --</option>';
                            courierOptions.forEach(option => {
                                courierHtml += `
                            <option value="${option.cost[0].value}">
                                ${option.service} - ${option.description} (Rp. ${option.cost[0].value})
                            </option>
                        `;
                            });
                            $('#courier').html(courierHtml).prop('disabled', false);
                        } else {
                            alert('Gagal mengambil opsi pengiriman.');
                        }
                    },
                    error: function() {
                        alert('Error saat mengambil opsi pengiriman.');
                    }
                });
            } else {
                $('#courier').html('<option value="">-- Pilih Paket Kurir --</option>').prop('disabled', true);
            }
        });

        $(document).on('change', '#courier_service', function() {
            // Reset paket kurir saat pengguna mengubah jasa pengiriman
            $('#courier').html('<option value="">-- Pilih Paket Kurir --</option>').prop('disabled', true);
        });
    </script>

    <script>
        function updateHiddenInput() {
            // Ambil elemen <select> dan <input hidden>
            const selectElement = document.getElementById('fabric_type');
            const hiddenInput = document.getElementById('selected_fabric');

            // Ambil nilai yang dipilih dari <select>
            const selectedValue = selectElement.value;

            // Set nilai ke <input hidden>
            hiddenInput.value = selectedValue;
        }
    </script>
@endpush
