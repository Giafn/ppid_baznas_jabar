<?php

namespace App\Http\Controllers\SettingPage\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\SlideLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $validate['search'] = $request->search;
        $data = Berita::orderBy('posting_at', 'desc')
            ->when($validate['search'], function ($query) use ($validate) {
                $query->where('title', 'like', '%' . $validate['search'] . '%');
            })
            ->paginate(10);
        return view('setting-page.landing-page.informasi.index', compact('data'));
    }

    public function create()
    {
        return view('setting-page.landing-page.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255|string',
            'short_description' => 'required|max:255|string',
            'content' => 'required|min:10|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'publish_at' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $image = $request->file('image');
            $image_name = time() . '.' . $image->extension();
            $storage = Storage::disk('public')->putFileAs('informasi', $image, $image_name);
            $imageUrl = Storage::url($storage);

            Berita::create([
                'title' => $request->title,
                'slug' => $request->short_description,
                'content' => $request->content,
                'image' => $imageUrl,
                'posting_at' => $request->publish_at,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            if (isset($storage)) {
                Storage::disk('public')->delete($storage);
            }

            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }

        return redirect('/admin/landing-page-setting/informasi-setting')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Berita::findOrFail($id);
        return view('setting-page.landing-page.informasi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255|string',
            'short_description' => 'required|max:255|string',
            'content' => 'required|min:10|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'publish_at' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $data = Berita::findOrFail($id);
            $imageUrl = $data->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->extension();
                $storage = Storage::disk('public')->putFileAs('informasi', $image, $image_name);
                $imageUrl = Storage::url($storage);

                if ($data->image) {
                    $image = str_replace('/storage/', '', $data->image);
                    Storage::disk('public')->delete($image);
                }
            }

            $data->update([
                'title' => $request->title,
                'slug' => $request->short_description,
                'content' => $request->content,
                'image' => $imageUrl,
                'posting_at' => $request->publish_at,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            if (isset($storage)) {
                Storage::disk('public')->delete($storage);
            }

            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }

        return redirect('/admin/landing-page-setting/informasi-setting')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $data = Berita::findOrFail($id);
        $image = str_replace('/storage/', '', $data->image);

        try {
            DB::beginTransaction();

            $data->delete();
            Storage::disk('public')->delete($image);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }

        return redirect('/admin/landing-page-setting/informasi-setting')->with('success', 'Data berhasil dihapus');
    }
}
