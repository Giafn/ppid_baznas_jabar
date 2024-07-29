@extends('layouts.app')

@section('title', 'Landing Page Settings')
@section('content')
<div class="p-3 shadow rounded bg-white mb-5">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12 mb-2">
                <button class="btn bg-green-primary" data-toggle="modal" data-target="#modalAdd">
                    Add New Slider
                </button>
            </div>
            <div class="col-12">
                {{-- table responsive --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Url</th>
                                <th>Posting On</th>
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

{{-- modal add --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">
                    Add New Slider
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/landing-page-setting/slider-setting" method="post" enctype="multipart/form-data" id="modalAddForm">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-green-primary" onclick="$('#modalAddForm').submit()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">
                    Edit Slider
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/landing-page-setting/slider-setting" method="post" enctype="multipart/form-data" id="modalEditForm">
                    @csrf
                    @method('put')
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-green-primary" onclick="$('#modalEditForm').submit()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- modal delete --}}
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">
                    Delete Slider
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this slider?</p>
                <form action="" method="post" id="modalDeleteForm" style="display: none;" id="modalDeleteForm">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="$('#modalDeleteForm').submit()">Delete</button>
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
