@extends('layouts.app')

@section('title', 'Custom Page Setting - Create - Tampilan Video')

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
            'name' =>'Create',
            'url' => '/admin/custom-page/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/custom-page" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="single-video">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Halaman</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="sub_title" class="form-label">Sub Judul Halaman</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" required value="{{ old('sub_title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Halaman</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- url video --}}
                    <div class="mb-3">
                        <label for="url" class="form-label">URL Video</label>
                        <input type="text" class="form-control" id="url" name="url" required value="{{ old('url') }}">
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
