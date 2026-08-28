<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_profiles', function (Blueprint $table) {
            $table->string('hero_image')->nullable()->after('photo');
            $table->string('hero_title')->nullable()->after('tagline');
            $table->text('hero_description')->nullable()->after('hero_title');
            $table->string('footer_image')->nullable()->after('hero_image');
            $table->string('footer_title')->nullable()->after('hero_description');
            $table->text('footer_description')->nullable()->after('footer_title');
        });

        Schema::create('sales_profile_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_profile_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30);
            $table->string('layout', 30)->default('media_left');
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('media_path')->nullable();
            $table->text('media_url')->nullable();
            $table->string('button_label')->nullable();
            $table->text('button_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['sales_profile_id', 'is_active', 'sort_order'], 'sales_sections_display_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_profile_sections');

        Schema::table('sales_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'hero_image',
                'hero_title',
                'hero_description',
                'footer_image',
                'footer_title',
                'footer_description',
            ]);
        });
    }
};
