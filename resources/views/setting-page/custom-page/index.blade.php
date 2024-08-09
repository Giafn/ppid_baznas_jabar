@extends('layouts.app')

@section('title', 'Custom Page Setting')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Custom Page Setting',
            'url' => '/admin/custom-page',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <div class="dropdown">
                    <button class="btn bg-green-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Tambah Page
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="/admin/custom-page/create/single-file-or-image">Tampilan File/Gambar</a></li>
                        <li><a class="dropdown-item" href="/admin/custom-page/create/single-video">Tampilan Video</a></li>
                        <li><a class="dropdown-item" href="/admin/custom-page/create/list-file-or-image">Tampilan List File/Gambar</a></li>
                        <li><a class="dropdown-item" href="/admin/custom-page/create/single-content">Tampilan Konten</a></li>
                        <li><a class="dropdown-item" href="/admin/custom-page/create/list-content">Tampilan List Konten</a></li>
                    </ul>
                </div>
                <form action="/admin/custom-page" method="GET" id="formSearch">
                    <div class="row">
                        <div class="col-xl-6 mt-2">
                            <div class="input-group">
                                <select class="form-select" name="category_id">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-2">
                            <div class="input-group">
                                <select class="form-select" name="type">
                                    <option value="">Semua Type</option>
                                    @foreach ($typePages as $key => $typePage)
                                        <option value="{{ $key }}" {{ request()->get('type') == $key ? 'selected' : '' }}>
                                            {{ $typePage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari halaman" name="search" value="{{ request()->get('search') }}">
                                <button class="btn bg-green-primary" type="submit">Cari</button>
                                <a href="/admin/custom-page" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Title</th>
                                <th>Type Page</th>
                                <th>Url</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pages as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->category->nama }}</td>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    {{ $item->type }}
                                </td>
                                <td>
                                    <a href="{{ $item->url }}" target="_blank">
                                        {{ $item->url }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="/admin/custom-page/{{ $item->id }}/edit" class="btn bg-green-primary">
                                            Edit
                                        </a>
                                        <button class="btn bg-green-primary" onclick="openModalDelete('{{ $item->id }}')">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-end">
            {{ $pages->links() }}
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="modalDeleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">Delete Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus informasi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-green-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-green-primary">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
@endpush

@push('scripts')
<script>
    function openModalDelete(id) {
        $('#modalDelete').modal('show');
        $('#modalDeleteForm').attr('action', '/admin/custom-page/' + id);
    }

    // on change category dan type
    $('select[name="category_id"], select[name="type"]').on('change', function() {
        $('#formSearch').submit();
    });
</script>
@endpush
