<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_profiles', function (Blueprint $table) {
            $table->string('intro_eyebrow', 80)->nullable()->after('hero_description');
            $table->string('intro_title', 180)->nullable()->after('intro_eyebrow');
            $table->string('intro_emphasis', 180)->nullable()->after('intro_title');
        });
    }

    public function down(): void
    {
        Schema::table('sales_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'intro_eyebrow',
                'intro_title',
                'intro_emphasis',
            ]);
        });
    }
};
