@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h3 class="text-center fw-bolder mb-3 text-green-primary">
                Informasi Publik Dikecualikan
            </h3>
            <div class="row">
                    @forelse ($items as $item)
                        <div class="col-lg-4 col-md-6 py-2"> 
                            <div class="p-3 rounded bg-white shadow">
                                <iframe src="{{ $item->url }}"
                                        width="100%" 
                                        allow="autoplay">
                                </iframe>
                                <a href="{{ $item->url }}" class="btn text-green-primary fs-5 d-block" target="_blank">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1">
                                            {{ $item->nama }}
                                        </div>
                                        <div>
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 mb-4">
                            <h4 class="text-green-primary">Data Belum Tersedia</h4>
                        </div>
                    @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    iframe {
        height: 200px;
        border: none;
    }

    /* md */
    @media (min-width: 768px) {
        iframe {
            height: 300px;
        }
    }

    /* lg */
    @media (min-width: 992px) {
        iframe {
            height: 400px;
        }
    }
</style>
@endpush

@push('js')
@endpush

