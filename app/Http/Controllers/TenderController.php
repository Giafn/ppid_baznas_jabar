<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = $request->search;

        $items = Tender::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
        ->where('tanggal_selesai', '>=', now())
        ->where('tanggal_mulai', '<=', now())
        ->orderBy('status', 'desc')
        ->orderBy('tanggal_selesai', 'asc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('tender.index', compact('items'));
    }

    public function detail($id)
    {
        $item = Tender::findOrFail($id);
        return response()->json($item);
    }
}
