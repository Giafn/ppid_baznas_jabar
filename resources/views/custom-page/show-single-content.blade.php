@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h2 class="text-center fw-bolder mb-3 text-green-primary">
                {{ $page->title }}
            </h2>
            <small>
                <div class="text-center fw-bold mb-3">{{ $page->sub_title }}</div>
            </small>
            <div class="ck-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

