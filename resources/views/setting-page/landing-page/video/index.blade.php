@extends('layouts.app')

@section('title', 'Landing Page Settings')

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
            'name' =>'video Setting',
            'url' => '/admin/landing-page-setting/video-setting',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    Add New video
                </button>
            </div>
            <div class="col-md-12 py-2 my-1">
              <div class="row justify-content-center p-3 mb-2" id="videoShow">
                  @forelse ($videos as $video)
                  <div class="col-md-6 p-2">
                    <h3>
                      {{ $video->title }} - <small class="text-muted">{{ $video->description }}</small>
                    </h3>
                    {!! $video->video_url !!}
                    @if (!$video->video_url)
                    <div class="w-100 d-flex align-items-center justify-content-center m-2" style="height: 315px; border-radius: 10px; background-color: #f0f0f0">
                        <p>Url Tidak Valid</p>
                    </div>
                    @endif
                    <div class="d-flex justify-content-end gap-2">
                      <button class="btn bg-green-primary" onclick="openModalEdit('{{$video->id}}', '{{$video->title}}', '{{$video->description}}', '{{$video->original_video_url}}')">
                        Edit
                      </button>
                      <button class="btn bg-red-danger" onclick="openModalDelete('{{$video->id}}')">
                        Delete
                      </button>
                    </div>
                  </div>
                  @empty
                  <div class="col-12">
                      <div class="alert alert-warning" role="alert">
                          No video found
                      </div>
                  </div>
                  @endforelse
              </div>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-center">
            {{ $videos->links() }}
        </div>
    </div>
</div>

{{-- modal add --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalAddLabel">Add Video</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/admin/landing-page-setting/video-setting" method="post" id="modalAddForm">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Judul Video</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">Url Video</label>
                <input type="text" class="form-control" id="url" name="url">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-green-primary" onclick="$('#modalAddForm').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditLabel">Edit Slide</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/admin/landing-page-setting/video-setting" method="post" enctype="multipart/form-data" id="modalEditForm">
            @csrf
            @method('put')
            <div class="mb-3">
              <label for="title" class="form-label">Judul Video</label>
              <input type="text" class="form-control" id="title_edit" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" id="description_edit" name="description">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">Url Video</label>
                <input type="text" class="form-control" id="url_edit" name="url">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-green-primary" onclick="$('#modalEditForm').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- modal delete --}}
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDeleteLabel">Delete Slide</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure want to delete this video?</p>
        <form action="" method="post" id="modalDeleteForm" style="display: none;" id="modalDeleteForm">
            @csrf
            @method('delete')
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-green-primary" onclick="$('#modalDeleteForm').submit()">Delete</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
    <style>
        #videoShow .col-md-6 > iframe {
            width: 100%;
            border-radius: 10px;
        }
    </style>
@endpush

@push('scripts')
<script>
    function openModalEdit(id, title, description, original_url) {
        $('#modalEdit').modal('show');
        $('#modalEditForm').attr('action', '/admin/landing-page-setting/video-setting/' + id);
        $('#title_edit').val(title);
        $('#description_edit').val(description);
        $('#url_edit').val(original_url);
    }

    function openModalDelete(id) {
        $('#modalDelete').modal('show');
        $('#modalDeleteForm').attr('action', '/admin/landing-page-setting/video-setting/' + id);
    }
</script>
@endpush
