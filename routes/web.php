<?php

use App\Http\Controllers\Frontend\LandingPageController as FrontendLandingPageController;
use App\Http\Controllers\SettingPage\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendLandingPageController::class, 'index']);

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// testpage
Route::get('/test', function () {
    return view('frontend.test');
});

use App\Http\Controllers\UploadController;

Route::post('/upload', [UploadController::class, 'store'])->name('upload');

// group auth
Route::group(['middleware' => 'auth'], function () {
    // landig page setting

    // route prefix landing-page-setting
    Route::prefix('landing-page-setting')->group(function () {
        // route get landing-page-setting
        Route::get('/', [LandingPageController::class, 'index']);
        Route::get('/slider-setting', [LandingPageController::class, 'sliderSetting']);
        Route::post('/slider-setting', [LandingPageController::class, 'sliderSettingStore']);
        Route::delete('/slider-setting/{id}', [LandingPageController::class, 'sliderSettingDelete']);
        Route::put('/slider-setting/{id}', [LandingPageController::class, 'sliderSettingUpdate']);
    });
});



