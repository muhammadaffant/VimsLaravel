{{-- <div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
        @if ($sliders->isNotEmpty())
            @foreach ($sliders as $slider)
                <div class="item" style="background-image: url({{ Storage::url($slider->slider_img) }})">
                    <div class="container-fluid">
                        <div class="caption bg-color vertical-center text-left">
                            <div class="big-text fadeInDown-1"> {{ $slider->title }}</div>
                            <div class="excerpt fadeInDown-2 hidden-xs"> <span>
                                </span> </div>
                                <div class="button-holder fadeInDown-3"> <a href="#"
                                    class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop
                                    Now</a> </div>
                        </div>
                        <!-- /.caption -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
            @endforeach
        @else
            <div class="text-danger pb-2">Tidak ada item</div>
        @endif
    </div>
    <!-- /.owl-carousel -->
</div> --}}

<div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
        @if ($sliders->isNotEmpty())
            @foreach ($sliders as $slider)
                <div class="item" style="background-image: url({{ Storage::url($slider->slider_img) }})">
    <div class="container">
        <div class="row">
            <div class="text col-md-8 d-flex flex-column justify-content-center">
                <h1 class="display-4" style="margin-top: 100px">Selamat Datang DI Viary Konveksi</h1>
                <p class="lead mt-3">{{ $slider->description }}</p>
                <a href="{{ route('user.customorder') }}" class="btn btn-primary btn-lg mt-3">Buat Sekarang</a>
            </div>
        </div>
    </div>
                    <!-- /.container-fluid -->
                </div>
            @endforeach
        @else
            <div class="text-danger pb-2">Tidak ada item</div>
        @endif
    </div>
    <!-- /.owl-carousel -->
</div>

<style>
    .text {
        color: #157ed2;
        font-weight: 900;
    }
</style>

