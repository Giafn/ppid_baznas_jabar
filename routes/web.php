<?php

use App\Http\Controllers\Frontend\LandingPageController as FrontendLandingPageController;
use App\Http\Controllers\SettingPage\CustomPage\CustomPagesController;
use App\Http\Controllers\SettingPage\CustomPage\KategoriPagesController;
use App\Http\Controllers\SettingPage\General\ProfileController;
use App\Http\Controllers\SettingPage\General\StrukturController;
use App\Http\Controllers\SettingPage\General\TugasFungsiController;
use App\Http\Controllers\SettingPage\General\VisiMisiController;
use App\Http\Controllers\SettingPage\InformasiPublik\BerkalaController;
use App\Http\Controllers\SettingPage\InformasiPublik\SertaMertaController;
use App\Http\Controllers\SettingPage\InformasiPublik\SetiapSaatController;
use App\Http\Controllers\SettingPage\LandingPage\AksesCepatController;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Http\Controllers\SettingPage\LandingPage\SliderController;
use App\Http\Controllers\SettingPage\LandingPage\VideoController;
use App\Http\Controllers\SettingPage\LandingPageController;
use App\Http\Controllers\SettingPage\LayananInformasi\FormulirController;
use App\Http\Controllers\SettingPage\LayananInformasi\ItemsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;


Route::get('/', [FrontendLandingPageController::class, 'index'])->name('root');

Route::get('/page/{id}/{slug}', [CustomPagesController::class, 'show']);

Route::get('/profile', function () {
    return view('frontend.ppid.profile');
});

Route::get('/visi-misi', function () {
    return view('frontend.ppid.visi-misi');
});

Route::get('/tugas-fungsi', function () {
    return view('frontend.ppid.tugas-dan-fungsi');
});

Route::get('/struktur-organisasi', function () {
    return view('frontend.ppid.struktur');
});

Route::prefix('admin')->group(function () {
    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false,
      ]);
});

// informasi frontend
Route::get('/informasi/{id}/{slug}', [InformasiController::class, 'showpage']);


Route::get('/home', function () {
    return redirect('/admin/home');
});

// testpage
Route::get('/test', function () {
    return view('frontend.test');
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

            // serta merta
            Route::get('setiap-saat', [SetiapSaatController::class, 'index']);
            Route::get('setiap-saat/create', [SetiapSaatController::class, 'create']);
            Route::post('setiap-saat', [SetiapSaatController::class, 'store']);
            Route::get('setiap-saat/{id}/edit', [SetiapSaatController::class, 'edit']);
            Route::put('setiap-saat/{id}', [SetiapSaatController::class, 'update']);
            Route::delete('setiap-saat/{id}', [SetiapSaatController::class, 'destroy']);
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
        });

    });

});



