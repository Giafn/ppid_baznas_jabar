@extends('layouts.app')

@section('title', 'Custom Page Setting - Edit - Tampilan Video')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Custom Page Setting',
            'url' => '/admin/custom-page',
        ],
        [
            'name' =>'Edit',
            'url' => '/admin/custom-page/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/custom-page" method="POST" id="formWithEditor">
                    @csrf
                    <input type="hidden" name="type" value="single-video">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Halaman</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') ?? $page->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="sub_title" class="form-label">Sub Judul Halaman</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" required value="{{ old('sub_title') ?? $page->sub_title }}">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Halaman</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori') == $item->id || $page->category_page_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- url video --}}
                    <div class="mb-3">
                        <label for="url" class="form-label">URL Video</label>
                        <input type="text" class="form-control" id="url" name="url" required value="{{ old('url') ?? $page->original_url }}">
                        <div class="mt-2">
                            @if ($embedHtml)
                            {!! $embedHtml !!}
                            @else
                            <div class="alert alert-warning" role="alert">
                                URL video tidak valid
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 {{ old('type') != 'url' ? '' : 'd-none' }}" id="contentInput">
                        <label for="content" class="form-label">Konten</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') ?? $page->content }}">
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
</script>
@endpush
