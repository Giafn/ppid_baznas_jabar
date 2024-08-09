@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h3 class="text-center fw-bolder mb-3 text-green-primary">
                {{ $page->title }}
            </h3>
            <small>
                <div class="text-center fw-bold">{{ $page->sub_title }}</div>
            </small>
            <p class="text-center my-5" id="videoWrapper">
                @if ($embedHtml)
                    {!! $embedHtml !!}
                @else
                    <div class="alert alert-warning" role="alert">
                        URL video tidak valid
                    </div>
                @endif
            </p>
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    #videoWrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
    }

    #videoWrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
@endpush

@push('js')
@endpush

