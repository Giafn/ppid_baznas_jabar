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
        Schema::create('laporan_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laporan_id');
            $table->string('title');
            $table->string('sub_title');
            $table->text('mini_content');
            $table->enum('type', ['image', 'pdf']);
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_items');
    }
};
