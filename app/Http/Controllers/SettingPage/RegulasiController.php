<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use App\Models\SlideLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegulasiController extends Controller
{
    public function index()
    {
        $data = Regulasi::paginate(10);
        return view('setting-page.regulasi.index', compact('data'));
    }

    public function create()
    {
        return view('setting-page.regulasi.create');
    }

    public function edit($id)
    {
        $data = Regulasi::with('page')->find($id);
        return view('setting-page.regulasi.edit', compact('data'));
    }

    public  function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|string|in:halaman,url',
            'url' => 'required_if:type,url',
            'page_id' => 'required_if:type,halaman',
            'url_page' => 'required_if:type,halaman',
        ]);

        $url = $request->type == 'url' ? $request->url : $request->url_page;
        if ($request->type == 'url') {
            $request->validate([
                'url' => 'required|url',
            ]);
        } else {
            $request->validate([
                'page_id' => 'required|exists:custom_page,id',
            ]);
        }
        
        try {
            DB::beginTransaction();
            $data = new Regulasi();
            $data->nama = $request->title;
            $data->type = $request->type == 'url' ? 'url' : 'page';
            $data->url = $request->type == 'url' ? $request->url : $request->url_page;
            $data->page_id = $request->type == 'halaman' ? $request->page_id : null;
            $data->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }

        return redirect('/admin/regulasi')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|string|in:halaman,url',
            'url' => 'required_if:type,url',
            'page_id' => 'required_if:type,halaman',
            'url_page' => 'required_if:type,halaman',
        ]);

        $url = $request->type == 'url' ? $request->url : $request->url_page;
        if ($request->type == 'url') {
            $request->validate([
                'url' => 'required|url',
            ]);
        } else {
            $request->validate([
                'page_id' => 'required|exists:custom_page,id',
            ]);
        }
        
        try {
            DB::beginTransaction();
            $data = Regulasi::find($id);
            $data->nama = $request->title;
            $data->type = $request->type == 'url' ? 'url' : 'page';
            $data->url = $request->type == 'url' ? $request->url : $request->url_page;
            $data->page_id = $request->type == 'halaman' ? $request->page_id : null;
            $data->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }

        return redirect('/admin/regulasi')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = Regulasi::find($id);
            $data->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }

        return redirect('/admin/regulasi')->with('success', 'Data berhasil dihapus');
    }
}
