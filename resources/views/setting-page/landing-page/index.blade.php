@extends('layouts.app')

@section('title', 'Landing Page Settings')

@php
    $itemBc = [
        [
            'name' =>'Setting - Landing Page',
            'url' => '/admin/landing-page-setting',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="wrapper mb-2">
            <div class="d-flex align-items-center p-3 gap-3">
                <h3 class="text-green-primary fw-bold text-center">
                    Slider Utama
                </h3>
                <a href="/admin/landing-page-setting/slider-setting" class="btn bg-green-primary">Edit Items</a>
            </div>
            <div id="bigCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sliders as $key => $slider)
                        <a class="carousel-item {{ $key == 0 ? 'active' : '' }}" 
                        href="{{ $slider->url }}" 
                        target="_blank">
                        <div style="width: 100%; height: 500px; overflow: hidden;">
                            <img src="{{ $slider->image_url }}" 
                                alt="{{ $slider->title ?? 'Slider Image' }}"
                                style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                        </div>
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
        </div>
        <hr>
        <div class="wrapper mb-2">
            <div class="d-flex align-items-center p-3 gap-3">
                <h3 class="text-green-primary fw-bold text-center">
                    Akses Cepat 
                </h3>
                <a href="/admin/landing-page-setting/akses-cepat-setting" class="btn bg-green-primary">Edit Items</a>
            </div>
            <div class="p-md-3 mb-2 d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <a href="https://baznas.go.id/" class="btn bg-green-primary" role="button" aria-pressed="true">Webiste Baznas Pusat</a>
                <a href="https://baznas.go.id/" class="btn bg-green-primary" role="button" aria-pressed="true">Layanan Pembayaran Zakat</a>
                <a href="https://baznas.go.id/" class="btn bg-green-primary" role="button" aria-pressed="true">Publikasi Baznas</a>
                <a href="https://baznas.go.id/" class="btn bg-green-primary" role="button" aria-pressed="true">Pemberitahuan</a>
                <a href="https://baznas.go.id/" class="btn bg-green-primary" role="button" aria-pressed="true">Baznas Jawa Barat</a>
                <a href="https://baznas.go.id/" class="btn bg-green-primary" role="button" aria-pressed="true">Laz Jawa Barat</a>
            </div>
        </div>
        <hr>
        <div class="wrapper mb-2">
            <div class="d-flex align-items-center p-3 gap-3">
                <h3 class="text-green-primary fw-bold text-center">
                    Informasi Terbaru
                </h3>
                <a href="/admin/landing-page-setting/informasi-setting" class="btn bg-green-primary">Edit</a>
            </div>
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
        <hr>
        <div class="wrapper mb-2">
            <div class="d-flex align-items-center p-3 gap-3">
                <h3 class="text-green-primary fw-bold text-center">
                    Video Baznas Jabar
                </h3>
                <a href="/admin/landing-page-setting/video-setting" class="btn bg-green-primary">Edit Items</a>
            </div>
            <div class="row justify-content-center p-3 mb-2" id="videoShow">
                @forelse ($videos as $video)
                  <div class="col-md-6">
                    <h3>
                      {{ $video->title }} - <small class="text-muted">{{ $video->description }}</small>
                    </h3>
                    {!! $video->video_url !!}
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
        <hr>
        <div class="wrapper mb-2">
            <div class="d-flex align-items-center p-3 gap-3">
                <h3 class="text-green-primary fw-bold text-center">
                    Layanan Informasi Publik
                </h3>
                <a href="" class="btn bg-green-primary">Edit Items</a>
            </div>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #videoShow .col-md-6 > iframe {
        width: 100%;
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 2000
        });
    });
</script>
@endpush
