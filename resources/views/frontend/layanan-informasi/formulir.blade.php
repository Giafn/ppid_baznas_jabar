@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h3 class="text-center fw-bolder mb-3 text-green-primary">
                {{ ucwords($formulir->nama) }}
            </h3>
            <small class="text-muted text-center d-block mb-2">
                {!! $formulir->deskripsi !!}
            </small>
            <div class="row">
                <div class="col-xl-7">
                    <iframe src="{{ $formulir->google_form_url }}" frameborder="0"
                    width="100%" height="700" id="previewForm" class=" mt-2"></iframe>
                </div>
                <div class="col-xl-5">
                    <a href="{{ $formulir->form_file_url }}" class="btn bg-green-primary w-100 mb-1" download>
                        Download Formulir
                    </a>
                    <embed src="{{ $formulir->form_file_url }}" type="application/pdf" width="100%" height="500" id="previewForm" class=" mt-2">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

