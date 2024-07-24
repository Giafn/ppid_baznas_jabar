<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

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
