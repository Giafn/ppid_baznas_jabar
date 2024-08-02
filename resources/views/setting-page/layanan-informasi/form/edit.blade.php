@extends('layouts.app')

@section('title', 'Formulir Setting - Create')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Formulir Setting',
            'url' => '/admin/layanan-informasi/formulir',
        ],
        [
            'name' =>'Edit -' . $formulir->id,
            'url' => '/admin/layanan-informasi/formulir/' . $formulir->id
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/layanan-informasi/formulir/{{ $formulir->id }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama') ?? $formulir->nama }}">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input class="form-control" id="deskripsi" name="deskripsi" required value="{{ old('deskripsi') ?? $formulir->deskripsi }}">
                    </div>
                    <div class="mb-3">
                        <label for="google_form_url" class="form-label">Url Google Form</label>
                        <input type="text" class="form-control" id="google_form_url" name="google_form_url" required value="{{ old('google_form_url') ?? $formulir->google_form_url }}">
                        <iframe src="{{ old('google_form_url') ?? $formulir->google_form_url }}" width="100%" height="500" id="previewForm" class="{{ old('google_form_url') || $formulir->google_form_url ? '' : 'd-none' }} mt-2"></iframe>
                    </div>
                    <div class="mb-3">
                        <label for="form_file" class="form-label">Form File</label>
                        <input class="form-control" type="file" id="form_file" name="form_file" accept=".pdf">
                        <iframe src="{{ $formulir->form_file_url }}" width="100%" height="500" class="mt-2"></iframe>
                    </div>
                    <button type="submit" class="btn bg-green-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
    $('#google_form_url').on('input', function() {
        // delay 5detik
        setTimeout(() => {
            $('#previewForm').attr('src', $(this).val());
            $('#previewForm').removeClass('d-none');
        }, 2000);
    });
</script>
@endpush
