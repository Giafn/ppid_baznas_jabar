<?php

namespace App\Http\Controllers\SettingPage\CustomPage;

use App\Http\Controllers\Controller;
use App\Models\CategoryPage;
use App\Models\CustomPage;
use App\Models\ItemsCustom;
use Cohensive\OEmbed\Facades\OEmbed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomPagesController extends Controller
{
    public $translateTypePage = [
        'single-file-or-image' => 'Tampilan File atau Gambar',
        'single-video' => 'Tampilan Video',
        'list-file-or-image' => 'Tampilan List File atau Gambar',
        'single-content' => 'Tampilan Konten',
        'list-content' => 'Tampilan List Konten',
    ];

    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $search = $request->search;
        $pages = CustomPage::when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->with('category')
        ->orderBy('created_at', 'desc')->paginate(10);

        // mapping type
        $pages->map(function ($item) {
            $item->type = $this->translateTypePage[$item->type_pages];
            return $item;
        });

        return view('setting-page.custom-page.index', compact('pages'));
    }

    public function create($type)
    {
        $acceptedType = [
            'single-file-or-image',
            'single-video',
            'list-file-or-image',
            'single-content',
            'list-content',
        ];
        if (!in_array($type, $acceptedType)) {
            abort(404);
        }

        $kategori = CategoryPage::all();
        
        if ($type == 'single-file-or-image') {
            return view('setting-page.custom-page.create-single-file-or-image', compact('kategori'));
        } elseif ($type == 'single-video') {
            return view('setting-page.custom-page.create-single-video', compact('kategori'));
        } elseif ($type == 'list-file-or-image') {
            return view('setting-page.custom-page.create-list-file-or-image', compact('kategori'));
        } elseif ($type == 'single-content') {
            return view('setting-page.custom-page.create-single-content', compact('kategori'));
        } elseif ($type == 'list-content') {
            return view('setting-page.custom-page.create-list-content', compact('kategori'));
        }
    }

    public function store(Request $request)
    {
        $validate = [
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'kategori' => 'required|exists:category_page,id',

        ];
        $fullValidate = $this->additionalValidate($validate, $request->type);
        $request->validate($fullValidate);
        
        try {
            DB::beginTransaction();

            $pages = new CustomPage();
            $pages->category_page_id = $request->kategori;
            $pages->title = $request->title;
            $pages->sub_title = $request->sub_title;
            $pages->type_pages = $request->type;

            if ($request->type == 'single-file-or-image') {
                $file = $request->file('file');
                $file_name = time() . '.' . $file->extension();
                $storage = Storage::disk('public')->putFileAs('custom-page', $file, $file_name);
                $fileUrl = Storage::url($storage);
                $pages->file_url = $fileUrl;
                $pages->content = $request->content;
                $pages->save();
            } elseif ($request->type == 'single-video') {
                $pages->file_url = $request->url;
                $pages->content = $request->content;
                $pages->save();
            } elseif ($request->type == 'list-file-or-image') {
                $pages->content = $request->content;
                $pages->save();
                
                try {
                    $groups = $request->groups ?? [];
                    $items = $request->items ?? [];
                    $groupsArray = [];
                    $itemsArray = [];
                    $itemInsert = [];
                    foreach ($groups as $key => $group) {
                        $groupsArray[$key] = json_decode($group, true)['label'];
                    }
                    foreach ($items as $key => $jsonString) {
                        $itemsArray[$key] = json_decode($jsonString, true);
                        $itemInsert[$key]['id'] = (string) Str::uuid();
                        $itemInsert[$key]['custom_page_id'] = $pages->id;
                        $itemInsert[$key]['title'] = $itemsArray[$key]['label'];
                        $itemInsert[$key]['parent_group'] = $itemsArray[$key]['group'] ? $groupsArray[$itemsArray[$key]['group']] : null;
                        $itemInsert[$key]['desc'] = $itemsArray[$key]['keterangan'];
                        $itemInsert[$key]['type'] = $itemsArray[$key]['type'];

                        // copy file from temp folder to custom-page folder
                        if ($itemsArray[$key]['type'] == 'file' || $itemsArray[$key]['type'] == 'image') {
                            $file = $itemsArray[$key]['url'];
                            $sourcePath = str_replace('/storage/', '', $file);
                            $destinationPath = str_replace('temp/', 'custom-page/', $sourcePath);
                            Storage::disk('public')->copy($sourcePath, $destinationPath);
                            $itemInsert[$key]['url'] = Storage::url($destinationPath);
                        } else {
                            $itemInsert[$key]['url'] = $itemsArray[$key]['url'];
                        }

                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    if (isset($storage)) {
                        Storage::delete($storage);
                    }

                    return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
                }

                ItemsCustom::insert($itemInsert);

            } elseif ($request->type == 'single-content') {
                $pages->content = $request->content;
                $pages->save();
            } elseif ($request->type == 'list-content') {
                $pages->content = $request->content;
                $pages->save();
                
                try {
                    $groups = $request->groups ?? [];
                    $items = $request->items ?? [];
                    $groupsArray = [];
                    $itemsArray = [];
                    $itemInsert = [];
                    foreach ($groups as $key => $group) {
                        $groupsArray[$key] = json_decode($group, true)['label'];
                    }
                    foreach ($items as $key => $jsonString) {
                        $itemsArray[$key] = json_decode($jsonString, true);
                        $itemInsert[$key]['id'] = (string) Str::uuid();
                        $itemInsert[$key]['custom_page_id'] = $pages->id;
                        $itemInsert[$key]['title'] = $itemsArray[$key]['label'];
                        $itemInsert[$key]['parent_group'] = $itemsArray[$key]['group'] ? $groupsArray[$itemsArray[$key]['group']] : null;
                        $itemInsert[$key]['type'] = "content";
                        $itemInsert[$key]['content'] = $itemsArray[$key]['konten'];

                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
                }

                ItemsCustom::insert($itemInsert);
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Tipe halaman tidak ditemukan')->withInput();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::exists($storage)) {
                Storage::delete($storage);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }


        return redirect('/admin/custom-page')->with('success', 'Berhasil menyimpan data');
    }

    public function edit($id)
    {
        $page = CustomPage::findOrFail($id);
        $kategori = CategoryPage::all();

        if ($page->type_pages == 'single-file-or-image') {
            return view('setting-page.custom-page.edit-single-file-or-image', compact('page', 'kategori'));
        } elseif ($page->type_pages == 'single-video') {
            $urlOriginal = $page->file_url;
            $embed = OEmbed::get($page->file_url);
            $embedHtml = '';
            if ($embed) {
                $embedHtml = $embed->html();
            }
            $page->original_url = $page->file_url;
            return view('setting-page.custom-page.edit-single-video', compact('page', 'kategori', 'embedHtml'));
        } elseif ($page->type_pages == 'list-file-or-image') {
            $item = ItemsCustom::where('custom_page_id', $page->id)->get();
            $existingItems = [];
            $existingGroups = [];
            $groups = ItemsCustom::where('custom_page_id', $page->id)->whereNotNull('parent_group')->get()->pluck('parent_group')->toArray();
            foreach ($groups as $key => $group) {
                $idGroup = str_replace(' ', '_', $group);
                $existingGroups[$idGroup] = [
                    'label' => $group,
                    'id' => $idGroup
                ];
            }

            foreach ($item as $key => $value) {
                $existingItems[$key]['label'] = $value->title;
                $existingItems[$key]['keterangan'] = $value->desc;
                $existingItems[$key]['type'] = $value->type;
                $existingItems[$key]['url'] = $value->url;
                $existingItems[$key]['id'] = $value->id;
                if ($value->parent_group) {
                    $existingItems[$key]['group'] = $existingGroups[str_replace(' ', '_', $value->parent_group)]['id'];
                } else {
                    $existingItems[$key]['group'] = null;
                }

            }
            $existingGroups = array_unique($existingGroups);
            return view('setting-page.custom-page.edit-list-file-or-image', compact('page', 'kategori', 'existingItems', 'existingGroups'));
        } elseif ($page->type_pages == 'single-content') {
            return view('setting-page.custom-page.edit-single-content', compact('page', 'kategori'));
        } elseif ($page->type_pages == 'list-content') {
            $item = ItemsCustom::where('custom_page_id', $page->id)->get();
            $existingItems = [];
            $existingGroups = [];
            $groups = ItemsCustom::where('custom_page_id', $page->id)->whereNotNull('parent_group')->get()->pluck('parent_group')->toArray();
            foreach ($groups as $key => $group) {
                $idGroup = str_replace(' ', '_', $group);
                $existingGroups[$idGroup] = [
                    'label' => $group,
                    'id' => $idGroup
                ];
            }

            foreach ($item as $key => $value) {
                $existingItems[$key]['label'] = $value->title;
                $existingItems[$key]['konten'] = $value->content;
                $existingItems[$key]['id'] = $value->id;
                if ($value->parent_group) {
                    $existingItems[$key]['group'] = $existingGroups[str_replace(' ', '_', $value->parent_group)]['id'];
                } else {
                    $existingItems[$key]['group'] = null;
                }

            }
            $existingGroups = array_unique($existingGroups);
            return view('setting-page.custom-page.edit-list-content', compact('page', 'kategori', 'existingItems', 'existingGroups'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'google_form_url' => 'required|string|max:255',
            'form_file' => 'nullable|file|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $formulir = Formulir::findOrFail($id);
            $formulir->nama = $request->nama;
            $formulir->deskripsi = $request->deskripsi;
            $formulir->google_form_url = $request->google_form_url;

            if ($request->hasFile('form_file')) {
                $file = $request->file('form_file');
                $file_name = time() . '.' . $file->extension();
                $storage = Storage::disk('public')->putFileAs('informasi', $file, $file_name);
                $fileUrl = Storage::url($storage);
                $formulir->form_file_url = $fileUrl;
            }

            $formulir->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::exists($storage)) {
                Storage::delete($storage);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }

        return redirect()->back()->with('success', 'Berhasil menyimpan data');
    }

    public function destroy($id)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();

        return redirect('/admin/layanan-informasi/formulir')->with('success', 'Berhasil menghapus data');
    }

    private function additionalValidate($validate, $type)
    {
        if ($type == 'single-file-or-image') {
            $validate['file'] = 'required|file|mimes:pdf,png,jpg,jpeg|max:10240';
        } elseif ($type == 'single-video') {
            $validate['url'] = 'required|url';
        } elseif ($type == 'list-file-or-image') {
            $validate['content'] = 'nullable|string';
            $validate['items'] = 'required|array';
            $validate['items.*'] = 'required';
            $validate['groups'] = 'nullable|array';
            $validate['groups.*'] = 'nullable|string';
        } elseif ($type == 'single-content') {
            $validate['content'] = 'required|string';
        } elseif ($type == 'list-content') {
            $validate['content'] = 'nullable|string';
            $validate['items'] = 'required|array';
            $validate['items.*'] = 'required';
            $validate['groups'] = 'nullable|array';
            $validate['groups.*'] = 'nullable|string';
        }

        return $validate;
    }
}
