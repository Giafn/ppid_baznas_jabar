@extends('layouts.app')

@section('title', 'Item Setting - Edit')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Item Layanan Informasi',
            'url' => '/admin/layanan-informasi/list',
        ],
        [
            'name' =>'Edit - ' . $item->id,
            'url' => '/admin/layanan-informasi/list/' . $item->id . '/edit',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/layanan-informasi/list/{{ $item->id }}" method="POST" id="formWithEditor">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama') ?? $item->nama }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="content" {{ old('type') == 'content' || $item->type == 'page' ? 'selected' : '' }}>Konten</option>
                            <option value="url" {{ old('type') == 'url' || $item->type == 'url' ? 'selected' : '' }}>Url</option>
                        </select>
                    </div>
                    <div class="mb-3" id="contentInput">
                        <label for="content" class="form-label">Konten</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') ?? ($item->page ? $item->page->content : '') }}">
                    </div>
                    <div class="mb-3" id="urlInput">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url') ?? $item->url }}">
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
    $('#type').on('change', function() {
        $('#url').val('');
        resetEditor()
        if ($(this).val() == 'content') {
            $('#contentInput').removeClass('d-none');
            $('#urlInput').addClass('d-none');
            $('#previewForm').addClass('d-none');
        } else {
            $('#contentInput').addClass('d-none');
            $('#urlInput').removeClass('d-none');
            $('#previewForm').removeClass('d-none');
        }
    });
</script>
@endpush
