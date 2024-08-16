<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqsController extends Controller
{
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $search = $request->search;
        $kategori = Faqs::when($search, function ($query) use ($search) {
            $query->where('pertanyaan', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('setting-page.faqs.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'content_jawaban' => 'nullable|string|max:65000',
        ]);
        try {
            DB::beginTransaction();

            $kategori = new Faqs();
            $kategori->pertanyaan = $request->pertanyaan;
            $kategori->content_jawaban = $request->content_jawaban;
            $kategori->posting_at = now();
            $kategori->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }


        return redirect('/admin/faqs')->with('success', 'Berhasil menyimpan data');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'content_jawaban' => 'nullable|string|max:65000',
        ]);

        try {
            DB::beginTransaction();

            $kategori = Faqs::findOrFail($id);
            $kategori->pertanyaan = $request->pertanyaan;
            $kategori->content_jawaban = $request->content_jawaban;
            $kategori->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }

        return redirect('/admin/faqs')->with('success', 'Berhasil menyimpan data');
    }

    public function destroy($id)
    {
        $kategori = Faqs::findOrFail($id);
        $kategori->delete();

        return redirect('/admin/faqs')->with('success', 'Berhasil menghapus data');
    }
}
