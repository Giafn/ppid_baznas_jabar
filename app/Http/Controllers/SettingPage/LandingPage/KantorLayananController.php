<?php

namespace App\Http\Controllers\SettingPage\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\AksesCepats;
use App\Models\KantorLayanan;
use App\Models\SlideLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KantorLayananController extends Controller
{
    public function index()
    {
        $data = KantorLayanan::paginate(10);
        return view('setting-page.landing-page.kantor-layanan.index', compact('data'));
    }


    public  function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'no_telepon' => 'required|numeric|digits_between:10,13',
        ]);
        
        try {
            DB::beginTransaction();
            $data = new KantorLayanan();
            $data->nama_kantor = $request->nama;
            $data->alamat = $request->alamat;
            $data->email = $request->email;
            $data->telepon = $request->no_telepon;
            $data->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }

        return redirect('/admin/landing-page-setting/kantor-layanan')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'no_telepon' => 'required|numeric|digits_between:10,13',
        ]);

        try {
            DB::beginTransaction();
            $data = KantorLayanan::find($id);
            $data->nama_kantor = $request->nama;
            $data->alamat = $request->alamat;
            $data->email = $request->email;
            $data->telepon = $request->no_telepon;
            $data->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }

        return redirect('/admin/landing-page-setting/kantor-layanan')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = KantorLayanan::find($id);
            $data->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }

        return redirect('/admin/landing-page-setting/kantor-layanan')->with('success', 'Data berhasil dihapus');
    }
}
