<?php

namespace App\Http\Controllers\SettingPage;

use App\Http\Controllers\Controller;
use App\Models\SlideLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function index()
    {
        $sliders = SlideLanding::orderBy('posting_at', 'desc')
            ->where('posting_at', '<=', now())
            ->get();
        return view('setting-page.landing-page.index', compact('sliders'));
    }

    public function sliderSetting()
    {
        $sliders = SlideLanding::orderBy('posting_at', 'desc')->
            paginate(10);
        return view('setting-page.landing-page.slider-setting', compact('sliders'));
    }

    public function sliderSettingStore(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'posting' => 'required|date',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        try {
            Storage::disk('public')->putFileAs('slider', $request->file('image'), $imageName);
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal upload gambar');
        }

        try {
            DB::beginTransaction();
            $slide = new SlideLanding();
            $slide->url = $request->url;
            $slide->image_url = '/storage/slider/' . $imageName;
            $slide->posting_at = $request->posting;
            $slide->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Storage::disk('public')->delete('slider/' . $imageName);
            return back()->with('error', 'Gagal menyimpan data');
        }

        return back()->with('success', 'Berhasil menambahkan data');
    }

    public function sliderSettingDelete($id)
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

    public function sliderSettingUpdate(Request $request, $id)
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

    public function aksesCepatSetting()
    {
        return view('setting-page.landing-page.akses-cepat-setting');
    }
}
