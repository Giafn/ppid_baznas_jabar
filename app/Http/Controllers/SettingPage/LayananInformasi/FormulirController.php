<?php

namespace App\Http\Controllers\SettingPage\LayananInformasi;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FormulirController extends Controller
{
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $search = $request->search;
        $formulirs = Formulir::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('setting-page.layanan-informasi.form.index', compact('formulirs'));
    }

    public function create()
    {
        return view('setting-page.layanan-informasi.form.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'google_form_url' => 'required|string|max:255',
            'form_file' => 'required|file|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $formulir = new Formulir();
            $formulir->nama = $request->nama;
            $formulir->deskripsi = $request->deskripsi;
            $formulir->google_form_url = $request->google_form_url;

            $file = $request->file('form_file');
            $file_name = time() . '.' . $file->extension();
            $storage = Storage::disk('public')->putFileAs('informasi', $file, $file_name);
            $fileUrl = Storage::url($storage);
            $formulir->form_file_url = $fileUrl;

            $formulir->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($storage)) {
                if (Storage::exists($storage)) {
                    Storage::delete($storage);
                }
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }


        return redirect('/admin/layanan-informasi/formulir')->with('success', 'Berhasil menyimpan data');
    }

    public function edit($id)
    {
        $formulir = Formulir::findOrFail($id);
        return view('setting-page.layanan-informasi.form.edit', compact('formulir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'google_form_url' => 'required|string|max:255',
            'form_file' => 'nullable|file|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $formulir = Formulir::findOrFail($id);
            $formulir->nama = $request->nama;
            $formulir->deskripsi = $request->deskripsi;
            $formulir->google_form_url = $request->google_form_url;

            if ($request->hasFile('form_file')) {
                $file = $request->file('form_file');
                $file_name = time() . '.' . $file->extension();
                $storage = Storage::disk('public')->putFileAs('informasi', $file, $file_name);
                $fileUrl = Storage::url($storage);
                $formulir->form_file_url = $fileUrl;
            }

            $formulir->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($storage)) {
                if (Storage::exists($storage)) {
                    Storage::delete($storage);
                }
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }

        return redirect()->back()->with('success', 'Berhasil menyimpan data');
    }

    public function destroy($id)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();

        return redirect('/admin/layanan-informasi/formulir')->with('success', 'Berhasil menghapus data');
    }
}
