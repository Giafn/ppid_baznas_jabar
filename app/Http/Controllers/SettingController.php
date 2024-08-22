<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $infoKantor = Setting::where('key', 'informasi_kantor')->first();
        $infoKantor = json_decode($infoKantor->value);
        $embedMap = Setting::where('key', 'embed_map')->first()->value;

        $sosmed = Setting::where('key', 'sosial_media')->first()->value;
        $sosmed = json_decode($sosmed);
        return view('setting', compact('infoKantor', 'embedMap', 'sosmed'));
    }

    // update email / password
    public function updateCredential(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password_baru' => 'nullable|min:6',
            'konfirmasi_password_baru' => 'required_with:password|same:password',
            'password_lama' => 'required_with:password'
        ]);

        $user = User::find(auth()->user()->id);
        try {
            if ($request->password_baru) {
                if (Hash::check($request->password_lama, $user->password)) {
                    $user->update([
                        'email' => $request->email,
                        'password' => bcrypt($request->password_baru)
                    ]);
                } else {
                    return redirect()->back()->with('error', 'Password lama tidak sesuai');
                }
            } else {
                $user->update([
                    'email' => $request->email
                ]);
            }
            return redirect()->back()->with('success', 'Berhasil mengubah data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah data');
        }

    }

    // update informasi kantor
    public function updateOffice(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'alamat_kantor' => 'required|string|max:255',
            'telepon_kantor' => 'required|numeric|digits_between:10,15',
            'email_kantor' => 'required|email',
        ]);

        $informasiKantor = [
            'nama_kantor' => $request->nama_kantor,
            'alamat_kantor' => $request->alamat_kantor,
            'telepon_kantor' => $request->telepon_kantor,
            'email_kantor' => $request->email_kantor,
            'website_kantor' => $request->website_kantor,
            'deskripsi_kantor' => $request->deskripsi_kantor
        ];
        try {
            Setting::where('key', 'informasi_kantor')->update([
                'value' => json_encode($informasiKantor)
            ]);
            return redirect()->back()->with('success', 'Berhasil mengubah data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah data');
        }
    }

    // update embed map
    public function updateMaps(Request $request)
    {
        $request->validate([
            'embed_maps' => 'required|string'
        ]);

        try {
            Setting::where('key', 'embed_map')->update([
                'value' => $request->embed_maps
            ]);
            return redirect()->back()->with('success', 'Berhasil mengubah data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah data');
        }
    }

    // update sosial media
    public function updateSosmed(Request $request)
    {
        $request->validate([
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'youtube' => 'nullable|url',
            'whatsapp' => 'nullable|url',
            'twitter' => 'nullable|url',
        ]);

        $sosmed = [
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,
            'whatsapp' => $request->whatsapp,
            'twitter' => $request->twitter
        ];
        try {
            Setting::where('key', 'sosial_media')->update([
                'value' => json_encode($sosmed)
            ]);
            return redirect()->back()->with('success', 'Berhasil mengubah data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah data');
        }
    }


}
