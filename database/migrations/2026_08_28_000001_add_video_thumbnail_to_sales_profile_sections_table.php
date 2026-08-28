<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_profile_sections', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('media_url');
            $table->text('thumbnail_url')->nullable()->after('thumbnail_path');
        });
    }

    public function down(): void
    {
        Schema::table('sales_profile_sections', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_path', 'thumbnail_url']);
        });
    }
};
