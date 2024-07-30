@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h3 class="text-center fw-bolder mb-3 text-green-primary">
                {{ $data->title }}
            </h3>
            <small>
                <div class="text-center fw-bold">{{ $data->slug }}</div>
                <p class="text-center my-3">
                    <i class="fas fa-calendar-alt"></i> {{ $data->created_at->format('d F Y') }}
                </p>
            </small>
            <p class="text-center my-5">
                <img src="{{ $data->image }}" alt="baznas jabar" class="mx-auto">
            </p>
            {!! $data->content !!}
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

