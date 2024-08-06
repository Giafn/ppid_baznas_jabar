@extends('layouts.app')

@section('title', 'Informasi Publik Setiap Saat - Create')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Informasi Publik Setiap Saat - Create',
            'url' => '/admin/informasi-publik/setiap-saat',
        ],
        [
            'name' =>'Create',
            'url' => '/admin/informasi-publik/setiap-saat/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/informasi-publik/setiap-saat" method="POST" id="formWithEditor">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Informasi</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                    </div>
                    @if ($groups->count() > 0)
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select class="form-select" id="group" name="group" required>
                            @foreach ($groups as $group)
                                <option value="{{ $group }}" {{ old('group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control {{ old('newGroup') ? '' : 'd-none' }}" id="newGroupInput" name="group" value="{{ old('group') }}" placeholder="Nama Group Baru">
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" id="newGroup" name="newGroup" value="1" {{ old('newGroup') ? 'checked' : '' }}>
                        <label for="newGroup">Buat Group Baru</label>
                    </div>
                    @else
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <input type="text" class="form-control" id="group" name="group" required value="{{ old('group') }}">
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>Url</option>
                            <option value="content" {{ old('type') == 'content' ? 'selected' : '' }}>Konten</option>
                            <option value="
                        </select>
                    </div>
                    <div class="mb-3 {{ old('type') != 'url' ? '' : 'd-none' }}" id="contentInput">
                        <label for="content" class="form-label">Konten</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') }}">
                    </div>
                    <div class="mb-3 {{ old('type') == 'url' ? '' : 'd-none' }}" id="urlInput">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
                    </div>
                    {{-- checkbox tambahkan list items --}}
                    <div class="mb-3">
                        <input type="checkbox" id="addListItems" name="addListItems" value="1" {{ old('addListItems') ? 'checked' : '' }}>
                        <label for="addListItems">Tambahkan List Items</label>
                    </div>
                    <div class="mb-3 {{ old('addListItems') ? '' : 'd-none' }}" id="listItemsInput">
                        <label for="listItems" class="form-label">List Items</label>
                        <button type="button" class="btn btn-sm bg-green-primary float-end" id="btnAddListItem">Tambah Item</button>
                        <div id="listItemsEditor" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Url</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="listItemsBody">
                                    @if (old('listItems'))
                                        @foreach (json_decode(old('listItems')) as $key => $listItem)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $listItem->nama }}</td>
                                                <td>{{ $listItem->url }}</td>
                                                <td>
                                                    <button type="button" class="btn bg-green-primary btn-sm" onclick="editListItem({{ $key }})">Edit</button>
                                                    <button type="button" class="btn bg-green-primary btn-sm" onclick="deleteListItem({{ $key }})">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">Tambahkan List Items</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        <input name="listItems" id="listItemsTarget" style="display: none;" value="{{ old('listItems') }}">
                    </div>
                    <button type="submit" class="btn bg-green-primary">Submit</button>
                </form>
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
        $('#url').val('');
        resetEditor();
        $('.ck-content.ck-editor__editable').html('');
        if ($(this).val() == 'content') {
            $('#contentInput').removeClass('d-none');
            $('#urlInput').addClass('d-none');
            $('#previewForm').addClass('d-none');
        } else {
            $('#contentInput').addClass('d-none');
            $('#urlInput').removeClass('d-none');
            $('#previewForm').removeClass('d-none');
        }
    });

    $('#newGroup').on('change', function() {
        if ($(this).is(':checked')) {
            $('#newGroupInput').removeClass('d-none');
            $('#group').addClass('d-none');
        } else {
            $('#newGroupInput').addClass('d-none');
            $('#group').removeClass('d-none');
        }
    });

    $('#addListItems').on('change', function() {
        if ($(this).is(':checked')) {
            $('#listItemsInput').removeClass('d-none');
        } else {
            $('#listItemsInput').addClass('d-none');
        }
    });

    // Ensure the correct initial state
    $(document).ready(function() {
        if ($('#newGroup').is(':checked')) {
            $('#newGroupInput').removeClass('d-none');
            $('#group').hide();
        }
    });

    $('#group').on('change', function() {
        $('#newGroupInput').val($(this).val());
    });

    $('#btnAddListItem').on('click', function() {
        let listItems = JSON.parse($('#listItemsTarget').val() || '[]');
        listItems.push({
            nama: '',
            url: ''
        });
        $('#listItemsTarget').val(JSON.stringify(listItems));
        renderListItems();
    });

    function renderListItems() {
        let listItems = JSON.parse($('#listItemsTarget').val() || '[]');
        let listItemsBody = '';
        listItems.forEach((listItem, index) => {
            listItemsBody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${listItem.nama}</td>
                    <td>${listItem.url}</td>
                    <td>
                        <button type="button" class="btn bg-green-primary btn-sm" onclick="editListItem(${index})">Edit</button>
                        <button type="button" class="btn bg-green-primary btn-sm" onclick="deleteListItem(${index})">Delete</button>
                    </td>
                </tr>
            `;
        });
        $('#listItemsBody').html(listItemsBody);
    }

    function editListItem(index) {
        let listItems = JSON.parse($('#listItemsTarget').val() || '[]');
        let listItem = listItems[index];
        $('#listItemsBody tr').eq(index).html(`
            <td>${index + 1}</td>
            <td><input type="text" class="form-control" value="${listItem.nama}" oninput="updateListItem(${index}, 'nama', this.value)"></td>
            <td><input type="text" class="form-control" value="${listItem.url}" oninput="updateListItem(${index}, 'url', this.value)"></td>
            <td>
                <button type="button" class="btn bg-green-primary btn-sm" onclick="editListItem(${index})">Edit</button>
                <button type="button" class="btn bg-green-primary btn-sm" onclick="deleteListItem(${index})">Delete</button>
            </td>
        `);
    }

    function updateListItem(index, key, value) {
        let listItems = JSON.parse($('#listItemsTarget').val() || '[]');
        listItems[index][key] = value;
        $('#listItemsTarget').val(JSON.stringify(listItems));
    }

    function deleteListItem(index) {
        let listItems = JSON.parse($('#listItemsTarget').val() || '[]');
        listItems.splice(index, 1);
        $('#listItemsTarget').val(JSON.stringify(listItems));
        renderListItems();
    }

    @if (old('type') == 'url')
        $('#contentInput').addClass('d-none');
        $('#urlInput').removeClass('d-none');
    @else
        $('#contentInput').removeClass('d-none');
        $('#urlInput').addClass('d-none');
    @endif
</script>
@endpush
