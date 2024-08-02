@extends('layouts.app')

@section('title', 'Formulir Setting')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Formulir Setting',
            'url' => '/admin/layanan-informasi/formulir',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <a class="btn bg-green-primary" href="/admin/layanan-informasi/formulir/create">
                    Tambah Formulir
                </a>
                <form action="/admin/layanan-informasi/formulir" method="GET">
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
                                <th>Nama</th>
                                <th>Url Google Form</th>
                                <th>Form File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formulirs as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <a href="{{ $item->google_form_url }}" target="_blank">{{ $item->google_form_url }}</a>
                                </td>
                                <td><a href="{{ $item->form_file_url }}" target="_blank">Lihat</a></td>
                                <td>
                                    <a href="/admin/layanan-informasi/formulir/{{ $item->id }}/edit" class="btn bg-green-primary">
                                        Edit
                                    </a>
                                    <button class="btn bg-green-primary" onclick="openModalDelete('{{ $item->id }}')">
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
            {{ $formulirs->links() }}
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
        $('#modalDeleteForm').attr('action', '/admin/layanan-informasi/formulir/' + id);
    }
</script>
@endpush
