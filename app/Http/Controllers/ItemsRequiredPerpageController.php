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
        $formulir = Formulir::select('id', 'nama')->orderBy('created_at', 'asc')->get();
        $itemsLayanan = LayananInformasiList::select('id', 'nama', 'url')->orderBy('created_at', 'asc')->get();
        $regulasi = Regulasi::select('id', 'nama', 'url')->orderBy('created_at', 'asc')->get();
        $laporan = LaporanList::select('id', 'nama', 'url')->orderBy('created_at', 'asc')->get();
        $settings = Setting::where('key', 'informasi_kantor')->first();
        $infoKantor = json_decode($settings->value);
        $embedMap = Setting::where('key', 'embed_map')->first()->value;
        $sosmed = Setting::where('key', 'sosial_media')->first()->value;
        $sosmed = json_decode($sosmed);

        return response()->json([
            'formulir' => $formulir,
            'item_layanans' => $itemsLayanan,
            'regulasi' => $regulasi,
            'laporan' => $laporan,
            'info_kantor' => $infoKantor,
            'sosmed' => $sosmed,
            'embed_map' => $embedMap
        ]);
    }
}
