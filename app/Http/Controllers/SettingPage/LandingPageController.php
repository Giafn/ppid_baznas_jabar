<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Models\SlideLanding;
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
        return view('setting-page.landing-page.index', compact('sliders'));
    }
}
