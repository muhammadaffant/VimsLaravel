@extends('frontend.main_master')

@section('title', 'Checkout')

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
            <div class="checkout-box">
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel-group checkout-steps" id="accordion">
                            <!-- checkout-step-01  -->
                            <div class="panel panel-default checkout-step-01">

                                <div id="collapseOne" class="panel-collapse collapse in">

                                    <!-- panel-body  -->
                                    <div class="panel-body">
                                        <div class="row">

                                            <!-- guest-login -->
                                            <div class="col-md-6 col-sm-6 guest-login">
                                                <h4 class="checkout-subtitle"><b>Shipping Address</b></h4>
                                                <!-- radio-form  -->
                                                <form class="register-form" role="form" method="post"
                                                    action="{{ route('user.checkout.detail') }}">
                                                    @csrf

                                                    <input type="hidden" name="province_id" id="province_id">
                                                    <input type="hidden" name="city_id" id="city_id">
                                                    <input type="hidden" name="courier" id="courier_hidden">
                                                    <input type="hidden" name="courier_service"
                                                        id="courier_service_hidden">
                                                    <input type="hidden" name="shipping_cost" id="shipping_cost_hidden">

                                                    <div class="form-group">
                                                        <label for="name" class="info-title">Nama Lengkap</label>
                                                        <input id="name" class="form-control unicase-form-control"
                                                            type="text" name="name" autocomplete="off"
                                                            placeholder="Input your name" value="{{ Auth::user()->name }}"
                                                            required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email" class="info-title">Email</label>
                                                        <input id="email" class="form-control unicase-form-control"
                                                            type="email" name="email" autocomplete="off"
                                                            placeholder="Input your email" value="{{ Auth::user()->email }}"
                                                            required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="phone" class="info-title">Phone</label>
                                                        <input id="phone" class="form-control unicase-form-control"
                                                            type="number" name="phone" autocomplete="off"
                                                            placeholder="Input your phone"
                                                            value="{{ Auth::user()->numberphone }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="post_code" class="info-title">Kode Pos</label>
                                                        <input id="post_code" class="form-control unicase-form-control"
                                                            type="text" name="post_code" autocomplete="off"
                                                            placeholder="Input your post code" required>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="notes" class="info-title">Catatan</label>
                                                        <textarea name="notes" id="notes" cols="30" rows="5" class="form-control"></textarea>
                                                    </div>


                                            </div>
                                            <!-- guest-login -->

                                            <!-- already-registered-login -->
                                            <div class="col-md-6 col-sm-6 already-registered-login">
                                                <br>
                                                <br>

                                                <div class="form-group">
                                                    <label for="courier_service" class="info-title">Pilih Jasa
                                                        Pengiriman</label>
                                                    <select name="courier_service" id="courier_service" class="form-control"
                                                        required>
                                                        <option value="">-- Pilih Jasa Pengiriman --</option>
                                                        <option value="jne">JNE</option>
                                                        <option value="pos">POS Indonesia</option>
                                                        <option value="tiki">TIKI</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="province_id" class="info-title">Pilih Provinsi</label>
                                                    <select name="province_id" id="province_id"
                                                        class="form-control select2 province_id" style="width: 100%;">
                                                        {{--  @foreach ($listProvince as $province)
                                                            <option value="{{ $province['province_id'] }}">
                                                                {{ $province['province'] }}
                                                            </option>
                                                        @endforeach  --}}
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="city_id" class="info-title">Pilih Kabupaten/Kota</label>
                                                    <select name="city_id" id="city_id"
                                                        class="form-control select2 city_id"
                                                        style="width: 100%;"></select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="courier" class="info-title">Pilih Kurir</label>
                                                    <select name="courier" id="courier" class="form-control" required>
                                                        <option value="">-- Pilih Kurir --</option>
                                                        <!-- Opsi kurir akan diisi secara dinamis melalui JavaScript -->
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class="info-title">Alamat lengkap</label>
                                                    <textarea name="address" id="address" cols="30" rows="3" class="form-control"></textarea>
                                                </div>
{{--
                                                <input type="hidden" name="courir">
                                                <input type="hidden" name="ongkir">  --}}

                                                <!-- Kurir Radio Button -->
                                                {{--  <div class="form-group" id="kurir-radio">
                                                    <label for="kurir" class="info-title">Pilih Kurir</label>
                                                    <div id="courier-options">
                                                        <!-- Options will be inserted dynamically -->
                                                    </div>
                                                </div>  --}}

                                            </div>

                                        </div>
                                    </div>

                                </div><!-- row -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- checkout-progress-sidebar -->
                        <div class="checkout-progress-sidebar ">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                    </div>
                                    <div class="">
                                        <ul class="nav nav-checkout-progress list-unstyled">
                                            @foreach ($carts as $item)
                                                <li>
                                                    <strong>Image: </strong>
                                                    <img src="{{ url($item->options->image) }}" alt=""
                                                        width="50px;" height="50px;">
                                                </li>
                                                <li>
                                                    <strong>Qty: </strong>
                                                    ({{ $item->qty }})
                                                    <strong>Color: </strong>
                                                    ({{ $item->options->color }})

                                                    <strong>Size: </strong>
                                                    ({{ $item->options->size }})
                                                </li>
                                                <hr>
                                            @endforeach
                                            <strong>Grand Total:</strong> Rp. {{ $total }}
                                            <hr>

                                            <button type="submit" class="btn btn-primary">Continue to Checkout</button>
                                            </form>
                                            <!-- radio-form  -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- checkout-progress-sidebar -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.checkout-box -->
            {{--  @include('frontend.body.brands')  --}}
        </div>
        <!-- /.container -->
    </div>
@endsection

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
@endpush
