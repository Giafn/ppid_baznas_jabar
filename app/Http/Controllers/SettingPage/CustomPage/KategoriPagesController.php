<?php

namespace App\Http\Controllers\SettingPage\CustomPage;

use App\Http\Controllers\Controller;
use App\Models\CategoryPage;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KategoriPagesController extends Controller
{
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $search = $request->search;
        $kategori = CategoryPage::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('setting-page.custom-page.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $kategori = new CategoryPage();
            $kategori->nama = $request->nama;
            $kategori->keterangan = $request->keterangan;
            $kategori->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }


        return redirect('/admin/custom-page/kategori')->with('success', 'Berhasil menyimpan data');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $kategori = CategoryPage::findOrFail($id);
            $kategori->nama = $request->nama;
            $kategori->keterangan = $request->keterangan;
            $kategori->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }

        return redirect('/admin/custom-page/kategori')->with('success', 'Berhasil menyimpan data');
    }

    public function destroy($id)
    {
        $kategori = CategoryPage::findOrFail($id);
        $kategori->delete();

        return redirect('/admin/custom-page/kategori')->with('success', 'Berhasil menghapus data');
    }
}
