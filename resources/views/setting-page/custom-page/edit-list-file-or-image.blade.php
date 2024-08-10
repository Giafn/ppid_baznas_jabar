@extends('layouts.app')

@section('title', 'Custom Page Setting - Edit - Tampilan List File/Gambar')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Custom Page Setting',
            'url' => '/admin/custom-page',
        ],
        [
            'name' =>'Edit',
            'url' => '/admin/custom-page/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/custom-page/{{ $page->id }}" method="POST" id="formWithEditor">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="list-file-or-image">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Halaman</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') ?? $page->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="sub_title" class="form-label">Sub Judul Halaman</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" required value="{{ old('sub_title') ?? $page->sub_title }}">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Halaman</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori') == $item->id || $page->category_page_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalTambahItem">Tambah Item</button>
                            {{-- tambah group --}}
                            <button type="button" class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalTambahGroup">Tambah Group</button>
                        </div>
                        <div class="row g-2 mt-3 drag-here px-3 py-4" id="list-item">
                            <div class="col-12" id="emptyItem">
                                <div class="p-3 border rounded text-center">
                                    <p class="my-auto">Belum ada item ditambahkan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- konten tambahan --}}
                    <div class="mb-3 {{ old('type') != 'url' ? '' : 'd-none' }}" id="contentInput">
                        <label for="content" class="form-label">Konten Tambahan (di tampilkan di bawah list)</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') ?? $page->content }}">
                    </div>
                    <button type="submit" class="btn bg-green-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah item --}}
<div class="modal fade" id="modalTambahItem" tabindex="-1" aria-labelledby="modalTambahItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahItemLabel">Tambah Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-item">
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-select" id="tipeSelect" name="tipe" required>
                            <option value="file">File</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="label" name="label" required>
                    </div>
                    {{-- keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                    </div>
                    <button type="submit" class="btn bg-green-primary" id="btn-tambah-item">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalEditItem" tabindex="-1" aria-labelledby="modalEditItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditItemLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-item">
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-select" id="tipeSelectEdit" name="tipe" required>
                            <option value="file">File</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="labelEdit" name="label" required>
                    </div>
                    {{-- keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keteranganEdit" name="keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="fileEdit" name="file" accept=".pdf">
                    </div>
                    <button type="submit" class="btn bg-green-primary" id="btn-edit-item">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah group --}}
<div class="modal fade" id="modalTambahGroup" tabindex="-1" aria-labelledby="modalTambahGroupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahGroupLabel">Tambah Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-group">
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="labelGroup" name="label" required>
                    </div>
                    <button type="submit" class="btn bg-green-primary" id="btn-tambah-group">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal pindah group --}}
<div class="modal fade" id="modalPindahGroup" tabindex="-1" aria-labelledby="modalPindahGroupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPindahGroupLabel">Pindah Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-pindah-group">
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select class="form-select" id="groupPindahSelect" name="group" required>
                        </select>
                    </div>
                    <button type="submit" class="btn bg-green-primary" id="btn-pindah-group">Pindah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .drag-here {
        min-height: 150px;
        border: 2px dashed #cccccc;
    }
    .col-3.draggable {
        cursor: move;
    }
</style>
@endpush

@push('scripts')
<script>
    const pageId = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    // on change tipe select
    $('#tipeSelect').on('change', function() {
        if ($(this).val() == 'file') {
            $('#file').attr('accept', '.pdf');
        } else {
            $('#file').attr('accept', 'image/*');
        }
    });

    // on change tipe select edit
    $('#tipeSelectEdit').on('change', function() {
        if ($(this).val() == 'file') {
            $('#fileEdit').attr('accept', '.pdf');
        } else {
            $('#fileEdit').attr('accept', 'image/*');
        }
        $('#fileEdit').attr('required', true);
    });

    // on submit form tambah item kirim file ke server dengan ajax post /temp-upload dan simpen di session storage
    $('#form-tambah-item').on('submit', function(e) {
        e.preventDefault();
        // get file
        var file = $('#file')[0].files[0];
        var formData = new FormData();
        formData.append('upload', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '/temp-upload',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                url = response.url;
                label = $('#label').val();
                keterangan = $('#keterangan').val();
                tipe = $('#tipeSelect').val();
                createItemElement(label, keterangan, tipe, url, 'list-item');
                $('#modalTambahItem').modal('hide');
                // clear form
                clearCreateItemForm();
            },
            error: function(err) {
                console.log(err);
            }
        });
    });


    function editItem(label, keterangan, url, type, id) {
        $('#labelEdit').val(label);
        $('#keteranganEdit').val(keterangan);
        $('#tipeSelectEdit').val(type);
        $('#fileEdit').val('').attr('accept', type == 'file' ? '.pdf' : 'image/*');
        $('#modalEditItem').modal('show');

        $('#form-edit-item').on('submit', function(e) {
            e.preventDefault();
            // get file
            var file = $('#fileEdit')[0].files[0];
            if (!file) {
                let urlBefore = $(`#${id}`).data('url');
                label = $('#labelEdit').val();
                keterangan = $('#keteranganEdit').val();
                tipe = $('#tipeSelectEdit').val();
                updateItemElement(label, keterangan, tipe, urlBefore, id);
                $('#modalEditItem').modal('hide');
                $('#fileEdit').attr('required', false);
                return;
            }
            var formData = new FormData();
            formData.append('upload', file);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '/temp-upload',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    url = response.url;
                    label = $('#labelEdit').val();
                    keterangan = $('#keteranganEdit').val();
                    tipe = $('#tipeSelectEdit').val();
                    updateItemElement(label, keterangan, tipe, url, id);
                    $('#modalEditItem').modal('hide');
                    $('#fileEdit').attr('required', false);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    }

    function deleteItem(element) {
        $(element).closest('.col-3').remove();
        checkItem();
        deleteItemData($(element).closest('.card').attr('id'));
    }

    function createItemElement(label, keterangan, type, url, idWrapper) {
        let randomIdWithUUID = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        if (type == 'file') {
            var element = `
                <div class="col-3 draggable" draggable="true">
                    <div class="card" id="${randomIdWithUUID}" data-url="${url}">
                        <embed src="${url}" type="application/pdf" width="100%" class="card-img-top" alt="${label}" style="height: 300px;">
                        <div class="position-absolute top-0 end-0 p-2">
                            <div class="d-flex gap-2">
                                <a href="${url}" target="_blank" class="btn bg-green-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <div class="dropdown">
                                    <button class="btn bg-green-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${randomIdWithUUID}')">Edit</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="deleteItem(this)">Delete</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="pindahGroup('${randomIdWithUUID}')">Pindah Group</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-2">
                                <h5 class="card-title">${label}</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-muted" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${randomIdWithUUID}')">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="text-muted" onclick="deleteItem(this)">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <p class="card-text">${keterangan}</p>
                        </div>
                    </div>
                </div>
            `;
        } else {
            var element = `
                <div class="col-3 draggable" draggable="true">
                    <div class="card" id="${randomIdWithUUID}" data-url="${url}">
                        <div class="" style="height: 300px; overflow: hidden;">
                        <img src="${url}" class="card-img-top" alt="${label}" style="object-fit: cover; width: 100%; height: 100%;">
                        <div class="position-absolute top-0 end-0 p-2">
                            <div class="d-flex gap-2">
                                <div class="dropdown">
                                    <button class="btn bg-green-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${randomIdWithUUID}')">Edit</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="deleteItem(this)">Delete</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="pindahGroup('${randomIdWithUUID}')">Pindah Group</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-2">
                                <h5 class="card-title">${label}</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-muted" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${randomIdWithUUID}')">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="text-muted" onclick="deleteItem(this)">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <p class="card-text">${keterangan}</p>
                        </div>
                    </div>
                </div>
            `;
        }
        checkItem();
        saveItem(randomIdWithUUID, label, keterangan, type, url, idWrapper);
        $(`#${idWrapper}`).append(element);
    }

    // update item element
    function updateItemElement(label, keterangan, type, url, id) {
        let idBaru = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        if (type == 'file') {
            var element = `
                <div class="card" id="${idBaru}" data-url="${url}">
                    <embed src="${url}" type="application/pdf" width="100%" class="card-img-top" alt="${label}" style="height: 300px;">
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="d-flex gap-2">
                            <a href="${url}" target="_blank" class="btn bg-green-primary">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <div class="dropdown">
                                <button class="btn bg-green-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${randomIdWithUUID}')">Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="deleteItem(this)">Delete</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="pindahGroup('${randomIdWithUUID}')">Pindah Group</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">${label}</h5>
                            <div class="d-flex gap-2">
                                <a href="#" class="text-muted" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${idBaru}')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-muted" onclick="deleteItem(this)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <p class="card-text">${keterangan}</p>
                    </div>
                </div>
            `;
        } else {
            var element = `
                <div class="card" id="${idBaru}" data-url="${url}">
                    <div class="" style="height: 300px; overflow: hidden;">
                        <img src="${url}" class="card-img-top" alt="${label}" style="object-fit: cover; width: 100%; height: 100%;">
                        <div class="position-absolute top-0 end-0 p-2">
                            <div class="d-flex gap-2">
                                <div class="dropdown">
                                    <button class="btn bg-green-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${randomIdWithUUID}')">Edit</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="deleteItem(this)">Delete</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="pindahGroup('${randomIdWithUUID}')">Pindah Group</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">${label}</h5>
                            <div class="d-flex gap-2">
                                <a href="#" class="text-muted" onclick="editItem('${label}', '${keterangan}', '${url}', '${type}', '${idBaru}')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-muted" onclick="deleteItem(this)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <p class="card-text">${keterangan}</p>
                    </div>
                </div>
            `;
        }
        checkItem();
        updateItem(id, idBaru, label, keterangan, type, url);
        // buat element baru setelah element lama
        $(`#${id}`).after(element);
        // hapus element lama
        $(`#${id}`).remove();

    }

    // pindah group
    function pindahGroup(id) {
        $('#modalPindahGroup').modal('show');
        $('#btn-pindah-group').attr('data-id', id);

        // get all group
        let groups = JSON.parse(sessionStorage.getItem('groups')) || [];
        let groupPindahSelect = $('#groupPindahSelect');
        groupPindahSelect.html('');
        groupPindahSelect.append(`
            <option value="list-item">Hapus dari group</option>
        `);
        groups.forEach(group => {
            groupPindahSelect.append(`
                <option value="${group.id}">${group.label}</option>
            `);
        });
    }

    // on submit pindah group
    $('#form-pindah-group').on('submit', function(e) {
        e.preventDefault();
        let id = $('#btn-pindah-group').attr('data-id');
        let groupId = $('#groupPindahSelect').val();
        // draggableElement = parent dari element id di atas
        let draggableElement = $(`#${id}`).parent();
        // append element ke group yang dipilih
        $(`#${groupId}`).append(draggableElement);
        updateItemGroup(id, groupId);
        $('#modalPindahGroup').modal('hide');
    });

    // cek jumlah item
    function checkItem() {
        if ($('#list-item').children().length > 0) {
            $('#emptyItem').hide();
        } else {
            $('#emptyItem').show();
        }
    }

    // clear create form
    function clearCreateItemForm() {
        $('#tipeSelect').val('file');
        $('#label').val('');
        $('#keterangan').val('');
        $('#file').val('').attr('accept', '.pdf');
    }

    // clear edit form
    function clearEditItemForm() {
        $('#labelEdit').val('');
        $('#keteranganEdit').val('');
    }

    // save item to session storage
    async function saveItem(id, label, keterangan, type, url, group = 'list-item') {
        let items = JSON.parse(sessionStorage.getItem('items')) || [];
        items.push({
            id: id,
            label: label,
            keterangan: keterangan,
            type: type,
            url: url,
            group: group == 'list-item' ? null : group
        });
        await sessionStorage.setItem('items', JSON.stringify(items));
        await updateItemAndGroupInput();
    }

    // update item to session storage
    async function updateItem(id, idBaru, label, keterangan, type, url) {
        let items = JSON.parse(sessionStorage.getItem('items')) || [];
        let index = items.findIndex(item => item.id == id);
        items[index] = {
            id: idBaru,
            label: label,
            keterangan: keterangan,
            type: type,
            url: url,
            group: items[index].group
        };
        await sessionStorage.setItem('items', JSON.stringify(items));
        await updateItemAndGroupInput();
    }

    async function saveGroup(id, label) {
        let groups = JSON.parse(sessionStorage.getItem('groups')) || [];
        groups.push({
            id: id,
            label: label
        });
        await sessionStorage.setItem('groups', JSON.stringify(groups));
        await updateItemAndGroupInput();
    }

    // update item group to session storage
    async function updateItemGroup(id, group = null) {
        // Set default value for group if it's not provided
        if (group === 'list-item') {
            group = null;
        }

        // Retrieve the items from session storage
        let items = JSON.parse(sessionStorage.getItem('items')) || [];
        
        // Find the index of the item with the given id
        let index = items.findIndex(item => item.id == id);
        
        // Check if the item was found
        if (index !== -1) {
            // Update the group property of the item
            items[index].group = group;
            
            // Save the updated items back to session storage
            await sessionStorage.setItem('items', JSON.stringify(items));
        }
        await updateItemAndGroupInput();
    }


    // delete item from session storage
    async function deleteItemData(id) {
        let items = JSON.parse(sessionStorage.getItem('items')) || [];
        let index = items.findIndex(item => item.id == id);
        items.splice(index, 1);
        await sessionStorage.setItem('items', JSON.stringify(items));
        await updateItemAndGroupInput();
    }

    $(document).ready(function() {
        sessionStorage.removeItem('items');
        sessionStorage.removeItem('groups');
        
        $(document).on('dragstart', '.draggable', function(e) {
            draggedCard = this;
            setTimeout(() => {
                $(this).hide();
            }, 0);
        });

        $(document).on('dragend', '.draggable', function(e) {
            setTimeout(() => {
                $(draggedCard).show();
                draggedCard = null;
            }, 0);
        });

        $(document).on('dragover', '.drag-here', function(e) {
            e.preventDefault();
        });

        // Handle drop
        $(document).on('drop', '.drag-here', async function(e) {
            e.preventDefault();
            if (draggedCard) {
                $(this).append(draggedCard);
                let id = $(draggedCard).children().attr('id');
                let groupId = $(this).attr('id');
                await updateItemGroup(id, groupId);
            }
        });
    });

    // fungsi tambah group
    $('#form-tambah-group').on('submit', async function(e) {
        e.preventDefault();
        let label = $('#labelGroup').val();
        let id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        let element = `
            <div class="d-flex justify-content-between mt-3" id="title-group-${id}">
                <h5>${label}</h5>
                <a href="#" class="text-muted" onclick="deleteGroup('${id}')">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
            <div class="row g-2 mt-1 drag-here px-3 py-4" id="${id}">
                <div class="col-12 text-center">
                </div>
            </div>
        `;
        let parentList = $('#list-item').parent();
        parentList.append(element);
        $('#modalTambahGroup').modal('hide');
        $('#labelGroup').val('');

        // save group to session storage
        await saveGroup(id, label);
    });

    // fungsi hapus group
    function deleteGroup(id) {
        if (!confirm('Yakin ingin menghapus group?')) {
            return;
        }
        // update group
        // cek item yang ada di dalam group
        if ($(`#${id}`).children().length > 0) {
            $(`#${id}`).children().each(function() {
                let cardId = $(this).children().attr('id');
                updateItemGroup(cardId);
            });
        }
        // pindahkan item ke #list-item
        $(`#${id}`).children().appendTo('#list-item');
        $(`#title-group-${id}`).remove();
        $(`#${id}`).remove();
        let groups = JSON.parse(sessionStorage.getItem('groups')) || [];
        let index = groups.findIndex(group => group.id == id);
        groups.splice(index, 1);
        sessionStorage.setItem('groups', JSON.stringify(groups));

        checkItem();
    }

    $(document).ready(function() {
        const scrollSpeed = 100; // Kecepatan scroll

        $(document).on('dragover', function(e) {
            const windowHeight = $(window).height();
            const mouseY = e.originalEvent.clientY;

            if (mouseY > windowHeight - 50) {
                $('html, body').scrollTop($(document).scrollTop() + scrollSpeed);
            } else if (mouseY < 50) {
                $('html, body').scrollTop($(document).scrollTop() - scrollSpeed);
            }
        });

        @php
            $oldItem = old('items');
            // json decode semua isi item
            if ($oldItem) {
                $oldItem = array_map(function($item) {
                    return json_decode($item);
                }, $oldItem);
            }

            $oldGroup = old('groups');
            // json decode semua isi group
            if ($oldGroup) {
                $oldGroup = array_map(function($group) {
                    return json_decode($group);
                }, $oldGroup);
            }
            $existingItems = $existingItems ?? null;
            $existingGroups = $existingGroups ?? null;
        @endphp
        
        // jika ada group lama
        @if ($oldGroup)
            @foreach ($oldGroup as $group)
                idGroupLama = '{{ $group->id }}';
                labelGroupLama = '{{ $group->label }}';
                element = `
                    <div class="d-flex justify-content-between mt-3" id="title-group-${idGroupLama}">
                        <h5>${labelGroupLama}</h5>
                        <a href="#" class="text-muted" onclick="deleteGroup('${idGroupLama}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <div class="row g-2 mt-1 drag-here px-3 py-4" id="${idGroupLama}">
                        <div class="col-12 text-center">
                        </div>
                    </div>
                `;
                parentList = $('#list-item').parent();
                parentList.append(element);
            @endforeach
        @elseif ($existingGroups)
            @foreach ($existingGroups as $group)
                idGroupLama = '{{ $group["id"] }}';
                labelGroupLama = '{{ $group["label"] }}';
                element = `
                    <div class="d-flex justify-content-between mt-3" id="title-group-${idGroupLama}">
                        <h5>${labelGroupLama}</h5>
                        <a href="#" class="text-muted" onclick="deleteGroup('${idGroupLama}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <div class="row g-2 mt-1 drag-here px-3 py-4" id="${idGroupLama}">
                        <div class="col-12 text-center">
                        </div>
                    </div>
                `;
                parentList = $('#list-item').parent();
                parentList.append(element);
                saveGroup(idGroupLama, labelGroupLama);
            @endforeach
        @endif

        // jika ada item lama
        @if ($oldItem)
            @foreach ($oldItem as $item)
                idItemLama = '{{ $item->id }}';
                labelItemLama = '{{ $item->label }}';
                keteranganItemLama = '{{ $item->keterangan }}';
                typeItemLama = '{{ $item->type }}';
                urlItemLama = '{{ $item->url }}';
                groupItemLama = '{{ $item->group ?? 'list-item' }}';
                createItemElement(labelItemLama, keteranganItemLama, typeItemLama, urlItemLama, groupItemLama)
            @endforeach
        @elseif ($existingItems)
            
            @foreach ($existingItems as $item)
                idItemLamaEx = '{{ $item["id"] }}';
                labelItemLamaEx = '{{ $item["label"] }}';
                keteranganItemLamaEx = '{{ $item["keterangan"] }}';
                typeItemLamaEx = '{{ $item["type"] }}';
                urlItemLamaEx = '{{ $item["url"] }}';
                groupItemLamaEx = '{{ $item["group"] ?? 'list-item' }}';
                createItemElement(labelItemLamaEx, keteranganItemLamaEx, typeItemLamaEx, urlItemLamaEx, groupItemLamaEx)
            @endforeach
        @endif
    });


    async function updateItemAndGroupInput() {
        // hapus semua input item dan group
        $('.item-input').remove();
        $('.group-input').remove();

        let items = JSON.parse(sessionStorage.getItem('items')) || [];
        let groups = JSON.parse(sessionStorage.getItem('groups')) || [];

        let form = document.getElementById('formWithEditor');

        // tambahkan item ke form
        for (let item of items) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = `items[${item.id}]`;
            input.value = JSON.stringify(item);
            input.classList.add('item-input');
            form.appendChild(input);
        }

        // tambahkan group ke form
        for (let group of groups) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = `groups[${group.id}]`;
            input.value = JSON.stringify(group);
            input.classList.add('group-input');
            form.appendChild(input);
        }
    }

</script>
@endpush
