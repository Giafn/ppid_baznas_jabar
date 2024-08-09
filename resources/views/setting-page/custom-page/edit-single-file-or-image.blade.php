@extends('layouts.app')

@section('title', 'Custom Page Setting - Edit - Tampilan File/Gambar')

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
                <form action="/admin/custom-page/{{ $page->id }}" method="POST" enctype="multipart/form-data" id="formWithEditor">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="single-file-or-image">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Halaman</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') ?? $page->title }}">
                    </div>
                    {{-- sub judul --}}
                    <div class="mb-3">
                        <label for="sub_title" class="form-label">Sub Judul Halaman</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" value="{{ old('sub_title') ?? $page->sub_title }}">
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
                    <div class="mb-3">
                        <label for="file" class="form-label">File / Gambar</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png">
                        @php
                            $file = $page->file_url;
                            // cek apakah file gambar atau bukan
                            $isImage = in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']);
                        @endphp
                        @if ($isImage)
                            <img src="{{ $file }}" alt="file" class="mt-2" style="max-width: 100%">
                        @else
                            <embed src="{{ $file }}" type="application/pdf" width="100%" height="600px" class="mt-2">
                        @endif
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
