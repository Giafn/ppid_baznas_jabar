<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {
        $items = Faqs::select('pertanyaan', 'content_jawaban', 'id')->orderBy('pertanyaan', 'asc')->get();
        return view('faqs.index', compact('items'));
    }
}
