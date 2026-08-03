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
        Schema::table('sales_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('sales_profiles', 'tagline')) {
                $table->string('tagline')->nullable();
            }
            if (!Schema::hasColumn('sales_profiles', 'instagram')) {
                $table->string('instagram')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_profiles', function (Blueprint $table) {
            $table->dropColumn(['tagline', 'instagram']);
        });
    }
};
