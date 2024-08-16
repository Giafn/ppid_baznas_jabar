@extends('layouts.client')

@section('content')
<div class="row mt-5 justify-content-center">
    <div class="col-12">
        <h3 class="text-green-primary fw-bold text-center mb-5">
            Informasi Baznas Jabar
        </h3>
        {{-- search informasi --}}
        <form action="{{ route('berita') }}" method="GET">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 col-md-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari Informasi" name="search" value="{{ request()->get('search') }}">
                            <button class="btn bg-green-primary text-white" type="submit">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                <p class="text-center">
                    Data Belum Tersedia
                </p>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $informasi->links() }}
        </div>
    </div>
</div>

@endsection

@push('css')
@endpush

@push('js')
@endpush

