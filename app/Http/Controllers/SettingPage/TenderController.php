<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $search = $request->search;
        $tender = Tender::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
        ->orderByRaw('CASE 
            WHEN tanggal_selesai >= NOW() THEN 0
            ELSE 1
        END, ABS(DATEDIFF(NOW(), tanggal_selesai))')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('setting-page.tender.index', compact('tender'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,0',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'url' => 'required|string|max:255|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_tutup' => 'required|date',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $tender = new Tender();
            $tender->status = $request->status == 1 ? 'open' : 'close';
            $tender->nama = $request->nama;
            $tender->desc = $request->deskripsi;
            $tender->url = $request->url;
            $tender->tanggal_mulai = $request->tanggal_mulai;
            $tender->tanggal_selesai = $request->tanggal_tutup;

            $storage = Storage::disk('public')->put('tender', $request->file('gambar'));
            if ($storage) {
                $tender->gambar = 'storage/' . $storage;
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal menyimpan gambar')->withInput();
            }

            $tender->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($tender->gambar) {
                Storage::disk('public')->delete($tender->gambar);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }


        return redirect('/admin/tender')->with('success', 'Berhasil menyimpan data');
    }

    // edit
    public function edit($id)
    {
        $tender = Tender::findOrFail($id);

        return response()->json($tender);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,0',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'url' => 'required|string|max:255|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_tutup' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $tender = Tender::findOrFail($id);
            $tender->status = $request->status == 1 ? 'open' : 'close';
            $tender->nama = $request->nama;
            $tender->desc = $request->deskripsi;
            $tender->url = $request->url;
            $tender->tanggal_mulai = $request->tanggal_mulai;
            $tender->tanggal_selesai = $request->tanggal_tutup;

            $storage = null;
            if ($request->hasFile('gambar')) {
                $oldGambar = str_replace('storage/', '', $tender->gambar);
                $storage = Storage::disk('public')->put('tender', $request->file('gambar'));
                if ($storage) {
                    $tender->gambar = 'storage/' . $storage;
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Gagal menyimpan gambar')->withInput();
                }
            }

            $tender->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($storage) {
                Storage::disk('public')->delete($storage);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }
        if ($storage) {
            $storage = Storage::disk('public')->delete($oldGambar);
        }

        return redirect('/admin/tender')->with('success', 'Berhasil menyimpan data');
    }

    // update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,0',
        ]);

        try {
            DB::beginTransaction();

            $tender = Tender::findOrFail($id);
            $tender->status = $request->status == 1 ? 'open' : 'close';
            $tender->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['message' => 'Gagal mengubah status'], 500);
        }

        return response()->json(['message' => 'Berhasil mengubah status']);
    }

    public function destroy($id)
    {
        $tender = Tender::findOrFail($id);
        $tender->delete();

        return redirect('/admin/tender')->with('success', 'Berhasil menghapus data');
    }
}
