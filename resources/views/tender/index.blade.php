@extends('layouts.client')

@section('content')
<div class="container my-3 w-100">
    <div class="row justify-content-center my-5 px-2">
        <div class="col-md-10">
            <h2 class="text-center fw-bolder mb-3 text-green-primary">
                Open Tender
            </h2>
            <small>
                <div class="text-center fw-bold mb-3">
                    Pengumuman tender terbuka Baznas Jabar
                </div>
            </small>
            <div class="row justify-content-center">
                @forelse ($items as $item)
                    <div class="col-12 py-1" {{ $item->status == 'open' ? '' : 'style= opacity:0.5' }}>
                        <div class="p-3 shadow">
                            <a {{ $item->status == 'open' ? 'href=' . $item->url  : '#' }} target="_blank">
                                <img src="{{ url( $item->gambar ) }}" class="img-fluid rounded" alt="{{ $item->nama }}">
                            </a>
                            <div class="mt-2 d-flex justify-content-between">
                                <div>
                                    <a {{ $item->status == 'open' ? 'href=""'  : '' }} class="fs-5 fw-bold text-green-primary {{ $item->status == 'open' ? 'detaiModalBtn' : '' }}" data-id="{{ $item->id }}">{{ $item->nama }}</a>
                                    <h5 class="fw-bold text-green-primary">Dibuka Sampai : {{ date('d/m/Y', strtotime($item->tanggal_selesai)) }}</h5>
                                </div>
                                <div>
                                    @if ($item->status == 'open')
                                        <span class="badge bg-green-primary float-end me-2 fs-6">Open</span>
                                    @else
                                        <span class="badge bg-secondary float-end me-2 fs-6">Closed</span>
                                    @endif
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
            <div class="d-flex justify-content-center mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>

{{-- modal detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Tender</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <img src="" class="img-fluid w-100" alt="" id="gambarDetail">
                    </div>
                    <div class="table-responsive mt-3">
                        <h5 class="fw-bold text-green-primary" id="namaTenderDetail"></h5>
                        {{-- tabel detail tender --}}
                        <table class="table table-bordered">
                            <tr>
                                <td class="fw-bold">Tanggal Mulai</td>
                                <td id="tanggalMulaiDetail"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tanggal Selesai</td>
                                <td id="tanggalSelesaiDetail"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Deskripsi</td>
                                <td id="deskripsiDetail"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Informasi Lebih Lanjut</td>
                                <td id="urlDetail" style="word-break: break-all;"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    .page-item.active .page-link {
        background-color: #0d6e09;
        border-color: #0d6e09;
    }
</style>
@endpush

@push('js')
{{-- test open modal --}}
<script>
    $('.detaiModalBtn').on('click', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            url: '/tender/' + id,
            type: 'GET',
            success: function(response) {
                $('#namaTenderDetail').text(response.nama);
                $('#tanggalMulaiDetail').text(response.tanggal_mulai);
                $('#tanggalSelesaiDetail').text(response.tanggal_selesai);
                $('#deskripsiDetail').text(response.desc);
                $('#urlDetail').html(`<a href="${response.url}" target="_blank">${response.url}</a>`);
                $('#gambarDetail').attr('src', '/' + response.gambar);
                $('#modalDetail').modal('show');
            },
            error: function(err) {
                alert('Terjadi kesalahan');
            }
        });
    });
</script>
@endpush

