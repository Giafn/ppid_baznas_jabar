@extends('layouts.app')

@section('title', 'Items Layanan Informasi')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Items Layanan Informasi',
            'url' => '/admin/layanan-informasi/list',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <a class="btn bg-green-primary" href="/admin/layanan-informasi/list/create">
                    Tambah Layanan Baru
                </a>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Tombol</th>
                                <th>type</th>
                                <th>url</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a>
                                    </td>
                                    <td>
                                        <a href="/admin/layanan-informasi/list/{{ $item->id }}/edit" class="btn bg-green-primary">Edit</a>
                                        <button onclick="openModalDelete(`{{ $item->id }}`)" class="btn bg-green-primary">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-center">
            {{ $data->links() }}
        </div>
    </div>
</div>


<!-- Modal -->
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
                    Are you sure want to delete this data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-green-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-green-primary">Yes</button>
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
        $('#modalDeleteForm').attr('action', '/admin/layanan-informasi/list/' + id);
    }
</script>
@endpush
