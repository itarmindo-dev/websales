<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->text('quote');
            $table->string('photo')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('testimonials')->insert([
            [
                'name' => 'Hasbie Affan RH',
                'company' => 'PT Transport Corp',
                'quote' => 'Pelayanan sales responsif dan jelas. Unit diterima dalam keadaan baik, proses serah terima juga rapi.',
                'photo' => 'img/testimonial/ca-testimonial-ier1.1.png',
                'is_verified' => true,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'M G-Man',
                'company' => 'PT Bakti Gudang',
                'quote' => 'Konsultasinya membantu memilih unit sesuai muatan dan rute. Informasi biaya dijelaskan sejak awal.',
                'photo' => 'img/testimonial/ca-testimonial-ier1.2.png',
                'is_verified' => true,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Syaiful Nizar',
                'company' => 'CV Lestari',
                'quote' => 'Teknisi memahami kebutuhan armada kami. Servis terjadwal, pengerjaan cepat, dan truk kembali beroperasi.',
                'photo' => 'img/testimonial/ca-testi3.2.png',
                'is_verified' => true,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
