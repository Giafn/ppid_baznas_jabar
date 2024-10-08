<?php

namespace App\Http\Controllers\SettingPage\InformasiPublik;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublikItems;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SertaMertaController extends Controller
{
    public function index(Request $request)
        {
            $validate = $request->validate([
                'search' => 'nullable|string|max:255',
            ]);
    
            $search = $request->search;
            $items = InformasiPublikItems::when($search, function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('group', 'like', '%' . $search . '%');
            })
            ->where('golongan', 'serta_merta')
            ->orderBy('created_at', 'desc')
            ->orderBy('group', 'asc')
            ->paginate(10);

        $items->map(function ($item) {
            if ($item->type == 'page') {
                $item->url = '/informasi-publik/' . $item->id . '/' . str_replace(' ', '-', $item->nama);
            }
            return $item;
        });

        return view('setting-page.informasi-publik.serta-merta.index', compact('items'));
    }

    public function create()
    {
        $groups = InformasiPublikItems::where('golongan', 'serta_merta')->pluck('group')->unique();
        return view('setting-page.informasi-publik.serta-merta.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'group' => 'nullable|string|max:255',
            'type' => 'required|in:content,url',
            'url' => 'nullable|url|required_if:type,url',
            'content' => 'nullable|string|required_if:type,content',
        ]);

        try {
            DB::beginTransaction();
            $url = $validate['url'];
            $pageId = null;
            if ($validate['type'] == 'content') {
                $page = Pages::create([
                    'title' => $validate['title'],
                    'content' => $validate['content'],
                    'posting_at' => now(),
                ]);

                $pageId = $page->id;
                $url = null;
            }

            $list = InformasiPublikItems::create([
                'nama' => $validate['title'],
                'group' => $request->group,
                'type' => $validate['type'] == 'content' ? 'page' : 'url',
                'url' => $url ?? null,
                'page_id' => $pageId,
                'golongan' => 'serta_merta',
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/informasi-publik/serta-merta')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = InformasiPublikItems::where('id', $id)->with('page')->first();
        $groups = InformasiPublikItems::where('golongan', 'serta_merta')->pluck('group')->unique();
        return view('setting-page.informasi-publik.serta-merta.edit', compact('item', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'group' => 'nullable|string|max:255',
            'type' => 'required|in:content,url',
            'url' => 'nullable|url|required_if:type,url',
            'content' => 'nullable|string|required_if:type,content',
        ]);

        try {
            DB::beginTransaction();
            $url = $validate['url'];
            $pageId = null;
            if ($validate['type'] == 'content') {
                $page = Pages::where('id', $id)->first();
                if (!$page) {
                    $page = Pages::create([
                        'title' => $validate['title'],
                        'content' => $validate['content'],
                        'posting_at' => now(),
                    ]);
                } else {
                    $page->update([
                        'title' => $validate['title'],
                        'content' => $validate['content'],
                    ]);
                }

                $pageId = $page->id;
                $url = null;
            }

            $list = InformasiPublikItems::findOrFail($id);
            $list->update([
                'nama' => $validate['title'],
                'group' => $request->group,
                'type' => $validate['type'] == 'content' ? 'page' : 'url',
                'url' => $url ?? null,
                'page_id' => $pageId,
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/informasi-publik/serta-merta')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {   
            DB::beginTransaction();
            $item = InformasiPublikItems::findOrFail($id);
            $item->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/informasi-publik/serta-merta')->with('success', 'Data berhasil dihapus');
    }
}
