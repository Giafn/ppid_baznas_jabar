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
        Schema::create('kantor_dan_layanan_ppid', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kantor');
            $table->string('alamat');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kantor_dan_layanan_ppid');
    }
};
