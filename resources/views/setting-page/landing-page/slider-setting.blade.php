@extends('layouts.app')

@section('title', 'Landing Page Settings')
@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    Add New Slider
                </button>
            </div>
            @forelse ($sliders as $slider)
            <div class="col-md-6 py-2 my-1">
                <img src="{{ $slider->image_url }}" class="img-fluid rounded" alt="...">
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        <span>
                            Url : <a href="{{ $slider->url }}">{{ $slider->url }}</a>
                        </span>
                        <br>
                        <span>
                            Posting On : {{ date('d F Y', strtotime($slider->posting_at)) }}
                        </span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="" class="" onclick="event.preventDefault(); openModalEdit('{{ $slider->id }}', '{{ $slider->url }}', '{{ $slider->posting_at }}')">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="" class="" onclick="event.preventDefault(); openModalDelete('{{ $slider->id }}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No slider found
                </div>
            </div>
            @endforelse
        </div>
        <div class="mt-2 d-flex justify-content-center">
            {{ $sliders->links() }}
        </div>
    </div>
</div>

{{-- modal add --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalAddLabel">Add New Slide</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/landing-page-setting/slider-setting" method="post" enctype="multipart/form-data" id="modalAddForm">
            @csrf
            <div class="mb-3">
                <label for="url" class="form-label">Url</label>
                <input type="text" class="form-control" id="url" name="url">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="posting" class="form-label">Posting On</label>
                <input type="date" class="form-control" id="posting" name="posting" value="{{ date('Y-m-d') }}">
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
        <form action="/landing-page-setting/slider-setting" method="post" enctype="multipart/form-data" id="modalEditForm">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="url" class="form-label">Url</label>
                <input type="text" class="form-control" id="url_edit" name="url">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image_edit" name="image">
            </div>
            <div class="mb-3">
                <label for="posting" class="form-label">Posting On</label>
                <input type="date" class="form-control" id="posting_edit" name="posting">
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
        <p>Are you sure want to delete this slider?</p>
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
@endpush

@push('scripts')
<script>
    function openModalEdit(id, url, posting) {
        console.log(id, url, posting);
        $('#modalEdit').modal('show');
        $('#modalEditForm').attr('action', '/landing-page-setting/slider-setting/' + id);
        $('#url_edit').val(url);
        
        // convert date to yyyy-mm-dd
        posting = new Date(posting);
        posting = posting.toISOString().split('T')[0];
        $('#posting_edit').val(posting);
    }

    function openModalDelete(id) {
        $('#modalDelete').modal('show');
        $('#modalDeleteForm').attr('action', '/landing-page-setting/slider-setting/' + id);
    }
</script>
@endpush
