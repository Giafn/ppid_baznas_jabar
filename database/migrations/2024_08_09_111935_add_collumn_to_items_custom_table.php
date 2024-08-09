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
        Schema::table('items_custom', function (Blueprint $table) {
            $table->foreignUuid('custom_page_id')->nullable()->constrained('custom_page')->onDelete('cascade')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items_custom', function (Blueprint $table) {
            $table->dropForeign(['custom_page_id']);
            $table->dropColumn('custom_page_id');
        });
    }
};
