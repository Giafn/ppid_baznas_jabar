<?php

namespace App\Http\Controllers\SettingPage\LayananInformasi;

use App\Http\Controllers\Controller;
use App\Models\LayananInformasiList;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = $request->search;
        $items = LayananInformasiList::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('setting-page.layanan-informasi.item.index', compact('items'));
    }

    public function create()
    {
        return view('setting-page.layanan-informasi.item.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
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
                    'title' => $validate['nama'],
                    'content' => $validate['content'],
                    'posting_at' => now(),
                ]);

                $pageId = $page->id;
                $url = null;
            }

            $list = LayananInformasiList::create([
                'nama' => $validate['nama'],
                'type' => $validate['type'] == 'content' ? 'page' : 'url',
                'url' => $url ?? null,
                'page_id' => $pageId,
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/layanan-informasi/list')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = LayananInformasiList::where('id', $id)->with('page')->first();

        return view('setting-page.layanan-informasi.item.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
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
                    'title' => $validate['nama'],
                    'content' => $validate['content'],
                    'posting_at' => now(),
                ]);

                $pageId = $page->id;
                $url = null;
            }

            $list = LayananInformasiList::findOrFail($id);
            $list->update([
                'nama' => $validate['nama'],
                'type' => $validate['type'] == 'content' ? 'page' : 'url',
                'url' => $url ?? null,
                'page_id' => $pageId,
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/layanan-informasi/list')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = LayananInformasiList::findOrFail($id);
            $item->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/layanan-informasi/list')->with('success', 'Data berhasil dihapus');
    }
}
