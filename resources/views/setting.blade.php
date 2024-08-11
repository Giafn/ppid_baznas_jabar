@extends('layouts.app')

@section('title', 'Setting')

@php
    $itemBc = [
        [
            'name' =>'Dashboard',
            'url' => '/admin/home',
        ],
        [
            'name' =>'Setting',
            'url' => '/admin/setting',
        ]
    ];
@endphp

@section('content')
<div class="p-3 shadow rounded bg-white">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-5">
                <div class="p-3 rounded" style="border: 1px solid #e9ecef;">
                    <h5 class="text-green-primary">Ubah Username/Password</h5>
                    <form action="/admin/setting/update-credential" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-2">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="col-12">
                                <label for="password_baru" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password_baru" name="password_baru" value="" autocomplete="new-password">
                            </div>
                            <div class="col-12">
                                <label for="konfirmasi_password" class="form-label">Ulangi Password Baru</label>
                                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                            </div>
                            <div class="col-12">
                                <label for="password_lama" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="password_lama" name="password_lama">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn bg-green-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="p-3 rounded" style="border: 1px solid #e9ecef;">
                    {{-- ubah informasi kantor --}}
                    <h5 class="text-green-primary">Ubah Informasi Kantor <small>(di tampilkan di footer)</small></h5>
                    <form action="/admin/setting/update-office" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-2">
                            <div class="col-12">
                                <label for="nama_kantor" class="form-label">Nama Kantor</label>
                                <input type="text" class="form-control" id="nama_kantor" name="nama_kantor" value="{{ old('nama_kantor') ?? $infoKantor->nama_kantor}}">
                            </div>
                            <div class="col-12">
                                <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
                                <textarea class="form-control" id="alamat_kantor" name="alamat_kantor">{{ old('alamat_kantor') ?? $infoKantor->alamat_kantor }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="telepon_kantor" class="form-label">Telepon Kantor</label>
                                <input type="number" class="form-control" id="telepon_kantor" name="telepon_kantor" value="{{ old('telepon_kantor') ?? $infoKantor->telepon_kantor}}">
                            </div>
                            <div class="col-12">
                                <label for="email_kantor" class="form-label">Email Kantor</label>
                                <input type="email" class="form-control" id="email_kantor" name="email_kantor" value="{{ old('email_kantor') ?? $infoKantor->email_kantor}}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn bg-green-primary">Update</button>
                            </div>
                        </div>
                    </form>
                    {{-- form update embed alamat --}}
                    <h5 class="text-green-primary mt-3">Ubah Embed Maps Alamat  <small>(di tampilkan di footer)</small></h5>
                    <form action="/admin/setting/update-maps" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-2">
                            <div class="col-12">
                                <label for="embed_maps" class="form-label">Embed Maps</label>
                                <small class="d-block">
                                    untuk mendapatkan embed maps, silahkan buka google maps, cari alamat kantor, klik bagikan, pilih sematkan peta, copy dan paste di sini
                                </small>
                                <textarea class="form-control" id="embed_maps" name="embed_maps" rows="5">{{ old('embed_maps') ?? $embedMap }}</textarea>
                            </div>
                            {{-- preview --}}
                            <div class="col-12">
                                <div class="footer-frame" id="footer-frame">
                                    {!! $embedMap !!}
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn bg-green-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
    // load embed maps on typing delay 2s
    $('#embed_maps').on('keyup', function() {
        let embedMaps = $(this).val();
        $('#footer-frame').html('<p class="text-secondary">Loading...</p>');
        if(embedMaps.length > 0) {
            if(embedMaps.includes('<iframe') && embedMaps.includes('src="https://www.google.com/maps/embed') && embedMaps.includes('></iframe>')) {
                $('#footer-frame').html(embedMaps);
            } else {
                $('#footer-frame').html('<p class="text-danger">Embed Maps tidak valid</p>');
            }
        } else {
            $('#footer-frame').html('<p class="text-danger">Embed Maps tidak boleh kosong</p>');
        }
    });
</script>
@endpush
