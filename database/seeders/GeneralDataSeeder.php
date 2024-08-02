<?php

namespace Database\Seeders;

use App\Models\GeneralContentList;
use App\Models\Pages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrTitle = [
            'profile',
            'tugas_fungsi',
            'visi_misi',
            'struktur',
        ];

        foreach ($arrTitle as $title) {
                
            $page = Pages::create([
                'title' => str_replace('_', ' ', $title),
                'content' => 'Ubah konten ini di halaman setting.',
                'posting_at' => now(),
            ]);

            GeneralContentList::create([
                'nama' => $title,
                'page_id' => $page->id,
            ]);

        }
    }
}
