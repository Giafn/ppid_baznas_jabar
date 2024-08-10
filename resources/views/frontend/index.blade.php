@extends('layouts.client')

@section('content')

<div id="bigCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @forelse ($sliders as $key => $slider)
            <a class="carousel-item {{ $key == 0 ? 'active' : '' }}" 
            href="{{ $slider->url }}" 
            target="_blank">
            <div style="width: 100%; height: 700px; overflow: hidden;">
                <img src="{{ $slider->image_url }}" 
                    alt="{{ $slider->title ?? 'Slider Image' }}"
                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>
            </a>
        @empty
            <div class="carousel-item active">
                <div style="width: 100%; height: 700px; overflow: hidden;">
                    <img src="{{ asset('image/no-image.png') }}" 
                        alt="No Image"
                        style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                </div>
            </div>
        @endforelse
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
            @forelse ($aksesCepat as $item)
                <a href="{{ $item->url }}" class="btn bg-green-primary" target="_blank">{{ $item->nama }}</a>
            @empty
                <p>
                    No data
                </p>
            @endforelse
        </div>
    </div>
</div>

<div class="row mt-5 justify-content-center">
    <div class="col-12">
        <h3 class="text-green-primary fw-bold text-center">
            Informasi Terbaru
        </h3>
        <div class="p-3 mb-2 d-flex align-items-center justify-content-center gap-3 flex-wrap">
            @forelse ($informasi as $item)
                <div class="card border-0 shadow" style="width: 30rem;">
                    <img src="{{ $item->image }}" class="card-img-top" alt="..." style="max-height: 200px; object-fit: cover; object-position: center; width: 100%; height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ $item->url }}" class="text-decoration-none text-green-primary fw-bold">
                                {{ $item->title }}
                            </a>
                        </h5>
                        <p class="card-text">{{ $item->slug }}</p>
                    </div>
                </div>
            @empty
                <p>
                    No data
                </p>
            @endforelse
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
                @forelse ($videos as $video)
                  <div class="col-md-6 p-2">
                    {!! $video->video_url !!}
                    <h3 class="mb-2">
                      {{ $video->title }}<small class="text-muted">{{ $video->description != '-' && $video->description ? ' - ' . $video->description : '' }}</small>
                    </h3>
                    @if (!$video->video_url)
                    <div class="w-100 d-flex align-items-center justify-content-center m-2" style="height: 315px; border-radius: 10px; background-color: #f0f0f0">
                        <p>Url Tidak Valid</p>
                    </div>
                    @endif
                  </div>
                @empty
                  <div class="col-12">
                      <div class="alert alert-warning" role="alert">
                          No video found
                      </div>
                  </div>
                @endforelse
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
                        @forelse ($kantorLayanan as $item)
                            <div class="col-md-3 p-2">
                                <h5 class="fw-bold">{{ $item->nama_kantor }}</h5>
                                <p>{{ $item->alamat }}</p>
                                <b>Telp. {{ $item->telepon }}</b>
                                <p>Email: {{ $item->email }}</p>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning" role="alert">
                                    No data found
                                </div>
                            </div>
                        @endforelse
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

