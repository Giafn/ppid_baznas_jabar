<?php

use App\Http\Controllers\FaqsController as ControllersFaqsController;
use App\Http\Controllers\Frontend\LandingPageController as FrontendLandingPageController;
use App\Http\Controllers\GeneralPPIDConttroller;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\ItemsRequiredPerpageController;
use App\Http\Controllers\LayananInformasiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SettingPage\CustomPage\CustomPagesController;
use App\Http\Controllers\SettingPage\CustomPage\KategoriPagesController;
use App\Http\Controllers\SettingPage\FaqsController;
use App\Http\Controllers\SettingPage\General\ProfileController;
use App\Http\Controllers\SettingPage\General\StrukturController;
use App\Http\Controllers\SettingPage\General\TugasFungsiController;
use App\Http\Controllers\SettingPage\General\VisiMisiController;
use App\Http\Controllers\SettingPage\InformasiPublik\BerkalaController;
use App\Http\Controllers\SettingPage\InformasiPublik\DikecualikanController;
use App\Http\Controllers\SettingPage\InformasiPublik\SertaMertaController;
use App\Http\Controllers\SettingPage\InformasiPublik\SetiapSaatController;
use App\Http\Controllers\SettingPage\LandingPage\AksesCepatController;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Http\Controllers\SettingPage\LandingPage\KantorLayananController;
use App\Http\Controllers\SettingPage\LandingPage\SliderController;
use App\Http\Controllers\SettingPage\LandingPage\VideoController;
use App\Http\Controllers\SettingPage\LandingPageController;
use App\Http\Controllers\SettingPage\LaporanController;
use App\Http\Controllers\SettingPage\LayananInformasi\FormulirController;
use App\Http\Controllers\SettingPage\LayananInformasi\ItemsController;
use App\Http\Controllers\SettingPage\RegulasiController;
use App\Http\Controllers\SettingPage\TenderController;
use App\Http\Controllers\TenderController as ControllersTenderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Models\Faqs;

Route::get('/', [FrontendLandingPageController::class, 'index'])->name('root');
Route::get('/informasi', [FrontendLandingPageController::class, 'listBerita'])->name('berita');
Route::get('/video', [FrontendLandingPageController::class, 'listVideo'])->name('video');
Route::get('/init-required-items', [ItemsRequiredPerpageController::class, 'get']);

Route::get('/page/{id}/{slug}', [CustomPagesController::class, 'show'])->name('custom-page.show');
Route::get('/informasi/{id}/{slug}', [InformasiController::class, 'showpage'])->name('informasi.show');

// general ppid
Route::get('/profile', [GeneralPPIDConttroller::class, 'profile']);
Route::get('/visi-misi', [GeneralPPIDConttroller::class, 'visiMisi']);
Route::get('/tugas-fungsi', [GeneralPPIDConttroller::class, 'tugasFungsi']);
Route::get('/struktur-organisasi', [GeneralPPIDConttroller::class, 'strukturOrganisasi']);

// formulir
Route::get('/formulir/{id}', [LayananInformasiController::class, 'formulir']);

// informasi publik
Route::get('informasi-publik/berkala', [InformasiPublikController::class, 'berkalaIndex']);
Route::get('informasi-publik/setiap-saat', [InformasiPublikController::class, 'setiapSaatIndex']);
Route::get('informasi-publik/serta-merta', [InformasiPublikController::class, 'sertaMertaIndex']);
Route::get('informasi-publik/dikecualikan', [InformasiPublikController::class, 'dikecualikanIndex']);

// view informasi publik
Route::get('informasi-publik/{id}/{slug}', [InformasiPublikController::class, 'view']);

// view tender
Route::get('tender', [ControllersTenderController::class, 'index']);
Route::get('tender/{id}', [ControllersTenderController::class, 'detail']);

// faqs
Route::get('faqs', [ControllersFaqsController::class, 'index']);

Route::prefix('admin')->group(function () {
    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false,
      ]);
});

Route::get('/home', function () {
    return redirect('/admin/home');
});

// group auth
Route::group(['middleware' => 'auth'], function () {
    Route::post('/upload', [UploadController::class, 'store'])->name('upload');
    Route::post('/temp-upload', [UploadController::class, 'tempUpload'])->name('temp-upload');
    // landig page setting
    // admin prefix
    Route::prefix('admin')->group(function () {

        Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::prefix('landing-page-setting')->group(function () {
            
            Route::get('/', [LandingPageController::class, 'index']);
            
            // route slider setting
            Route::get('/slider-setting', [SliderController::class, 'index']);
            Route::post('/slider-setting', [SliderController::class, 'store']);
            Route::delete('/slider-setting/{id}', [SliderController::class, 'delete']);
            Route::put('/slider-setting/{id}', [SliderController::class, 'update']);
    
            // route akses cepat setting
            Route::get('/akses-cepat-setting', [AksesCepatController::class, 'index']);
            Route::get('/akses-cepat-setting/create', [AksesCepatController::class, 'create']);
            Route::post('/akses-cepat-setting', [AksesCepatController::class, 'store']);
            Route::get('/akses-cepat-setting/{id}/edit', [AksesCepatController::class, 'edit']);
            Route::put('/akses-cepat-setting/{id}', [AksesCepatController::class, 'update']);
            Route::delete('/akses-cepat-setting/{id}', [AksesCepatController::class, 'delete']);

            // route informasi setting
            Route::get('/informasi-setting', [InformasiController::class, 'index']);
            Route::get('/informasi-setting/create', [InformasiController::class, 'create']);
            Route::post('/informasi-setting', [InformasiController::class, 'store']);
            Route::get('/informasi-setting/{id}/edit', [InformasiController::class, 'edit']);
            Route::put('/informasi-setting/{id}', [InformasiController::class, 'update']);
            Route::delete('/informasi-setting/{id}', [InformasiController::class, 'delete']);

            // route video setting
            Route::get('/video-setting', [VideoController::class, 'index']);
            Route::post('/video-setting', [VideoController::class, 'store']);
            Route::delete('/video-setting/{id}', [VideoController::class, 'delete']);
            Route::put('/video-setting/{id}', [VideoController::class, 'update']);

            // route kantor layanan setting
            Route::get('/kantor-layanan', [KantorLayananController::class, 'index']);
            Route::post('/kantor-layanan', [KantorLayananController::class, 'store']);
            Route::put('/kantor-layanan/{id}', [KantorLayananController::class, 'update']);
            Route::delete('/kantor-layanan/{id}', [KantorLayananController::class, 'delete']);
        });

        Route::prefix('general')->group(function () {
            Route::get('profile', [ProfileController::class, 'index']);
            Route::put('profile', [ProfileController::class, 'update']);

            Route::get('visi-misi', [VisiMisiController::class, 'index']);
            Route::put('visi-misi', [VisiMisiController::class, 'update']);
            
            Route::get('tugas-fungsi', [TugasFungsiController::class, 'index']);
            Route::put('tugas-fungsi', [TugasFungsiController::class, 'update']);

            Route::get('struktur-organisasi', [StrukturController::class, 'index']);
            Route::put('struktur-organisasi', [StrukturController::class, 'update']);
        });

        Route::prefix('layanan-informasi')->group(function () {
            Route::get('formulir', [FormulirController::class, 'index']);
            Route::get('formulir/create', [FormulirController::class, 'create']);
            Route::post('formulir', [FormulirController::class, 'store']);
            Route::get('formulir/{id}/edit', [FormulirController::class, 'edit']);
            Route::put('formulir/{id}', [FormulirController::class, 'update']);
            Route::delete('formulir/{id}', [FormulirController::class, 'destroy']);

            Route::get('list', [ItemsController::class, 'index']);
            Route::get('list/create', [ItemsController::class, 'create']);
            Route::post('list', [ItemsController::class, 'store']);
            Route::get('list/{id}/edit', [ItemsController::class, 'edit']);
            Route::put('list/{id}', [ItemsController::class, 'update']);
            Route::delete('list/{id}', [ItemsController::class, 'destroy']);
        });

        Route::prefix('informasi-publik')->group(function () {
            Route::get('berkala', [BerkalaController::class, 'index']);
            Route::get('berkala/create', [BerkalaController::class, 'create']);
            Route::post('berkala', [BerkalaController::class, 'store']);
            Route::get('berkala/{id}/edit', [BerkalaController::class, 'edit']);
            Route::put('berkala/{id}', [BerkalaController::class, 'update']);
            Route::delete('berkala/{id}', [BerkalaController::class, 'destroy']);

            Route::get('serta-merta', [SertaMertaController::class, 'index']);
            Route::get('serta-merta/create', [SertaMertaController::class, 'create']);
            Route::post('serta-merta', [SertaMertaController::class, 'store']);
            Route::get('serta-merta/{id}/edit', [SertaMertaController::class, 'edit']);
            Route::put('serta-merta/{id}', [SertaMertaController::class, 'update']);
            Route::delete('serta-merta/{id}', [SertaMertaController::class, 'destroy']);

            Route::get('setiap-saat', [SetiapSaatController::class, 'index']);
            Route::get('setiap-saat/create', [SetiapSaatController::class, 'create']);
            Route::post('setiap-saat', [SetiapSaatController::class, 'store']);
            Route::get('setiap-saat/{id}/edit', [SetiapSaatController::class, 'edit']);
            Route::put('setiap-saat/{id}', [SetiapSaatController::class, 'update']);
            Route::delete('setiap-saat/{id}', [SetiapSaatController::class, 'destroy']);

            // dikecualikan
            Route::get('dikecualikan', [DikecualikanController::class, 'index']);
            Route::post('dikecualikan', [DikecualikanController::class, 'store']);
            Route::get('dikecualikan/{id}/edit', [DikecualikanController::class, 'edit']);
            Route::put('dikecualikan/{id}', [DikecualikanController::class, 'update']);
            Route::delete('dikecualikan/{id}', [DikecualikanController::class, 'destroy']);
        });

        Route::prefix('custom-page')->group(function () {
            // kategori
            Route::get('kategori', [KategoriPagesController::class, 'index']);
            Route::post('kategori', [KategoriPagesController::class, 'store']);
            Route::put('kategori/{id}', [KategoriPagesController::class, 'update']);
            Route::delete('kategori/{id}', [KategoriPagesController::class, 'destroy']);

            // list
            Route::get('', [CustomPagesController::class, 'index']);
            Route::get('create/{tipe}', [CustomPagesController::class, 'create']);
            Route::post('', [CustomPagesController::class, 'store']);
            Route::get('{id}/edit', [CustomPagesController::class, 'edit']);
            Route::put('{id}', [CustomPagesController::class, 'update']);
            Route::delete('{id}', [CustomPagesController::class, 'destroy']);
            // api
            Route::get('get', [CustomPagesController::class, 'getItems']);
            Route::get('get-types', [CustomPagesController::class, 'getTypes']);
        });

        // regulasi
        Route::prefix('regulasi')->group(function () {
            Route::get('/', [RegulasiController::class, 'index']);
            Route::get('create', [RegulasiController::class, 'create']);
            Route::post('/', [RegulasiController::class, 'store']);
            Route::get('{id}/edit', [RegulasiController::class, 'edit']);
            Route::put('{id}', [RegulasiController::class, 'update']);
            Route::delete('{id}', [RegulasiController::class, 'destroy']);
        });

        // tender
        Route::get('tender', [TenderController::class, 'index']);
        Route::get('tender/{id}/edit', [TenderController::class, 'edit']);
        Route::post('tender', [TenderController::class, 'store']);
        Route::put('tender/{id}', [TenderController::class, 'update']);
        Route::put('tender/{id}/status', [TenderController::class, 'updateStatus']);
        Route::delete('tender/{id}', [TenderController::class, 'destroy']);

        // laporan
        Route::prefix('laporan')->group(function () {
            Route::get('/', [LaporanController::class, 'index']);
            Route::get('create', [LaporanController::class, 'create']);
            Route::post('/', [LaporanController::class, 'store']);
            Route::get('{id}/edit', [LaporanController::class, 'edit']);
            Route::put('{id}', [LaporanController::class, 'update']);
            Route::delete('{id}', [LaporanController::class, 'destroy']);
        });

        // faqs
        Route::get('faqs', [FaqsController::class, 'index']);
        Route::post('faqs', [FaqsController::class, 'store']);
        Route::put('faqs/{id}', [FaqsController::class, 'update']);
        Route::delete('faqs/{id}', [FaqsController::class, 'destroy']);

        // setting
        Route::get('setting', [SettingController::class, 'index']);
        Route::put('setting/update-credential', [SettingController::class, 'updateCredential']);
        Route::put('setting/update-office', [SettingController::class, 'updateOffice']);
        Route::put('setting/update-maps', [SettingController::class, 'updateMaps']);
        Route::put('setting/update-social-media', [SettingController::class, 'updateSosmed']);

    });

});



