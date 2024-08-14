@extends('layouts.app')

@section('title', 'Informasi Publik Setiap Saat - Edit')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Informasi Publik Setiap Saat',
            'url' => '/admin/informasi-publik/setiap-saat',
        ],
        [
            'name' =>'Edit - ' . $item->id,
            'url' => '/admin/informasi-publik/setiap-saat/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/informasi-publik/setiap-saat/{{ $item->id }}" method="POST" id="formWithEditor">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Informasi</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') ?? $item->nama }}">
                    </div>
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select class="form-select" id="group" name="group">
                            @foreach ($groups as $group)
                                <option value="{{ $group }}" {{ old('group') == $group || $item->group == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control {{ old('newGroup') ? '' : 'd-none' }}" id="newGroupInput" name="group" value="{{ old('group') }}" placeholder="Nama Group Baru">
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" id="newGroup" name="newGroup" value="1" {{ old('newGroup') ? 'checked' : '' }}>
                        <label for="newGroup">Buat Group Baru</label>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="content" {{ old('type') == 'content' || $item->type == 'page' ? 'selected' : '' }}>Konten</option>
                            <option value="url" {{ old('type') == 'url' || $item->type == 'url' ? 'selected' : '' }}>Url</option>
                        </select>
                    </div>
                    <div class="mb-3" id="contentInput">
                        <label for="content" class="form-label">Konten</label>
                        <div id="editor"></div>
                        <input name="content" id="contentTarget" style="display: none;" value="{{ old('content') ?? ($item->page ? $item->page->content : '') }}">
                    </div>
                    <div class="mb-3" id="urlInput">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url') ?? $item->url }}">
                    </div>
                    {{-- @if (old())
                        @dd(old())  
                    @endif --}}
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
        resetEditor()
        if ($(this).val() == 'content') {
            $('#contentInput').removeClass('d-none');
            $('#urlInput').addClass('d-none');
        } else {
            $('#contentInput').addClass('d-none');
            $('#urlInput').removeClass('d-none');
        }
    });

    $('#newGroup').on('change', function() {
        if ($(this).is(':checked')) {
            $('#newGroupInput').removeClass('d-none');
            $('#group').addClass('d-none');
            $('#newGroupInput').attr('name', 'group');
            $('#group').attr('name', '');
        } else {
            $('#newGroupInput').addClass('d-none');
            $('#group').removeClass('d-none');
            $('#newGroupInput').attr('name', '');
            $('#group').attr('name', 'group');
        }
    });

    // Ensure the correct initial state
    $(document).ready(function() {
        if ($('#newGroup').is(':checked')) {
            $('#newGroupInput').removeClass('d-none');
            $('#group').addClass('d-none');
            $('#newGroupInput').attr('name', 'group');
            $('#group').attr('name', '');
        }

        // trigger change group isi input group
        $('#newGroup').trigger('change');
    });

    // onchange group isi input group
    $('#group').on('change', function() {
        $('#newGroupInput').val($(this).val());
    });
    
    @if (old('type') == 'url' || $item->type == 'url')
        $('#contentInput').addClass('d-none');
        $('#urlInput').removeClass('d-none');
    @else
        $('#contentInput').removeClass('d-none');
        $('#urlInput').addClass('d-none');
    @endif
</script>
@endpush
