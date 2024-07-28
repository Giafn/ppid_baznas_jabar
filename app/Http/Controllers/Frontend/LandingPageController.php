<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SlideLanding;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $sliders = SlideLanding::orderBy('posting_at', 'desc')
            ->where('posting_at', '<=', now())
            ->get();
        return view('frontend.index', compact('sliders'));
    }
}
