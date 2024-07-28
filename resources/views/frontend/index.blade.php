@extends('layouts.client')

@section('content')

<div id="bigCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner" style="max-height: 700px; overflow: hidden; object-fit: cover; object-position: center; width: 100%; height: 100%; display: block; transition: transform 0.6s;">
        @foreach ($sliders as $key => $slider)
        <a class="carousel-item {{ $key == 0 ? 'active' : '' }}" href="{{ $slider->url }}" target="_blank">
            <img src="{{ $slider->image_url }}" class="d-block w-100" alt="...">
        </a>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bigCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bigCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="row mt-5 justify-content-center">
    <div class="col-md-6">
        <h3 class="text-green-primary fw-bold text-center">
            Akses cepat
        </h3>
        <div class="p-md-3 mb-2 d-flex align-items-center justify-content-center gap-2 flex-wrap">
            <a href="https://baznas.go.id/" class="btn btn-block bg-green-primary" role="button" aria-pressed="true">Webiste Baznas Pusat</a>
            <a href="https://baznas.go.id/" class="btn btn-block bg-green-primary" role="button" aria-pressed="true">Layanan Pembayaran Zakat</a>
            <a href="https://baznas.go.id/" class="btn btn-block bg-green-primary" role="button" aria-pressed="true">Publikasi Baznas</a>
            <a href="https://baznas.go.id/" class="btn btn-block bg-green-primary" role="button" aria-pressed="true">Pemberitahuan</a>
            <a href="https://baznas.go.id/" class="btn btn-block bg-green-primary" role="button" aria-pressed="true">Baznas Jawa Barat</a>
            <a href="https://baznas.go.id/" class="btn btn-block bg-green-primary" role="button" aria-pressed="true">Laz Jawa Barat</a>
        </div>
    </div>
</div>

<div class="row mt-5 justify-content-center">
    <div class="col-12">
        <h3 class="text-green-primary fw-bold text-center">
            Informasi Terbaru
        </h3>
        <div class="p-3 mb-2 d-flex align-items-center justify-content-center gap-3 flex-wrap">
            <div class="card border-0 shadow" style="width: 30rem;">
                <img src="https://baznasjabar.org/images/banner/1720532247_668d3d17dd275.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="https://baznasjabar.org/">Berita 1</a>
                    </h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card border-0 shadow" style="width: 30rem;">
                <img src="https://baznasjabar.org/images/banner/1720532247_668d3d17dd275.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="https://baznasjabar.org/">Berita 1</a>
                    </h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card border-0 shadow" style="width: 30rem;">
                <img src="https://baznasjabar.org/images/banner/1720532247_668d3d17dd275.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="https://baznasjabar.org/">Berita 1</a>
                    </h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-12">
            <h3 class="text-green-primary fw-bold text-center">
                Video Baznas Jabar
            </h3>
            <div class="row justify-content-center p-3 mb-2" id="videoShow">
                <div class="col-md-6">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/lOUr57wqz1M?si=JpTzlt6ulbOkt41Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="col-md-6">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/P8Ht9h3ocU0?si=6ZBB4PHi8erO3Yeg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <hr>
    <div class="row mt-5 justify-content-center py-5">
        <div class="col-12">
            <h3 class="text-green-primary fw-bold text-center">
                Layanan Informasi Publik
            </h3>
            <div class="p-3 mb-2 row align-items-center justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-3 d-flex justify-content-center p-2">
                            <img src="{{ asset('image/icon.png') }}" alt="baznas jabar" height="200" class="mx-auto">
                        </div>
                        <div class="p-2 col-md-3">
                            <h5 class="fw-bold">Baznas Jawa Barat</h5>
                            <p>Jl. Soekarno Hatta No. 178, Cibeureum, Kota Tasikmalaya, Jawa Barat 46196</p>
                            <b>Telp. (0265) 339 000</b>
                            <p>Email: baznas@email.com</p>
                        </div>
                        <div class="p-2 col-md-3">
                            <h5 class="fw-bold">Baznas Jawa Barat</h5>
                            <p>Jl. Soekarno Hatta No. 178, Cibeureum, Kota Tasikmalaya, Jawa Barat 46196</p>
                            <b>Telp. (0265) 339 000</b>
                            <p>Email: baznas@email.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
    <style>
        #videoShow .col-md-6 > iframe {
            width: 100%;
            border-radius: 10px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // buat carousel berjalan
            $('#bigCarousel').carousel({
                interval: 10000
            });
        });
    </script>
@endpush

