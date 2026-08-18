<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('truck_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('series')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('whatsapp_message')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('truck_models')->insert([
            [
                'name' => 'HINO 300',
                'series' => 'Dutro',
                'description' => 'Truk ringan untuk distribusi dalam kota dan kebutuhan usaha harian.',
                'image' => 'img/slider/truck-slide3.png',
                'whatsapp_message' => 'Halo Armindo Perkasa, saya ingin mengetahui informasi HINO 300.',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HINO 500',
                'series' => 'Ranger',
                'description' => 'Truk medium tangguh untuk logistik, konstruksi, dan perjalanan antarkota.',
                'image' => 'img/slider/truck-slide6.png',
                'whatsapp_message' => 'Halo Armindo Perkasa, saya ingin mengetahui informasi HINO 500.',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HINO 700',
                'series' => 'Profia',
                'description' => 'Kendaraan heavy duty untuk beban berat dan operasi dengan tuntutan tinggi.',
                'image' => 'img/slider/FM340PD_(1)1.png',
                'whatsapp_message' => 'Halo Armindo Perkasa, saya ingin mengetahui informasi HINO 700.',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('truck_models');
    }
};
