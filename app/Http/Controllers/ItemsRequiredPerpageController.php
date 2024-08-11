<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\LaporanList;
use App\Models\LayananInformasiList;
use App\Models\Regulasi;
use App\Models\Setting;
use Illuminate\Http\Request;

class ItemsRequiredPerpageController extends Controller
{
    public function get()
    {
        $formulir = Formulir::select('id', 'nama')->orderBy('created_at', 'desc')->get();
        $itemsLayanan = LayananInformasiList::select('id', 'nama', 'url')->orderBy('created_at', 'desc')->get();
        $regulasi = Regulasi::select('id', 'nama', 'url')->orderBy('created_at', 'desc')->get();
        $laporan = LaporanList::select('id', 'nama', 'url')->orderBy('created_at', 'desc')->get();
        $settings = Setting::where('key', 'informasi_kantor')->first();
        $infoKantor = json_decode($settings->value);
        $embedMap = Setting::where('key', 'embed_map')->first()->value;

        return response()->json([
            'formulir' => $formulir,
            'item_layanans' => $itemsLayanan,
            'regulasi' => $regulasi,
            'laporan' => $laporan,
            'info_kantor' => $infoKantor,
            'embed_map' => $embedMap
        ]);
    }
}
