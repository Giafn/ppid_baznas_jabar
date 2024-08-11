<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\LaporanList;
use App\Models\LayananInformasiList;
use App\Models\Regulasi;
use Illuminate\Http\Request;

class ItemsOnNavbarController extends Controller
{
    public function get()
    {
        $formulir = Formulir::select('id', 'nama')->get();
        $itemsLayanan = LayananInformasiList::select('id', 'nama', 'url')->get();
        $regulasi = Regulasi::select('id', 'nama', 'url')->get();
        $laporan = LaporanList::select('id', 'nama', 'url')->get();

        return response()->json([
            'formulir' => $formulir,
            'item_layanans' => $itemsLayanan,
            'regulasi' => $regulasi,
            'laporan' => $laporan
        ]);
    }
}
