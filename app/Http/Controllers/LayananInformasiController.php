<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;

class LayananInformasiController extends Controller
{
    public function formulir($id)
    {
        $formulir = Formulir::find($id);
        // dd($formulir);
        return view('frontend.layanan-informasi.formulir', compact('formulir'));
    }
}
