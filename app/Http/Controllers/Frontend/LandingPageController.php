<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Models\Berita;
use App\Models\SlideLanding;
use App\Models\Video;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $sliders = SlideLanding::orderBy('posting_at', 'desc')
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

        return view('frontend.index', compact('sliders', 'informasi', 'videos'));
    }
}
