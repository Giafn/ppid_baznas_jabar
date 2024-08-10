@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h3 class="text-center fw-bolder mb-3 text-green-primary">
                {{ $item->title }}
            </h3>
            <small>
                <p class="text-center my-3">
                    <i class="fas fa-calendar-alt"></i> {{ $item->created_at->format('d F Y') }}
                </p>
            </small>
            <div class="w-full ck-content">
                {!! $item->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

