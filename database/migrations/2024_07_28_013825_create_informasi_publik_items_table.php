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
        Schema::create('informasi_publik_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('golongan', ['berkala', 'setiap_saat', 'serta_merta']);
            $table->string('group')->nullable();
            $table->string('nama');
            $table->enum('type', ['page', 'url']);
            $table->string('url')->nullable();
            $table->foreignUuid('page_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_publik_items');
    }
};
