@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h3 class="text-center fw-bolder mb-3 text-green-primary">
                Informasi Publik Serta Merta
            </h3>
            <div class="row">
                @forelse ($groupedItems as $key => $items)
                    <div class="col-12 mb-4">
                        <h4 class="text-green-primary">{{ $key }}</h4>
                        <div class="list-group">
                            @foreach ($items as $item)
                                <a href="{{ $item->url }}" class="list-group-item list-group-item-action fs-5">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1">
                                            {{ $item->nama }}
                                        </div>
                                        <div>
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="col-12 mb-4">
                        <h4 class="text-green">Data Belum Tersedia</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

