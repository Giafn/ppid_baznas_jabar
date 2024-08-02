@extends('layouts.app')

@section('title', 'Struktur Organisasi Setting')

@php
    $itemBc = [
        [
            'name' =>'Home',
            'url' => '/admin/home',
        ],
        [
            'name' =>'General - Visi Misi',
            'url' => '/admin/general/struktur-organisasi',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/general/struktur-organisasi" method="POST" id="formWithEditor">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') ?? $strukturOrganisasi->page->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') ?? $strukturOrganisasi->page->content }}">
                    </div>
                    <button type="submit" class="btn bg-green-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .ck-content {
        min-height: 50vh;
    }
</style>
@endpush

@push('scripts')
@endpush
