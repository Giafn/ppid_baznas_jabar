<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Validasi file
        $request->validate([
            'upload' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Unggah file
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads', $filename);

            // URL file yang diunggah
            $url = Storage::url($path);

            // Return URL file yang diunggah dalam format JSON
            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }
}
