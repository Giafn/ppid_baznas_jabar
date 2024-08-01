<?php

namespace App\Http\Controllers\SettingPage\General;

use App\Http\Controllers\Controller;
use App\Models\GeneralContentList;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TugasFungsiController extends Controller
{
    public function index()
    {
        $tugasFungsi = GeneralContentList::where('nama', 'tugas_fungsi')->with('page')->first();
        if (!$tugasFungsi) {
            return redirect('/admin/home')->with('error', 'Terjadi Kesalahan');
        }

        return view('setting-page.general.tugas-fungsi.index', compact('tugasFungsi'));
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|string',
            'content' => 'required|min:10|string',
        ]);

        $tugasFungsi = GeneralContentList::where('nama', 'tugas_fungsi')->with('page')->first();

        try {
            if (!$tugasFungsi) {
                // Start transaction
                DB::beginTransaction();

                // Create the page
                $page = Pages::create([
                    'title' => $validate['title'],
                    'content' => $validate['content'],
                    'posting_at' => now(), // Use Laravel's now() helper for current datetime
                ]);

                // Create the tugas_fungsi
                $tugasFungsi = GeneralContentList::create([
                    'nama' => 'tugas_fungsi',
                    'page_id' => $page->id,
                ]);

                // Commit the transaction
                DB::commit();
            } else {
                // Update existing tugas_fungsi page
                DB::beginTransaction();

                $page = $tugasFungsi->page;
                $page->title = $validate['title'];
                $page->content = $validate['content'];
                $page->save();

                DB::commit();
            }
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
        }


        return redirect('/admin/general/tugas-fungsi')->with('success', 'Data berhasil diubah');
    }
}
