<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\LayananInformasiList;
use Illuminate\Http\Request;

class ItemsOnNavbarController extends Controller
{
    public function get()
    {
        $formulir = Formulir::select('id', 'nama')->get();
        $itemsLayanan = LayananInformasiList::select('id', 'nama', 'url')->get();

        return response()->json([
            'formulir' => $formulir,
            'item_layanans' => $itemsLayanan,
        ]);
    }
}
