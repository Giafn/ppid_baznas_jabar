@extends('layouts.app')

@section('title', 'Kantor Layanan Setting')

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
            'name' =>'Kantor Layanan Setting',
            'url' => '/admin/landing-page-setting/kantor-layanan',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    Tambah Kantor Layanan
                </button>
                <form action="/admin/landing-page-setting/kantor-layanan" method="GET">
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" placeholder="Cari" name="search" value="{{ request()->get('search') }}">
                        <button class="btn bg-green-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kantor</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->nama_kantor }}</td>
                                <td>
                                    {{ $item->alamat }}
                                </td>
                                <td>
                                    {{ $item->email }}
                                </td>
                                <td>
                                    {{ $item->telepon }}
                                </td>
                                <td>
                                    <button class="btn bg-green-primary" data-nama="{{ $item->nama_kantor }}" data-alamat="{{ $item->alamat }}" data-email="{{ $item->email }}" data-telepon="{{ $item->telepon }}" onclick="openModalEdit('{{ $item->id }}')" id="btnEdit-{{ $item->id }}">
                                        Edit
                                    </button>
                                    <button class="btn bg-green-primary" onclick="openModalDelete('{{ $item->id }}')">
                                        Delete
                                    </button>
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
            {{ $data->links() }}
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/landing-page-setting/kantor-layanan" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Kantor Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="number" class="form-control" id="no_telepon" name="no_telepon" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-green-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-green-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="modalEditForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Kategori Halaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namaEdit" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="namaEdit" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamatEdit" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamatEdit" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emailEdit" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailEdit" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_teleponEdit" class="form-label">No Telepon</label>
                        <input type="number" class="form-control" id="no_teleponEdit" name="no_telepon" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-green-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-green-primary">Save</button>
                </div>
            </div>
        </form>
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
                    Apakah anda yakin ingin menghapus kantor-layanan ini?
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
        $('#modalDeleteForm').attr('action', '/admin/landing-page-setting/kantor-layanan/' + id);
    }

    function openModalEdit(id) {
        $('#modalEdit').modal('show');
        let nama = $('#btnEdit-' + id).data('nama');
        let alamat = $('#btnEdit-' + id).data('alamat');
        let email = $('#btnEdit-' + id).data('email');
        let telepon = $('#btnEdit-' + id).data('telepon');

        $('#modalEditForm').attr('action', '/admin/landing-page-setting/kantor-layanan/' + id);
        $('#namaEdit').val(nama);
        $('#alamatEdit').val(alamat);
        $('#emailEdit').val(email);
        $('#no_teleponEdit').val(telepon);
    }
</script>
@endpush
