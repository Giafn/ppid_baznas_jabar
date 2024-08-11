@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h2 class="text-center fw-bolder mb-3 text-green-primary">
                {{ $page->title }}
            </h2>
            <small>
                <div class="text-center fw-bold mb-3">{{ $page->sub_title }}</div>
            </small>

            <div class="my-3 ck-content">
                {!! $page->content !!}
            </div>
            <div class="row justify-content-center">
                @php
                    $tempGroup = '';   
                @endphp
                @foreach ($items as $item)
                    @if ($item->parent_group != $tempGroup && $item->parent_group != null)
                        <div class="col-12 py-3 pb-1 text-center">
                            <h5 class="fw-bold underline">{{ $item->parent_group }}</h5>
                        </div>
                    @elseif ($tempGroup != '' && $item->parent_group != $tempGroup)
                        <hr class="w-100">
                    @endif
                    @php
                        $tempGroup = $item->parent_group;
                    @endphp
                    <div class="col-12 py-1">
                        <div class="accordion rounded-0" id="parent{{ $item->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#colapse-{{ $item->id }}" aria-expanded="false" aria-controls="colapse-{{ $item->id }}">
                                        {{ $item->title }}
                                    </button>
                                </h2>
                                <div id="colapse-{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ck-content">
                                        {!! $item->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="modalPreviewLabel">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalPreviewBody">
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .underline {
        text-decoration: underline;
    }
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@push('js')
<script>
    function openModalPreview(url) {
        let modalPreviewBody = $('#modalPreviewBody');
        modalPreviewBody.html('');
        if (url.includes('.pdf')) {
            modalPreviewBody.html(`<embed src="${url}" type="application/pdf" width="100%" height="600px" />`);
        } else {
            modalPreviewBody.html(`
            <div class="d-flex justify-content-center">
                <img src="${url}" class="img-fluid" alt="preview" />
            </div>
            `);
        }
        $('#modalPreview').modal('show');
    }
</script>
@endpush

