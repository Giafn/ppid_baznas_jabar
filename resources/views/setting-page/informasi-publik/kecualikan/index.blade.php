@extends('layouts.app')

@section('title', 'Informasi Publik Dikecualikan')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Informasi Publik Dikecualikan',
            'url' => '/admin/informasi-publik/dikecualikan',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    Tambah Informasi
                </button>
                <form action="/admin/informasi-publik/dikecualikan" method="GET">
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
                                <th>Nama</th>
                                <th>Url File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <a href="{{ $item->url }}" target="_blank" class="btn bg-green-primary mt-2">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn bg-green-primary" data-pertanyaan="{{ $item->pertanyaan }}" data-content_jawaban="{{ $item->content_jawaban }}" onclick="openModalEdit('{{ $item->id }}')" id="btnEdit-{{ $item->id }}">
                                        Edit
                                    </button>
                                    <button class="btn bg-green-primary" onclick="openModalDelete('{{ $item->id }}')">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-end">
            {{ $items->links() }}
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="/admin/informasi-publik/dikecualikan" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Informasi Publik Dikecualikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Url File</label>
                        <input type="text" class="form-control" id="url" name="url" required>
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
    <div class="modal-dialog modal-lg">
        <form id="modalEditForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Informasi Publik Dikecualikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_edit" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="url_edit" class="form-label">Url File</label>
                        <input type="text" class="form-control" id="url_edit" name="url" required>
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
                    <h5 class="modal-title" id="modalDeleteLabel">Delete Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data ini?
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    function openModalDelete(id) {
        $('#modalDelete').modal('show');
        $('#modalDeleteForm').attr('action', '/admin/informasi-publik/dikecualikan/' + id);
    }

    function openModalEdit(id) {
        // call ajax
        $('#nama_edit').val('')
        $('#url_edit').val('')
        $.ajax({
            url: '/admin/informasi-publik/dikecualikan/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                data = response.data;
                $('#nama_edit').val(data.nama);
                $('#url_edit').val(data.url);
                $('#modalEditForm').attr('action', '/admin/informasi-publik/dikecualikan/' + id);
                $('#modalEdit').modal('show');
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
    // document ready
    $(document).ready(function() {
        $('#content_jawaban').summernote(summernoteSetting);
    });
</script>
@endpush
