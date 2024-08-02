@extends('layouts.app')

@section('title', 'Informasi Setting - Create')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Landing Page',
            'url' => '/admin/landing-page-setting',
        ],
        [
            'name' =>'Informasi Setting',
            'url' => '/admin/landing-page-setting/informasi-setting',
        ],
        [
            'name' =>'Create',
            'url' => '/admin/landing-page-setting/informasi-setting/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/landing-page-setting/informasi-setting" method="POST" enctype="multipart/form-data" id="formWithEditor">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Deskripsi Singkat</label>
                        <input class="form-control" id="short_description" name="short_description" required value="{{ old('short_description') }}">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input class="form-control" type="file" id="image" name="image" required accept="image/*">
                        <img id="imagePreview" class="mt-2" style="max-width: 200px;">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') }}">
                    </div>
                    <div class="mb-3">
                        <label for="publish_at" class="form-label">Publish Pada</label>
                        <input type="datetime-local" class="form-control" id="publish_at" name="publish_at" required value="{{ old('publish_at') ?? date('Y-m-d\TH:i') }}">
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
@endpush
