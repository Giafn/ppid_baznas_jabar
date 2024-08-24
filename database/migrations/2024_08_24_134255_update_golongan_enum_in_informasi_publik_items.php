<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = 'informasi_publik_items';
        $columnName = 'golongan';

        $newEnum = "('berkala', 'setiap_saat', 'serta_merta', 'kecualikan')";

        // Membuat perubahan kolom
        DB::statement("ALTER TABLE {$tableName} MODIFY {$columnName} ENUM {$newEnum}");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = 'informasi_publik_items';
        $columnName = 'golongan';

        // Menentukan enum lama
        $oldEnum = "('berkala', 'setiap_saat', 'serta_merta')";

        // Membuat perubahan kolom
        DB::statement("ALTER TABLE {$tableName} MODIFY {$columnName} ENUM {$oldEnum}");
    }
};
