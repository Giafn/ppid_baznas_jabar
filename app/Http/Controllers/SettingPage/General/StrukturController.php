<?php

namespace App\Http\Controllers\SettingPage\General;

use App\Http\Controllers\Controller;
use App\Models\GeneralContentList;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StrukturController extends Controller
{
    public function index()
    {
        $strukturOrganisasi = GeneralContentList::where('nama', 'struktur')->with('page')->first();
        if (!$strukturOrganisasi) {
            return redirect('/admin/home')->with('error', 'Terjadi Kesalahan');
        }

        return view('setting-page.general.struktur-organisasi.index', compact('strukturOrganisasi'));
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|string',
            'content' => 'required|min:10|string',
        ]);

        $strukturOrganisasi = GeneralContentList::where('nama', 'struktur')->with('page')->first();

        try {
            if (!$strukturOrganisasi) {
                // Start transaction
                DB::beginTransaction();

                // Create the page
                $page = Pages::create([
                    'title' => $validate['title'],
                    'content' => $validate['content'],
                    'posting_at' => now(), // Use Laravel's now() helper for current datetime
                ]);

                // Create the struktur
                $strukturOrganisasi = GeneralContentList::create([
                    'nama' => 'struktur',
                    'page_id' => $page->id,
                ]);

                // Commit the transaction
                DB::commit();
            } else {
                // Update existing struktur page
                DB::beginTransaction();

                $page = $strukturOrganisasi->page;
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


        return redirect('/admin/general/struktur-organisasi')->with('success', 'Data berhasil diubah');
    }
}
