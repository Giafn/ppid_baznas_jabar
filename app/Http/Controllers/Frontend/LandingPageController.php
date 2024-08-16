<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingPage\LandingPage\InformasiController;
use App\Models\AksesCepats;
use App\Models\Berita;
use App\Models\KantorLayanan;
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

        $aksesCepat = AksesCepats::all();

        $kantorLayanan = KantorLayanan::all();

        return view('frontend.index', compact('sliders', 'informasi', 'videos', 'aksesCepat', 'kantorLayanan'));
    }

    public function listBerita(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);

        $informasi = Berita::orderBy('posting_at', 'desc')
            ->where('posting_at', '<=', now())
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%$search%");
            })
            ->paginate(10);

        $informasi->map(function ($item) {
            $item->url = InformasiController::getUrlShow($item->id, $item->title);
            return $item;
        });

        return view('frontend.berita', compact('informasi'));
    }

    public function listVideo(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);
        $videos = Video::orderBy('created_at', 'desc')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%$search%");
            })
            ->paginate(10);

        return view('frontend.video', compact('videos'));
    }
}
