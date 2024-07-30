@extends('layouts.app')

@section('title', 'Informasi Setting')

@php
    $itemBc = [
        [
            'name' =>'Setting - Landing Page',
            'url' => '/admin/landing-page-setting',
        ],
        [
            'name' =>'Informasi Setting',
            'url' => '/admin/landing-page-setting/informasi-setting',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <a class="btn bg-green-primary" href="/admin/landing-page-setting/informasi-setting/create">
                    Tambah Informasi
                </a>
                {{-- search judul --}}
                <form action="/admin/landing-page-setting/informasi-setting" method="GET">
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" placeholder="Cari judul" name="search" value="{{ request()->get('search') }}">
                        <button class="btn bg-green-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Publikasi</th>
                                <th>Url</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->image }}" alt="{{ $item->title }}" style="max-width: 100px;">
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($item->posting_at)) }}</td>
                                <td>{{ $item->url }}</td>
                                <td>
                                    <a href="/admin/landing-page-setting/informasi-setting/{{ $item->id }}/edit" class="btn bg-green-primary">
                                        Edit
                                    </a>
                                    <button onclick="openModalDelete('{{ $item->id }}')" class="btn bg-green-primary">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-end">
            {{ $data->links() }}
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
        $('#modalDeleteForm').attr('action', '/admin/landing-page-setting/informasi-setting/' + id);
    }
</script>
@endpush
