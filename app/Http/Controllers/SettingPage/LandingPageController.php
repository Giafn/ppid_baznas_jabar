<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Models\AksesCepats;
use App\Models\Berita;
use App\Models\KantorLayanan;
use App\Models\SlideLanding;
use App\Models\Video;

class LandingPageController extends Controller
{
    public function index()
    {
        $sliders = SlideLanding::orderBy('created_at', 'desc')
            ->orderBy('posting_at', 'desc')
            ->where('posting_at', '<=', now())
            ->get();

        $informasi = Berita::orderBy('posting_at', 'desc')
            ->where('posting_at', '<=', now())
            ->limit(3)
            ->get();

        $informasi->map(function ($item) {
            $item->url = InformasiController::getUrlShow($item->id, $item->title);
            return $item;
        });

        $videos = Video::orderBy('created_at', 'desc')->limit(4)->get();

        $aksesCepat = AksesCepats::all();
        $kantorLayanan = KantorLayanan::all();

        return view('setting-page.landing-page.index', compact('sliders', 'informasi', 'videos', 'aksesCepat', 'kantorLayanan'));
    }
}
