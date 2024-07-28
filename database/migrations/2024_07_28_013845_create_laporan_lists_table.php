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
        Schema::create('laporan_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->enum('type', ['page', 'url']);
            $table->string('url');
            $table->foreignUuid('laporan_id')->constrained('laporans', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_lists');
    }
};
