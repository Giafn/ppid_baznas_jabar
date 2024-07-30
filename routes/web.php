<?php

use App\Http\Controllers\Frontend\LandingPageController as FrontendLandingPageController;
use App\Http\Controllers\SettingPage\LandingPage\AksesCepatController;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Http\Controllers\SettingPage\LandingPage\SliderController;
use App\Http\Controllers\SettingPage\LandingPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;


Route::get('/', [FrontendLandingPageController::class, 'index'])->name('root');

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
        });
    });

});



