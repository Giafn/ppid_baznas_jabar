<?php

namespace App\Http\Controllers\SettingPage\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\SlideLanding;
use App\Models\Video;
use Cohensive\OEmbed\Facades\OEmbed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('created_at', 'desc')->
            paginate(10);
        return view('setting-page.landing-page.video.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'url' => 'required|url',
        ]);

        try {
            DB::beginTransaction();
            Video::create([
                'title' => $request->title,
                'description' => $request->description ??  '-',
                'video_url' => $request->url,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data');
        }

        return back()->with('success', 'Berhasil menambahkan data');
    }

    public function delete($id)
    {
        $slide = SlideLanding::find($id);
        if ($slide) {
            try {
                DB::beginTransaction();
                $slide->delete();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', 'Gagal menghapus data');
            }
            Storage::disk('public')->delete('slider/' . basename($slide->image_url));
            return back()->with('success', 'Berhasil menghapus data');
        }
        return back()->with('error', 'Data tidak ditemukan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'posting' => 'required|date',
        ]);

        $slide = SlideLanding::find($id);
        if ($slide) {
            $imageName = $slide->image_url;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                try {
                    Storage::disk('public')->putFileAs('slider', $request->file('image'), $imageName);
                } catch (\Throwable $th) {
                    return back()->with('error', 'Gagal upload gambar');
                }
                Storage::disk('public')->delete('slider/' . basename($slide->image_url));
                $imageName = '/storage/slider/' . $imageName;
            }

            try {
                DB::beginTransaction();
                $slide->url = $request->url;
                $slide->image_url = $imageName;
                $slide->posting_at = $request->posting;
                $slide->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', 'Gagal menyimpan data');
            }

            return back()->with('success', 'Berhasil update data');
        }
        return back()->with('error', 'Data tidak ditemukan');
    }
}
