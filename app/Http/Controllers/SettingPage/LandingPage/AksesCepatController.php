<?php

namespace App\Http\Controllers\SettingPage\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\SlideLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AksesCepatController extends Controller
{
    public function index()
    {
        return view('setting-page.landing-page.akses-cepat-setting');
    }
}
