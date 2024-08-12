@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h2 class="text-center fw-bolder mb-3 text-green-primary">
                FAQ
            </h2>
            <small>
                <div class="text-center fw-bold mb-3">
                    Pertanyaan yang sering diajukan
                </div>
            </small>
            <div class="row justify-content-center">
                @forelse ($items as $item)
                    <div class="col-12 py-1">
                        <div class="accordion rounded-0" id="parent{{ $item->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#colapse-{{ $item->id }}" aria-expanded="false" aria-controls="colapse-{{ $item->id }}">
                                        {{ $item->pertanyaan }}
                                    </button>
                                </h2>
                                <div id="colapse-{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ck-content">
                                        {!! $item->content_jawaban !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-1">
                        <p class="text-center">Data belum tersedia</p>
                    </div>
                @endforelse
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
@endpush

