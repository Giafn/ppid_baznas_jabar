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
        Schema::create('custom_page', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_page_id')->nullable()->index();
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->longtext('content')->nullable();
            $table->string('type_pages');//'single_file_or_images', 'list_file_or_image', 'content', 'list_content', 'video'
            $table->string('file_url')->nullable();
            $table->text('additional_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_page');
    }
};
