<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublikItems;
use App\Models\Pages;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    public function berkalaIndex()
    {
        $items = InformasiPublikItems::where('golongan', 'berkala')
        ->orderBy('created_at', 'desc')
        ->orderBy('group', 'asc')
        ->get();

        $items->map(function ($item) {
            if ($item->type == 'page') {
                $item->url = $this->generateUrl($item->id, str_replace(' ', '-', $item->nama));
            }
            return $item;
        });

        $groupedItems = $items->groupBy('group');

        return view('frontend.informasi-publik.berkala', compact('groupedItems'));
    }

    public function setiapSaatIndex()
    {
        $items = InformasiPublikItems::where('golongan', 'setiap_saat')
        ->orderBy('created_at', 'desc')
        ->orderBy('group', 'asc')
        ->get();

        $items->map(function ($item) {
            if ($item->type == 'page') {
                $item->url = $this->generateUrl($item->id, str_replace(' ', '-', $item->nama));
            }
            return $item;
        });

        $groupedItems = $items->groupBy('group');

        return view('frontend.informasi-publik.setiap-saat', compact('groupedItems'));
    }

    public function sertaMertaIndex()
    {
        $items = InformasiPublikItems::where('golongan', 'serta_merta')
        ->orderBy('created_at', 'desc')
        ->orderBy('group', 'asc')
        ->get();

        $items->map(function ($item) {
            if ($item->type == 'page') {
                $item->url = $this->generateUrl($item->id, str_replace(' ', '-', $item->nama));
            }
            return $item;
        });

        $groupedItems = $items->groupBy('group');

        return view('frontend.informasi-publik.serta-merta', compact('groupedItems'));
    }


    public function view($id, $slug)
    {
        $item = InformasiPublikItems::where('id', $id)->with('page')->first();
        if (!$item) {
            return abort(404);
        }
        if ($slug != str_replace(' ', '-', $item->nama)) {
            return redirect($this->generateUrl($item->id, str_replace(' ', '-', $item->nama)));
        }

        $item = $item->page;
        // dd($page);
        return view('frontend.informasi-publik.show', compact('item'));
    }

    // generate url from id
    public function generateUrl($id, $slug)
    {
        $slug = str_replace(' ', '-', $slug);
        return '/informasi-publik/' . $id . '/' . $slug;
    }
}
