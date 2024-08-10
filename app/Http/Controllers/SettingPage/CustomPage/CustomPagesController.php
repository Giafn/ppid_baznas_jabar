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
        // dd($request->all());
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:category_page,id',
            'type' => 'nullable|string|max:255',
        ]);
        $type = $request->type;
        $category = $request->category_id;
        $search = $request->search;
        if ($type && !array_key_exists($type, $this->translateTypePage)) {
            return redirect()->back()->with('error', 'Tipe halaman tidak ditemukan');
        }
        $pages = CustomPage::when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->when($category, function ($query) use ($category) {
            $query->where('category_page_id', $category);
        })
        ->when($type, function ($query) use ($type) {
            $query->where('type_pages', $type);
        })
        ->with('category')
        ->orderBy('created_at', 'desc')->paginate(10);

        // mapping type
        $pages->map(function ($item) {
            $item->type = $this->translateTypePage[$item->type_pages];
            $item->url = route('custom-page.show', [$item->id, Str::slug($item->title, '-')]);
            return $item;
        });

        $categories = CategoryPage::all();

        $typePages = $this->translateTypePage;

        return view('setting-page.custom-page.index', compact('pages', 'categories', 'typePages'));
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
                $embed = OEmbed::get($request->url);
                if (!$embed) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'URL video tidak valid')->withInput();
                }
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
            if (isset($storage)) {
                if (Storage::exists($storage)) {
                    Storage::delete($storage);
                }
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
            // $existingGroups = array_unique($existingGroups);
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
            // $existingGroups = array_unique($existingGroups);
            return view('setting-page.custom-page.edit-list-content', compact('page', 'kategori', 'existingItems', 'existingGroups'));
        }
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'kategori' => 'required|exists:category_page,id',

        ];

        $fullValidate = $this->additionalValidateUpdate($validate, $request->type);
        $request->validate($fullValidate);

        try {
            DB::beginTransaction();

            $pages = CustomPage::findOrFail($id);
            $pages->category_page_id = $request->kategori;
            $pages->title = $request->title;
            $pages->sub_title = $request->sub_title;
            $pages->type_pages = $request->type;

            if ($request->type == 'single-file-or-image') {
                if ($request->file('file')) {
                    $file = $request->file('file');
                    $file_name = time() . '.' . $file->extension();
                    $storage = Storage::disk('public')->putFileAs('custom-page', $file, $file_name);
                    $fileUrl = Storage::url($storage);
                    $pages->file_url = $fileUrl;
                }
                $pages->content = $request->content;
                $pages->save();
            } elseif ($request->type == 'single-video') {
                $embed = OEmbed::get($request->url);
                if (!$embed) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'URL video tidak valid')->withInput();
                }
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
            
                ItemsCustom::where('custom_page_id', $pages->id)->delete();
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

                ItemsCustom::where('custom_page_id', $pages->id)->delete();
                ItemsCustom::insert($itemInsert);
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Tipe halaman tidak ditemukan')->withInput();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($storage)) {
                if (Storage::exists($storage)) {
                    Storage::delete($storage);
                }
            }
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data')->withInput();
        }

        return redirect()->back()->with('success', 'Berhasil menyimpan data');
    }

    public function destroy($id)
    {
        $page = CustomPage::findOrFail($id);
        // TODO: Check if page is used in other page
        if ($page->type_pages == 'single-file-or-image') {
            if ($page->file_url) {
                $file = str_replace('/storage/', '', $page->file_url);
                Storage::disk('public')->delete($file);
            }
        } elseif ($page->type_pages == 'list-file-or-image') {
            $items = ItemsCustom::where('custom_page_id', $page->id)->get();
            foreach ($items as $key => $value) {
                if ($value->type == 'file' || $value->type == 'image') {
                    $file = str_replace('/storage/', '', $value->url);
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $page->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
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

    private function additionalValidateUpdate($validate, $type)
    {
        if ($type == 'single-file-or-image') {
            $validate['file'] = 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240';
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

    // show page
    public function show($id, $dashedTitle)
    {
        $page = CustomPage::findOrFail($id);
        $title = Str::slug($page->title, '-');
        if ($title != $dashedTitle) {
            abort(404);
        }

        if ($page->type_pages == 'single-file-or-image') {
            return view('custom-page.show-single-file-or-image', compact('page'));
        } elseif ($page->type_pages == 'single-video') {
            $embed = OEmbed::get($page->file_url);
            $embedHtml = '';
            if ($embed) {
                $embedHtml = $embed->html();
            }
            return view('custom-page.show-single-video', compact('page', 'embedHtml'));
        } elseif ($page->type_pages == 'list-file-or-image') {
            $items = ItemsCustom::where('custom_page_id', $page->id)->orderBy('parent_group', 'asc')->get();
            return view('custom-page.show-list-file-or-image', compact('page', 'items'));
        } elseif ($page->type_pages == 'single-content') {
            return view('custom-page.show-single-content', compact('page'));
        } elseif ($page->type_pages == 'list-content') {
            $items = ItemsCustom::where('custom_page_id', $page->id)->orderBy('parent_group', 'asc')->get();
            return view('custom-page.show-list-content', compact('page', 'items'));
        }
    }

    // get url
    public static function getUrl($id)
    {
        $page = CustomPage::findOrFail($id);
        return response()->json([
            'url' => route('custom-page.show', [$page->id, Str::slug($page->title, '-')]),
        ]);
    }

    // get item api
    public function getItems(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:category_page,id',
        ]);

        $type = $request->type;
        $search = $request->search;
        $category = $request->category_id;

        $pages = CustomPage::when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->when($type, function ($query) use ($type) {
            $query->where('type_pages', $type);
        })
        ->when($category, function ($query) use ($category) {
            $query->where('category_page_id', $category);
        })
        ->with('category')
        ->select('id', 'title', 'type_pages', 'category_page_id', 'created_at')
        ->orderBy('created_at', 'desc')->take(10)->get();

        // mapping type
        $pages->map(function ($item) {
            $item->type = $this->translateTypePage[$item->type_pages];
            $item->url = route('custom-page.show', [$item->id, Str::slug($item->title, '-')]);
            return $item;
        });

        return response()->json([
            'data' => $pages,
        ]);
    }

    public function getTypes()
    {
        $kategori = CategoryPage::select('id', 'nama')->get();
        return response()->json([
            'data' => $this->translateTypePage,
            'kategori' => $kategori,
        ]);
    }
}
