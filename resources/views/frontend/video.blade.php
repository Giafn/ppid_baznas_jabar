@extends('layouts.client')

@section('content')
<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-12">
            <h3 class="text-green-primary fw-bold text-center mb-5">
                Video Baznas Jabar
            </h3>
            <form action="{{ route('video') }}" method="GET">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10 col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Cari Video" name="search" value="{{ request()->get('search') }}">
                                <button class="btn bg-green-primary text-white" type="submit">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row justify-content-center p-3 mb-4" id="videoShow">
                @forelse ($videos as $video)
                  <div class="col-md-6 p-2">
                    {!! $video->video_url !!}
                    <h3 class="mb-2">
                      {{ $video->title }}<small class="text-muted">{{ $video->description != '-' && $video->description ? ' - ' . $video->description : '' }}</small>
                    </h3>
                    @if (!$video->video_url)
                    <div class="w-100 d-flex align-items-center justify-content-center m-2" style="height: 315px; border-radius: 10px; background-color: #f0f0f0">
                        <p>Url Tidak Valid</p>
                    </div>
                    @endif
                  </div>
                @empty
                  <div class="col-12">
                      <div class="text-center" role="alert">
                            Data Belum Tersedia
                      </div>
                  </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        #videoShow .col-md-6 > iframe {
            width: 100%;
            border-radius: 10px;
        }
    </style>
@endpush

@push('js')
@endpush

