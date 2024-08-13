@extends('layouts.app')

@section('title', 'Tender')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Tender',
            'url' => '/admin/tender',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    Tambah Tender
                </button>
                <form action="/admin/tender" method="GET">
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
                                <th>Periode</th>
                                <th>Nama</th>
                                <th>Gambar</th>
                                <th>Url</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tender as $item)
                            <tr id="row-{{ $item->id }}">
                                <td>
                                    {{ date('d/m/Y', strtotime($item->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($item->tanggal_selesai)) }}
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <img src="{{ url($item->gambar) }}" alt="{{ $item->nama }}" style="height: 250px">
                                </td>
                                <td>
                                    <a href="{{ $item->url }}" target="_blank">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status-{{ $item->id }}" {{ $item->status == 'open' ? 'checked' : '' }} data-id="{{ $item->id }}">
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn bg-green-primary" data-nama="{{ $item->nama }}" data-keterangan="{{ $item->deskripsi }}" onclick="openModalEdit('{{ $item->id }}')" id="btnEdit-{{ $item->id }}">
                                            Edit
                                        </button>
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
            {{ $tender->links() }}
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="/admin/tender" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Tender</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">Open</option>
                            <option value="0">Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" id="url" name="url" required>
                    </div>
                    {{-- tanggal mulai dan di tutup --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-xl-6">
                                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai" required>
                            </div>
                            <div class="col-xl-6">
                                <label for="tanggalTutup" class="form-label">Tanggal Tutup</label>
                                <input type="date" class="form-control" id="tanggalTutup" name="tanggal_tutup" required>
                            </div>
                        </div>
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
    <div class="modal-dialog modal-xl">
        <form id="modalEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Tender</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="statusEdit" class="form-label">Status</label>
                        <select class="form-select" id="statusEdit" name="status" required>
                            <option value="1">Open</option>
                            <option value="0">Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="namaEdit" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="namaEdit" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsiEdit" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsiEdit" name="deskripsi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambarEdit" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambarEdit" name="gambar" accept="image/*" required>
                        <div class="mt-2">
                            <img src="" alt="" id="gambarEditPreview" class="img-fluid">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="urlEdit" class="form-label">Url</label>
                        <input type="text" class="form-control" id="urlEdit" name="url" required>
                    </div>
                    {{-- tanggal mulai dan di tutup --}}
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-xl-6">
                                <label for="tanggalMulaiEdit" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggalMulaiEdit" name="tanggal_mulai" required>
                            </div>
                            <div class="col-xl-6">
                                <label for="tanggalTutupEdit" class="form-label">Tanggal Tutup</label>
                                <input type="date" class="form-control" id="tanggalTutupEdit" name="tanggal_tutup" required>
                            </div>
                        </div>
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
                    Apakah anda yakin ingin menghapus tender ini?
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
        $('#modalDeleteForm').attr('action', '/admin/tender/' + id);
    }

    function openModalEdit(id) {
        // call ajax
        $.ajax({
            url: '/admin/tender/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#modalEditForm').attr('action', '/admin/tender/' + id);
                $('#namaEdit').val(response.nama);
                $('#deskripsiEdit').text(response.desc);
                $('#urlEdit').val(response.url);
                $('#tanggalMulaiEdit').val(response.tanggal_mulai);
                $('#tanggalTutupEdit').val(response.tanggal_selesai);
                $('#statusEdit').val(response.status == 'open' ? 1 : 0);
                $('#gambarEditPreview').attr('src', '/' + response.gambar);
                $('#modalEdit').modal('show');
            },
            error: function(err) {
                alert('Terjadi kesalahan');
            }
        });
    }

    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            let id = $(this).attr('data-id');
            let status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '/admin/tender/' + id + '/status',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    alert('Status berhasil diubah');
                },
                error: function(err) {
                    alert('Terjadi kesalahan');
                }
            });
        });
    });
</script>
@endpush
