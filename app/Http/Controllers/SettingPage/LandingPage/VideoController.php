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
        $video = Video::find($id);
        if ($video) {
            try {
                DB::beginTransaction();
                $video->delete();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', 'Gagal menghapus data');
            }

            return back()->with('success', 'Berhasil menghapus data');
        }
        return back()->with('error', 'Data tidak ditemukan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'url' => 'required|url',
        ]);
        $video = Video::find($id);
        if ($video) {
            try {
                DB::beginTransaction();
                $video->title = $request->title;
                $video->description = $request->description ??  '-';
                $video->video_url = $request->url;

                $video->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', 'Gagal menyimpan data');
            }

            return back()->with('success', 'Berhasil menyimpan data');
        }
        return back()->with('error', 'Data tidak ditemukan');
    }
}
