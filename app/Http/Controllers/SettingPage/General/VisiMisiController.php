<?php

namespace App\Http\Controllers\SettingPage\General;

use App\Http\Controllers\Controller;
use App\Models\GeneralContentList;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisiMisiController extends Controller
{
    public function index()
    {
        $visiMisi = GeneralContentList::where('nama', 'visi_misi')->with('page')->first();
        // if (!$visiMisi) {
        //     return redirect('/admin/home')->with('error', 'Terjadi Kesalahan');
        // }

        return view('setting-page.general.visi-misi.index', compact('visiMisi'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'title' => 'required|max:255|string',
            'content' => 'required|min:10|string',
        ]);

        $visiMisi = GeneralContentList::where('nama', 'visi_misi')->with('page')->first();

        try {
            if (!$visiMisi) {
                // Start transaction
                DB::beginTransaction();

                // Create the page
                $page = Pages::create([
                    'title' => $validate['title'],
                    'content' => $validate['content'],
                    'posting_at' => now(), // Use Laravel's now() helper for current datetime
                ]);

                // Create the visi_misi
                $visiMisi = GeneralContentList::create([
                    'nama' => 'visi_misi',
                    'page_id' => $page->id,
                ]);

                // Commit the transaction
                DB::commit();
            } else {
                // Update existing visi_misi page
                DB::beginTransaction();

                $page = $visiMisi->page;
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


        return redirect('/admin/general/visi-misi')->with('success', 'Data berhasil diubah');
    }
}
