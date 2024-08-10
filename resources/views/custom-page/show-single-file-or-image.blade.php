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
            <p class="text-center my-5">
                @php
                    $file_url = $page->file_url;
                    $file_extension = strtolower(pathinfo($file_url, PATHINFO_EXTENSION));   
                @endphp
                @if ($file_extension == 'pdf')
                    <embed src="{{ $page->file_url }}" type="application/pdf" width="100%" height="600px">
                @else
                    <img src="{{ $page->file_url }}" alt="baznas jabar" class="mx-auto" style="max-width: 80%">
                @endif
            </p>
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

