<?php

namespace App\Http\Controllers\SettingPage\InformasiPublik;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublikItems;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DikecualikanController extends Controller
{
    public function index(Request $request)
        {
            $validate = $request->validate([
                'search' => 'nullable|string|max:255',
            ]);
    
            $search = $request->search;
            $items = InformasiPublikItems::when($search, function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->where('golongan', 'kecualikan')
            ->orderBy('created_at', 'desc')
            ->orderBy('group', 'asc')
            ->paginate(10);

        $items->map(function ($item) {
            if ($item->type == 'page') {
                $item->url = '/informasi-publik/' . $item->id . '/' . str_replace(' ', '-', $item->nama);
            }
            return $item;
        });

        return view('setting-page.informasi-publik.kecualikan.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        // check url is google drive
        if (strpos($validate['url'], 'drive.google.com') === false) {
            return redirect()->back()->with('error', 'URL harus berasal dari Google Drive');
        }

        if (!$this->isAccessible($validate['url'])) {
            return redirect()->back()->with('error', 'URL tidak valid');
        }

        $viewUrl = $this->getPreviewUrl($validate['url']);
        if (!$viewUrl) {
            return redirect()->back()->with('error', 'URL tidak valid');
        }

        try {
            DB::beginTransaction();
            $url = $viewUrl;
            $nama = $validate['nama'];

            $list = InformasiPublikItems::create([
                'nama' => $nama,
                'type' => 'url',
                'url' => $url,
                'golongan' => 'kecualikan',
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/informasi-publik/dikecualikan')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = InformasiPublikItems::where('id', $id)->with('page')->first();
        if (!$item) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        // check url is google drive
        if (strpos($validate['url'], 'drive.google.com') === false) {
            return redirect()->back()->with('error', 'URL harus berasal dari Google Drive');
        }

        if (!$this->isAccessible($validate['url'])) {
            return redirect()->back()->with('error', 'URL tidak valid');
        }

        $viewUrl = $this->getPreviewUrl($validate['url']);
        if (!$viewUrl) {
            return redirect()->back()->with('error', 'URL tidak valid');
        }

        try {
            DB::beginTransaction();
            $url = $viewUrl;
            $nama = $validate['nama'];

            $item = InformasiPublikItems::findOrFail($id);
            $item->update([
                'nama' => $nama,
                'type' => 'url',
                'url' => $url,
            ]);
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/informasi-publik/dikecualikan')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {   
            DB::beginTransaction();
            $item = InformasiPublikItems::findOrFail($id);
            $item->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/admin/informasi-publik/dikecualikan')->with('success', 'Data berhasil dihapus');
    }

    private function getPreviewUrl($url)
    {
        preg_match('~/d/\K[^/]+(?=/)~', $url, $result);
        if (empty($result)) {
            return null;
        }
        $fileId = $result[0];

        return "https://drive.google.com/file/d/" . $fileId . "/preview";
    }

    // cek url google drive is accessible
    private function isAccessible($url)
    {
        $headers = get_headers($url);

        if (!$headers) {
            return false;
        }

        return strpos($headers[0], '404') === false;
    }

}
