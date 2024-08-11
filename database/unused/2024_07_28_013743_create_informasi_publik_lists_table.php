<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informasi_publik_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('url');
            $table->foreignUuid('page_id')->constrained('pages', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_publik_lists');
    }
};
