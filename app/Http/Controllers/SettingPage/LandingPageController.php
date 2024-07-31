<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Models\Berita;
use App\Models\SlideLanding;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        $videos = Video::orderBy('created_at', 'desc')->limit(2)->get();

        return view('setting-page.landing-page.index', compact('sliders', 'informasi', 'videos'));
    }
}
