@extends('layouts.app')

@section('title', 'Setting Faqs')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Setting Faqs',
            'url' => '/admin/faqs',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    Tambah Faqs
                </button>
                <form action="/admin/faqs" method="GET">
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" placeholder="Cari Form" name="search" value="{{ request()->get('search') }}">
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
                                <th>Pertanyaan</th>
                                <th>Jawaban</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategori as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->pertanyaan }}</td>
                                <td>
                                    {{ $item->content_jawaban }}
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
            {{ $kategori->links() }}
        </div>
    </div>
</div>

{{-- modal create --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/faqs" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Setting Faqs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pertanyaan" class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="content_jawaban" class="form-label">Jawaban</label>
                        <textarea class="form-control" id="content_jawaban" name="content_jawaban" required></textarea>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Setting Faqs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pertanyaanEdit" class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control" id="pertanyaanEdit" name="pertanyaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="content_jawabanEdit" class="form-label">Jawaban</label>
                        <textarea class="form-control" id="content_jawabanEdit" name="content_jawaban" required></textarea>
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
@endpush

@push('scripts')
<script>
    function openModalDelete(id) {
        $('#modalDelete').modal('show');
        $('#modalDeleteForm').attr('action', '/admin/faqs/' + id);
    }

    function openModalEdit(id) {
        $('#modalEdit').modal('show');
        let pertanyaan = $('#btnEdit-' + id).data('pertanyaan');
        let content_jawaban = $('#btnEdit-' + id).data('content_jawaban');
        $('#modalEditForm').attr('action', '/admin/faqs/' + id);
        $('#pertanyaanEdit').val(pertanyaan);
        $('#content_jawabanEdit').val(content_jawaban);

    }
</script>
@endpush
