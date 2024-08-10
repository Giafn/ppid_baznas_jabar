@extends('layouts.app')

@section('title', 'Custom Page Setting - Create - Tampilan List Konten')

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
            'name' =>'Create',
            'url' => '/admin/custom-page/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/custom-page" method="POST" id="formWithEditor">
                    @csrf
                    <input type="hidden" name="type" value="list-content">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Halaman</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="sub_title" class="form-label">Sub Judul Halaman</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" required value="{{ old('sub_title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Halaman</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
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
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') }}">
                    </div>
                    <button type="submit" class="btn bg-green-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah item --}}
<div class="modal fade" id="modalTambahItem" tabindex="-1" aria-labelledby="modalTambahItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahItemLabel">Tambah Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-item">
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="label" name="label" required>
                    </div>
                    <div class="mb-3">
                        <label for="content_list" class="form-label">Konten</label>
                        <textarea class="form-control content-list" id="contentList" name="content_list"></textarea>
                    </div>
                    <button type="submit" class="btn bg-green-primary" id="btn-tambah-item">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalEditItem" tabindex="-1" aria-labelledby="modalEditItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditItemLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-item">
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="labelEdit" name="label" required>
                    </div>
                    <div class="mb-3">
                        <label for="content_list" class="form-label">Konten</label>
                        <textarea class="form-control content-list" id="contentListEdit" name="content_list"></textarea>
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
    .accordion.draggable {
        cursor: move;
    }
    /* Summernote Additional CSS */
    .note-editable{
    background: #fff;
    }
    .note-btn.dropdown-toggle:after {
    content: none;
    }
    .note-btn[aria-label="Help"]{
    display: none;
    }

    .note-editor .note-toolbar .note-color-all .note-dropdown-menu, .note-popover .popover-content .note-color-all .note-dropdown-menu{
    min-width: 185px;
    }
    /* Customize Summernote editor */
    .note-editor {
    /* Your custom styles here */
    }

    .note-editable {
    /* Your custom styles here */
    }

    /* Toolbar customization */
    .note-toolbar {
    /* Your custom styles here */
    }

    /* Buttons customization */
    .note-btn {
    /* Your custom styles here */
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    // on open modal tambah item
    $('#modalTambahItem').on('show.bs.modal', function(e) {
        $('#label').val('');
        $('#contentList').val('');
        $('#contentList').summernote("code", "");
    });
    // dokuemnt ready
    $(document).ready(function() {
        $('.content-list').summernote({
            height: 150,
        });
    });
</script>
<script>
    const pageId = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    // on submit form tambah item kirim file ke server dengan ajax post /temp-upload dan simpen di session storage
    $('#form-tambah-item').on('submit', function(e) {
        e.preventDefault();
        let label = $('#label').val();
        let konten = $('#contentList').val();
        createItemElement(label, konten, 'list-item');
        $('#modalTambahItem').modal('hide');
    });


    function editItem(id) {
        let labelElement = $(`#label-${id}`).html();
        label = labelElement.replace(/<br>/g, "\n");
        $('#labelEdit').val(label);
        let kontenElement = $(`#konten-${id}`).html();
        konten = kontenElement;
        $('#contentListEdit').val(konten);
        $('#contentListEdit').summernote("code", konten);
        $('#modalEditItem').modal('show');

        $('#form-edit-item').on('submit', function(e) {
            e.preventDefault();
            label = $('#labelEdit').val();
            konten = $('#contentListEdit').val();
            updateItemElement(label, konten, id);
            $('#modalEditItem').modal('hide');
        });
    }

    function deleteItem(elementId) {
        if (!confirm('Yakin ingin menghapus item?')) {
            return;
        }
        let element = document.getElementById(elementId);
        $(element).closest('.col-12').remove();
        checkItem();
        deleteItemData($(element).closest('.card').attr('id'));
    }

    function createItemElement(label, konten, idWrapper) {
        let randomIdWithUUID = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        // replace single quote with html `
        konten = konten.replace(/'/g, "`");
        var element = `<div class="col-12 draggable" draggable="true">
            <div class="card" id="${randomIdWithUUID}">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold" id="label-${randomIdWithUUID}">${label}</h4>
                        <div class="d-flex gap-2">
                            <a href="#" class="text-muted" onclick="editItem('${randomIdWithUUID}')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="text-muted" onclick="deleteItem('${randomIdWithUUID}')">
                                <i class="fas fa-trash"></i>
                            </a>
                            <a href="#" class="text-muted" onclick="pindahGroup('${randomIdWithUUID}')">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div style="max-height: 200px; overflow-y: auto;" id="konten-${randomIdWithUUID}">
                        ${konten}
                    </div>
                </div>
            </div>
        </div>`;

        checkItem();
        saveItem(randomIdWithUUID, label, konten);
        $(`#${idWrapper}`).append(element);
    }

    // update item element
    function updateItemElement(label, konten, id) {
        let idBaru = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        konten = konten.replace(/'/g, "`");
        var element = `
            <div class="col-12 draggable" draggable="true">
                <div class="card" id="${idBaru}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title fw-bold" id="label-${idBaru}">${label}</h4>
                            <div class="d-flex gap-2">
                                <a href="#" class="text-muted" onclick="editItem('${idBaru}')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-muted" onclick="deleteItem('${idBaru}')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <a href="#" class="text-muted" onclick="pindahGroup('${idBaru}')">
                                    <i class="fas fa-exchange-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div style="max-height: 200px; overflow-y: auto;" id="konten-${idBaru}">
                            ${konten}
                        </div>
                    </div>
                </div>
            </div>
        `;
        checkItem();
        updateItem(id, idBaru, label, konten);
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
        let groups = JSON.parse(sessionStorage.getItem('groups-' + pageId)) || [];
        let groupPindahSelect = $('#groupPindahSelect');
        groupPindahSelect.html('');
        if ($(`#${id}`).parent().parent().attr('id') !== 'list-item') {
            groupPindahSelect.append(`
                <option value="list-item">Hapus dari group</option>
            `);
        } else if (groups.length == 0) {
            groupPindahSelect.append(`
                <option value="list-item" disabled>-- Tidak ada group --</option>
            `);
        }
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

    // save item to session storage
    async function saveItem(id, label, konten) {
        let items = JSON.parse(sessionStorage.getItem('items-' + pageId)) || [];
        items.push({
            id: id,
            label: label,
            konten: konten,
            group: null
        });
        await sessionStorage.setItem('items-' + pageId, JSON.stringify(items));
        await updateItemAndGroupInput();
    }

    // update item to session storage
    async function updateItem(id, idBaru, label, konten) {
        let items = JSON.parse(sessionStorage.getItem('items-' + pageId)) || [];
        let index = items.findIndex(item => item.id == id);
        items[index] = {
            id: idBaru,
            label: label,
            konten: konten,
            group: items[index].group
        };
        await sessionStorage.setItem('items-' + pageId, JSON.stringify(items));
        await updateItemAndGroupInput();
    }

    async function saveGroup(id, label) {
        let groups = JSON.parse(sessionStorage.getItem('groups-' + pageId)) || [];
        groups.push({
            id: id,
            label: label
        });
        await sessionStorage.setItem('groups-' + pageId, JSON.stringify(groups));
        await updateItemAndGroupInput();
    }

    // update item group to session storage
    async function updateItemGroup(id, group = null) {
        // Set default value for group if it's not provided
        if (group === 'list-item') {
            group = null;
        }

        // Retrieve the items from session storage
        let items = JSON.parse(sessionStorage.getItem('items-' + pageId)) || [];
        
        // Find the index of the item with the given id
        let index = items.findIndex(item => item.id == id);
        
        // Check if the item was found
        if (index !== -1) {
            // Update the group property of the item
            items[index].group = group;
            
            // Save the updated items back to session storage
            await sessionStorage.setItem('items-' + pageId, JSON.stringify(items));
        }
        await updateItemAndGroupInput();
    }


    // delete item from session storage
    async function deleteItemData(id) {
        let items = JSON.parse(sessionStorage.getItem('items-' + pageId)) || [];
        let index = items.findIndex(item => item.id == id);
        items.splice(index, 1);
        await sessionStorage.setItem('items-' + pageId, JSON.stringify(items));
        await updateItemAndGroupInput();
    }

    $(document).ready(function() {
        sessionStorage.removeItem('items-' + pageId);
        sessionStorage.removeItem('groups-' + pageId);
        
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
        $(document).on('drop', '.drag-here', function(e) {
            e.preventDefault();
            if (draggedCard) {
                $(this).append(draggedCard);
                let id = $(draggedCard).children().attr('id');
                let groupId = $(this).attr('id');
                updateItemGroup(id, groupId);
            }
        });
    });

    // fungsi tambah group
    $('#form-tambah-group').on('submit',async function(e) {
        e.preventDefault();
        let label = $('#labelGroup').val();
        let id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        let element = `
            <div class="d-flex justify-content-between mt-3" id="title-group-${id}">
                <h5>${label}</h5>
                <div class="d-flex gap-1">
                    <a href="#" class="text-muted" onclick="deleteGroup('${id}')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a href="#" class="text-muted" onclick="editNamaGroup('${id}')">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </div>
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
        let groups = JSON.parse(sessionStorage.getItem('groups-' + pageId)) || [];
        let index = groups.findIndex(group => group.id == id);
        groups.splice(index, 1);
        sessionStorage.setItem('groups-' + pageId, JSON.stringify(groups));

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
        @endphp
        
        // jika ada group lama
        @if ($oldGroup)
            @foreach ($oldGroup as $group)
                let idGroupLama = '{{ $group->id }}';
                let labelGroupLama = '{{ $group->label }}';
                let element = `
                    <div class="d-flex justify-content-between mt-3" id="title-group-${idGroupLama}">
                        <h5>${labelGroupLama}</h5>
                        <div class="d-flex gap-1">
                            <a href="#" class="text-muted" onclick="deleteGroup('${idGroupLama}')">
                                <i class="fas fa-trash"></i>
                            </a>
                            <a href="#" class="text-muted" onclick="editNamaGroup('${idGroupLama}')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row g-2 mt-1 drag-here px-3 py-4" id="${idGroupLama}">
                        <div class="col-12 text-center">
                        </div>
                    </div>
                `;
                let parentList = $('#list-item').parent();
                parentList.append(element);
            @endforeach
        @endif

        // jika ada item lama
        @if ($oldItem)
            @foreach ($oldItem as $item)
                let idItemLama = '{{ $item->id }}';
                let labelItemLama = '{{ $item->label }}';
                let kontenItemLama = `{!! $item->konten !!}`;
                let groupItemLama = '{{ $item->group ?? 'list-item' }}';
                createItemElement(labelItemLama, kontenItemLama, groupItemLama);
            @endforeach
        @endif
    });


    async function updateItemAndGroupInput() {
        // hapus semua input item dan group
        $('.item-input').remove();
        $('.group-input').remove();

        let items = JSON.parse(sessionStorage.getItem('items-' + pageId)) || [];
        let groups = JSON.parse(sessionStorage.getItem('groups-'+pageId)) || [];

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
