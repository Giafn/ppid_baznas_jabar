@extends('layouts.app')

@section('title', 'Akses Cepat Setting - Create')

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
        ],
        [
            'name' =>'Create',
            'url' => '/admin/landing-page-setting/acces-cepat-setting/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/landing-page-setting/akses-cepat-setting" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Informasi</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>Url</option>
                            <option value="halaman" {{ old('type') == 'halaman' ? 'selected' : '' }}>Halaman</option>
                        </select>
                    </div>
                    <div class="mb-3 {{ old('type') != 'halaman' ? '' : 'd-none' }}" id="urlInput">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
                    </div>
                    <div class="mb-3 {{ old('type') == 'halaman' ? '' : 'd-none' }}" id="halamanInput">
                        {{-- search pages berdasarkan nama dan type page --}}
                        <div class="row">
                            <div class="col-xl-7 py-1">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari halaman" id="searchPage" name="searchPage" value="{{ old('searchPage') }}">
                                    <button class="btn bg-green-primary" type="button" id="searchPageBtn">Cari</button>
                                </div>
                            </div>
                            <div class="col-xl-5 py-1">
                                <select class="form-select" id="typePage" name="typePage">
                                    {{-- disini type --}}
                                </select>
                            </div>
                        </div>
                        <div class="row bg-white mt-5" id="halamanDiv">
                            
                            
                        </div>
                        <input type="hidden" name="page_id" id="pageId" value="{{ old('page_id') }}">
                        <input type="hidden" name="url_page" id="urlPage" value="{{ old('url_page') }}">
                    </div>

                    <button type="submit" class="btn bg-green-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal preview --}}
<div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPreviewLabel">Preview</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%" height="99%"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
    $('#type').on('change', function() {
        $('#halaman').val('');
        if ($(this).val() == 'url') {
            $('#urlInput').removeClass('d-none');
            $('#halamanInput').addClass('d-none');
        } else {
            $('#urlInput').addClass('d-none');
            $('#halamanInput').removeClass('d-none');
        }
    });

    // document ready get api
    $(document).ready(function() {
        let search = '{{ old('searchPage') ?? '' }}'
        let typePage = '{{ old('typePage') ?? '' }}'

        getTypes();
        getPages(search, typePage);

        if (search) {
            $('#searchPage').val(search ?? "");
        }

        if (typePage) {
            $('#typePage').val(typePage ?? "");
        }
    });

    // search page enter
    $('#searchPage').on('keypress', function(e) {
        let search = $(this).val();
        let typePage = $('#typePage').val();
        
        if (e.which == 13) {
            e.preventDefault();
            getPages(search, typePage);
        }
    });

    // search page button
    $(document).on('click', '#searchPageBtn', function() {
        let search = $('#searchPage').val();
        let typePage = $('#typePage').val();
        getPages(search, typePage);
    });

    // select page onchange
    $(document).on('change', '#typePage', function() {
        let search = $('#searchPage').val();
        let typePage = $(this).val();
        getPages(search, typePage);
    });

    //  lihat button
    $(document).on('click', '.lihatbtn', function() {
        let url = $(this).data('url');
        $('#modalPreview iframe').attr('src', url);
        $('#modalPreview').modal('show');
    });

    // pilih button
    $(document).on('click', '.pilihBtn', function() {
        let id = $(this).data('id');
        let url = $(this).data('url');
        // cek jika id sudah dipilih
        if ($('#pageId').val() == id) {
            $('#pageId').val('');
            $('#urlPage').val('');
            $('.items-page').css('opacity', '1');
            $('.items-page').css('font-weight', 'normal');
            return;
        }
        $('#pageId').val(id);
        $('#urlPage').val(url);


        // .items-page
        
        $('.items-page').each(function() {
            if ($(this).attr('id') != `page-${id}`) {
                $(this).css('opacity', '0.5');
                $(this).css('font-weight', 'normal');
            } else {
                $(this).css('opacity', '1');
                $(this).css('font-weight', 'bold');
            }
        });

        
    });

    function getPages(search = null, typePage = null) {
        sessionStorage.setItem('search-page-akses-cepat', search);
        sessionStorage.setItem('typePage-akses-cepat', typePage);
        $.ajax({
            url: '/admin/custom-page/get',
            type: 'GET',
            data: {
                search: search,
                type: typePage
            },
            success: function(response) {
                $('#halamanDiv').html('');
                data = response.data;
                let selectedId = $('#pageId').val() || null;

                let date, dateindonesia;
                data.forEach(function(item) {
                    date = new Date(item.created_at);
                    dateindonesia = date.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    $('#halamanDiv').append(`
                        <div class="col-xl-6 py-1 items-page" id="page-${item.id}">
                            <div class="p-3 rounded shadow">
                                <div class="d-flex">
                                    <div class="flex-grow-1 d-flex flex-column">
                                        <h5 class="mb-0">${item.title}</h5>
                                        <small>${item.type} - ${dateindonesia}</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-secondary lihatbtn" data-url="${item.url}">Lihat</button>
                                        <button type="button" class="btn bg-green-primary pilihBtn" data-id="${item.id}" data-url="${item.url}">Pilih</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    if (data.length == 10) {
                        $('#halamanDiv').append(`
                            <div class="col-12 py-1">
                                <div class="alert alert-info" role="alert">
                                    Data lebih dari 10, silahkan gunakan fitur search untuk mencari halaman yang diinginkan
                                </div>
                            </div>
                        `);
                    }

                    if (selectedId == item.id) {
                        $(`#page-${item.id}`).css('opacity', '1');
                        $(`#page-${item.id}`).css('font-weight', 'bold');
                    } else if (selectedId) {
                        $(`#page-${item.id}`).css('opacity', '0.5');
                        $(`#page-${item.id}`).css('font-weight', 'normal');
                    }
                });
            }
        });
    }

    function getTypes() {
        $.ajax({
            url: '/admin/custom-page/get-types',
            type: 'GET',
            success: function(response) {
                $('#typePage').html('');
                data = response.data; //objek bukan array
                $('#typePage').append(`
                    <option value="">Semua</option>
                `);
                for (const key in data) {
                    $('#typePage').append(`
                        <option value="${key}">${data[key]}</option>
                    `);
                }
            }
        });
    }

    // search page

</script>
@endpush
