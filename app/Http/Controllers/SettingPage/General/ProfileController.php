<?php

namespace App\Http\Controllers\SettingPage\General;

use App\Http\Controllers\Controller;
use App\Models\GeneralContentList;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = GeneralContentList::where('nama', 'profile')->with('page')->first();
        if (!$profile) {
            return redirect('/admin/home')->with('error', 'Terjadi Kesalahan');
        }

        return view('setting-page.general.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|string',
            'content' => 'required|min:10|string',
        ]);

        $profile = GeneralContentList::where('nama', 'profile')->with('page')->first();

        try {
            if (!$profile) {
                // Start transaction
                DB::beginTransaction();

                // Create the page
                $page = Pages::create([
                    'title' => $validate['title'],
                    'content' => $validate['content'],
                    'posting_at' => now(), // Use Laravel's now() helper for current datetime
                ]);

                // Create the profile
                $profile = GeneralContentList::create([
                    'nama' => 'profile',
                    'page_id' => $page->id,
                ]);

                // Commit the transaction
                DB::commit();
            } else {
                // Update existing profile page
                DB::beginTransaction();

                $page = $profile->page;
                $page->title = $validate['title'];
                $page->content = $validate['content'];
                $page->save();

                DB::commit();
            }
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal ditambahkan atau diperbarui: ' . $e->getMessage());
        }


        return redirect('/admin/general/profile')->with('success', 'Data berhasil diubah');
    }
}
