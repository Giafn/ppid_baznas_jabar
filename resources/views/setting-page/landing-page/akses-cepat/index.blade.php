@extends('layouts.app')

@section('title', 'Akses Cepat Setting')

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
            'name' =>'Akses Cepat Setting',
            'url' => '/admin/landing-page-setting/akses-cepat-setting',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-toggle="modal" data-target="#modalAdd">
                    Add New Button
                </button>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-center">
            {{-- {{ $sliders->links() }} --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
    function openModalEdit(id, url, posting) {
        console.log(id, url, posting);
        $('#modalEdit').modal('show');
        $('#modalEditForm').attr('action', '/admin/landing-page-setting/slider-setting/' + id);
        $('#url_edit').val(url);
        
        // convert date to yyyy-mm-dd
        posting = new Date(posting);
        posting = posting.toISOString().split('T')[0];
        $('#posting_edit').val(posting);
    }

    function openModalDelete(id) {
        $('#modalDelete').modal('show');
        $('#modalDeleteForm').attr('action', '/admin/landing-page-setting/slider-setting/' + id);
    }
</script>
@endpush
