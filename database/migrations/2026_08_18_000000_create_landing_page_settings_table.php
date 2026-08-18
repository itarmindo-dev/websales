<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_eyebrow');
            $table->string('hero_title');
            $table->string('hero_highlight');
            $table->text('hero_description');
            $table->string('hero_background')->nullable();
            $table->string('hero_primary_label');
            $table->string('hero_secondary_label');
            $table->json('locations');

            $table->boolean('tco_enabled')->default(true);
            $table->string('tco_kicker');
            $table->string('tco_title');
            $table->string('tco_highlight');
            $table->text('tco_lead');
            $table->text('tco_description');
            $table->json('tco_benefits');
            $table->text('tco_promo');

            $table->boolean('models_enabled')->default(true);
            $table->string('models_kicker');
            $table->string('models_title');
            $table->string('models_highlight');
            $table->text('models_description');
            $table->string('models_note');
            $table->string('models_image')->nullable();
            $table->string('models_cta_label');
            $table->string('models_cta_subtitle');

            $table->boolean('testimonials_enabled')->default(true);
            $table->string('testimonials_title');
            $table->text('testimonials_description');
            $table->string('testimonials_watermark')->nullable();
            $table->json('service_promises');

            $table->boolean('contact_enabled')->default(true);
            $table->string('contact_kicker');
            $table->string('contact_title');
            $table->text('contact_description');
            $table->string('contact_background')->nullable();
            $table->string('whatsapp_number');
            $table->string('whatsapp_label');
            $table->string('website_url')->nullable();
            $table->string('website_label')->nullable();
            $table->string('address');
            $table->string('email');
            $table->string('business_hours');
            $table->string('contact_cta_label');
            $table->json('dealer_benefits');
            $table->timestamps();
        });

        DB::table('landing_page_settings')->insert([
            'hero_eyebrow' => 'Dealer resmi HINO',
            'hero_title' => 'Armindo Perkasa',
            'hero_highlight' => 'Armada Tangguh, Bisnis Maju',
            'hero_description' => 'Konsultasi unit, informasi stok, dan layanan purna jual HINO dari tim yang memahami kebutuhan bisnis Anda.',
            'hero_background' => 'img/slider/armindo_background.jpeg',
            'hero_primary_label' => 'Konsultasi Unit',
            'hero_secondary_label' => 'Lihat Produk',
            'locations' => json_encode(['Tangerang', 'Ciputat', 'Ciawi', 'Cirebon']),
            'tco_enabled' => true,
            'tco_kicker' => 'Perencanaan armada',
            'tco_title' => 'Cari Tahu Estimasi Biaya Operasional Armada',
            'tco_highlight' => 'HINO Anda',
            'tco_lead' => 'Investasi armada yang cerdas dimulai dari perhitungan yang tepat.',
            'tco_description' => 'Dapatkan proyeksi biaya bahan bakar, perawatan berkala, pengeluaran operasional, dan total biaya kepemilikan sebelum berinvestasi pada unit HINO baru.',
            'tco_benefits' => json_encode([
                'Simulasi biaya operasional',
                'Estimasi efisiensi bahan bakar',
                'Proyeksi biaya perawatan',
                'Analisis investasi armada',
            ]),
            'tco_promo' => 'Kesempatan mendapatkan merchandise eksklusif HINO dan voucher operasional bagi pelanggan terpilih.',
            'models_enabled' => true,
            'models_kicker' => 'Truk HINO impian Anda sudah tersedia',
            'models_title' => 'Siap Kirim!',
            'models_highlight' => 'Ready Unit',
            'models_description' => 'Unit terbatas dengan perputaran cepat. Dapatkan informasi stok terbaru, promo unit, dan konsultasi langsung dengan sales resmi kami hari ini.',
            'models_note' => 'Ketersediaan unit dapat berubah sewaktu-waktu.',
            'models_image' => 'img/shape/bus-3.png',
            'models_cta_label' => 'Chat WhatsApp Sekarang',
            'models_cta_subtitle' => 'Respon cepat · Konsultasi gratis',
            'testimonials_enabled' => true,
            'testimonials_title' => 'Kepercayaan Pelanggan Adalah Prioritas Kami',
            'testimonials_description' => 'Pengalaman pelanggan menjadi dasar kami untuk terus memberi layanan penjualan dan purna jual yang lebih baik.',
            'testimonials_watermark' => 'img/slider/truck-slide5.png',
            'service_promises' => json_encode([
                'Pelayanan Profesional',
                'Sales Responsif',
                'Unit Berkualitas',
                'Servis Terpercaya',
            ]),
            'contact_enabled' => true,
            'contact_kicker' => 'Dealer resmi HINO',
            'contact_title' => 'Siap Menemukan Unit HINO Terbaik Untuk Bisnis Anda?',
            'contact_description' => 'Konsultasikan kebutuhan armada Anda bersama tim sales profesional kami.',
            'contact_background' => 'img/shape/armindo1.png',
            'whatsapp_number' => '6281280061238',
            'whatsapp_label' => '0812 8006 1238',
            'website_url' => 'https://www.hinoarmindo.co.id',
            'website_label' => 'www.hinoarmindo.co.id',
            'address' => 'Jl. Daan Mogot, Tangerang',
            'email' => 'sales@hinoarmindo.co.id',
            'business_hours' => '09.00–17.00 WIB',
            'contact_cta_label' => 'Hubungi Sales Sekarang',
            'dealer_benefits' => json_encode([
                'Dealer Resmi HINO',
                'Ready Unit',
                'Pelayanan Profesional',
                'Servis & Sparepart',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_settings');
    }
};
