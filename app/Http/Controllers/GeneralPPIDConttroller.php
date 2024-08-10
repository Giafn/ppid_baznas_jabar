<?php

namespace App\Http\Controllers;

use App\Models\GeneralContentList;
use Illuminate\Http\Request;

class GeneralPPIDConttroller extends Controller
{
    public function profile()
    {
        $profile = GeneralContentList::where('nama', 'profile')->with('page')->first();
        if (!$profile) {
            return redirect('/')->with('error', 'Terjadi Kesalahan');
        }
        $page = $profile->page;
        return view('frontend.ppid.page', compact('page'));
    }

    public function visiMisi()
    {
        $visiMisi = GeneralContentList::where('nama', 'visi_misi')->with('page')->first();
        if (!$visiMisi) {
            return redirect('/')->with('error', 'Terjadi Kesalahan');
        }
        $page = $visiMisi->page;
        return view('frontend.ppid.page', compact('page'));
    }

    public function tugasFungsi()
    {
        $tugasFungsi = GeneralContentList::where('nama', 'tugas_fungsi')->with('page')->first();
        if (!$tugasFungsi) {
            return redirect('/')->with('error', 'Terjadi Kesalahan');
        }
        $page = $tugasFungsi->page;
        return view('frontend.ppid.page', compact('page'));
    }

    public function strukturOrganisasi()
    {
        $strukturOrganisasi = GeneralContentList::where('nama', 'struktur')->with('page')->first();
        if (!$strukturOrganisasi) {
            return redirect('/')->with('error', 'Terjadi Kesalahan');
        }
        $page = $strukturOrganisasi->page;
        return view('frontend.ppid.page', compact('page'));
    }
}
