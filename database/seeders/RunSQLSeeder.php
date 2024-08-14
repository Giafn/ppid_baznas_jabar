<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RunSQLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('sql/script.sql');

        // Membaca file SQL
        $sql = File::get($path);

        // Menjalankan file SQL
        DB::unprepared($sql);
    }
}
