@extends('layouts.app')

@section('title', 'Item Setting - Create')

@section('title', 'Informasi Publik Berkala')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Informasi Publik Berkala',
            'url' => '/admin/informasi-publik/berkala',
        ],
        [
            'name' =>'Create',
            'url' => '/admin/informasi-publik/berkala/create',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <form action="/admin/informasi-publik/berkala" method="POST" id="formWithEditor">
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
                            <option value="content" {{ old('type') == 'content' ? 'selected' : '' }}>Konten</option>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>Url</option>
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

    // Ensure the correct initial state
    $(document).ready(function() {
        if ($('#newGroup').is(':checked')) {
            $('#newGroupInput').removeClass('d-none');
            $('#group').hide();
        }
    });
</script>
@endpush
