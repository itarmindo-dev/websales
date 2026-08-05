const fs = require('fs');

const tcoStyle = fs.readFileSync('tco_style.txt', 'utf16le').replace(/\uFEFF/g, '').replace(/\r\n\r\n/g, '\n');
const tcoForm = fs.readFileSync('tco_form.txt', 'utf16le').replace(/\uFEFF/g, '').replace(/\r\n\r\n/g, '\n');
const tcoScript = fs.readFileSync('tco_script.txt', 'utf16le').replace(/\uFEFF/g, '').replace(/\r\n\r\n/g, '\n');

const newIndex = `
@extends('layouts.base', ['title' => '01'])

@section('header')
    @include('layouts.partials.header.navbar')
    @include('layouts.partials.header.mobile-nav')
@endsection

@section('content')
    <style>
        /* Custom Colors */
        .text-hino-green { color: #009b44; }
        .bg-hino-green { background-color: #009b44; }
        .bg-hino-green-dark { background-color: #007f3d; }
        .text-hino-red { color: #ce1126; }
        
        /* Glassmorphism for TCO Calculator */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 155, 68, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 155, 68, 0.1);
        }
        
        .hero-bg-gradient {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        }
    </style>

    ${tcoStyle}

    <main id="vue-app" class="font-sans antialiased text-gray-800 bg-white selection:bg-green-500 selection:text-white">

    <!-- PAGE 1: HERO SECTION -->
    <section class="hero-bg-gradient pt-16 pb-24 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Kiri: Teks & Map -->
                <div class="relative z-10">
                    <!-- Map Graphic Placeholder (Using CSS to simulate the PDF map) -->
                    <div class="mb-8 relative h-48 w-full bg-green-50/50 rounded-2xl border border-green-100 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[url('https://upload.wikimedia.org/wikipedia/commons/4/4e/Java_map_blank.svg')] bg-no-repeat bg-center bg-cover"></div>
                        <div class="relative z-10 w-full h-full">
                            <!-- Pins -->
                            <div class="absolute top-8 left-1/4 flex flex-col items-center">
                                <div class="w-8 h-10 bg-hino-green rounded-t-full rounded-bl-full transform rotate-45 flex items-center justify-center shadow-lg shadow-green-600/50">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <span class="text-xs font-bold mt-1 text-green-900 bg-white/80 px-2 py-0.5 rounded">TANGERANG</span>
                            </div>
                            <div class="absolute top-20 left-1/3 flex flex-col items-center">
                                <div class="w-8 h-10 bg-hino-green rounded-t-full rounded-bl-full transform rotate-45 flex items-center justify-center shadow-lg shadow-green-600/50">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <span class="text-xs font-bold mt-1 text-green-900 bg-white/80 px-2 py-0.5 rounded">CIPUTAT</span>
                            </div>
                            <div class="absolute bottom-10 left-1/2 flex flex-col items-center">
                                <div class="w-8 h-10 bg-hino-green rounded-t-full rounded-bl-full transform rotate-45 flex items-center justify-center shadow-lg shadow-green-600/50">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <span class="text-xs font-bold mt-1 text-green-900 bg-white/80 px-2 py-0.5 rounded">CIAWI</span>
                            </div>
                            <div class="absolute top-12 right-1/4 flex flex-col items-center">
                                <div class="w-8 h-10 bg-hino-green rounded-t-full rounded-bl-full transform rotate-45 flex items-center justify-center shadow-lg shadow-green-600/50">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <span class="text-xs font-bold mt-1 text-green-900 bg-white/80 px-2 py-0.5 rounded">CIREBON</span>
                            </div>
                            <!-- Connecting Lines -->
                            <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M120,50 Q160,80 180,90 T250,140 T350,70" fill="none" stroke="#009b44" stroke-width="2" stroke-dasharray="5,5" opacity="0.5"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-hino-green font-bold tracking-wider text-sm md:text-base mb-2">DISTRIBUTOR RESMI HINO INDONESIA</h2>
                    <h1 class="text-4xl md:text-6xl font-black text-[#0f3f26] leading-tight mb-6 tracking-tight" style="font-family: inherit;">
                        ARMINDO PERKASA
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 font-medium">
                        PERFORMA TANGGUH, MITRA BISNIS TERPERCAYA.<br class="hidden md:block"> JARINGAN LAYANAN NASIONAL.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-12">
                        <a href="#contact" class="bg-hino-green hover:bg-hino-green-dark text-white px-8 py-4 rounded-full font-bold transition-all shadow-xl shadow-green-500/40 transform hover:-translate-y-1">
                            KONSULTASI UNIT
                        </a>
                        <a href="#models" class="bg-white border-2 border-[#0f3f26] text-[#0f3f26] hover:bg-[#0f3f26] hover:text-white px-8 py-4 rounded-full font-bold transition-all transform hover:-translate-y-1">
                            LIHAT PRODUK
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-8 text-sm font-semibold text-gray-600">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-normal">TERAKREDITASI</span>
                                HINO MOTOR SALES INDONESIA
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-normal">PEMENANG PENGHARGAAN</span>
                                DEALER TERBAIK
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Vue Truck Showcase -->
                <div class="relative w-full h-[400px] lg:h-[600px] flex items-center justify-center">
                    <!-- Platform Bulat -->
                    <div class="absolute bottom-10 w-[120%] h-32 bg-green-500/10 rounded-[100%] blur-xl transform -rotate-2"></div>
                    <div class="absolute bottom-16 w-[90%] h-20 border-2 border-green-500/30 rounded-[100%]"></div>
                    <div class="absolute bottom-20 w-[70%] h-16 border-2 border-green-500/50 rounded-[100%] shadow-[0_0_30px_rgba(0,155,68,0.4)]"></div>
                    
                    <!-- Ini akan dimount oleh komponen Vue jika dibuat, atau fallback ke gambar statis -->
                    <hero-truck-showcase></hero-truck-showcase>
                </div>
            </div>
        </div>
    </section>

    <!-- PAGE 2: TCO CALCULATOR -->
    <section class="py-24 bg-gray-50 relative overflow-hidden">
        <!-- Abstract waves -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-20">
            <svg class="absolute w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0,50 Q25,30 50,50 T100,50 L100,100 L0,100 Z" fill="#e5e7eb" />
                <path d="M0,60 Q35,20 70,60 T100,40 L100,100 L0,100 Z" fill="#f3f4f6" />
                <path d="M0,80 Q40,50 80,80 T100,60 L100,100 L0,100 Z" fill="rgba(0,155,68,0.05)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <div>
                    <h2 class="text-3xl md:text-5xl font-bold text-[#0f3f26] mb-6 leading-tight" style="font-family: inherit;">
                        Cari Tahu Estimasi Biaya<br> Operasional Armada HINO Anda
                    </h2>
                    <p class="text-xl font-semibold text-gray-700 mb-4">
                        Investasi armada yang cerdas dimulai dari perhitungan yang tepat.
                    </p>
                    <p class="text-gray-600 mb-10 leading-relaxed">
                        Dapatkan gambaran jelas mengenai proyeksi biaya bahan bakar, estimasi biaya perawatan berkala, pengeluaran operasional harian, dan total biaya kepemilikan (TCO) jangka panjang sebelum Anda berinvestasi pada unit truk HINO baru. Perencanaan matang untuk efisiensi bisnis Anda.
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto bg-green-50 border-2 border-hino-green rounded-full flex items-center justify-center text-hino-green mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800">Simulasi biaya<br>operasional</h4>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto bg-green-50 border-2 border-hino-green rounded-full flex items-center justify-center text-hino-green mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800">Estimasi efisiensi<br>bahan bakar</h4>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto bg-green-50 border-2 border-hino-green rounded-full flex items-center justify-center text-hino-green mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800">Proyeksi biaya<br>perawatan</h4>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto bg-green-50 border-2 border-hino-green rounded-full flex items-center justify-center text-hino-green mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-sm text-gray-800">Analisis investasi<br>armada</h4>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">Kesempatan mendapatkan <span class="text-hino-green">merchandise eksklusif HINO & voucher operasional</span> bagi pelanggan terpilih.</p>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-12 h-16 bg-gray-100 rounded border border-gray-200 flex items-center justify-center">
                                <div class="w-6 h-8 border-2 border-hino-green rounded-full flex flex-col justify-center items-center">
                                    <div class="w-3 h-0.5 bg-hino-green mb-1"></div>
                                    <span class="text-[6px] text-hino-green font-bold">HINO</span>
                                </div>
                            </div>
                            <div class="w-16 h-12 bg-gray-100 rounded border border-gray-200 mt-2 flex items-center justify-center overflow-hidden relative">
                                <div class="absolute inset-0 bg-green-50"></div>
                                <span class="relative z-10 text-[8px] font-bold text-gray-700">Gift card</span>
                                <div class="absolute right-1 bottom-1 w-4 h-4 bg-gray-300 rounded-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kalkulator Component -->
                <div class="glass-card rounded-2xl p-8 relative">
                    <!-- Judul form -->
                    <div class="flex items-center gap-4 border-b border-gray-200 pb-4 mb-6">
                        <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white font-bold italic tracking-tighter"><span class="transform -skew-x-12">H</span></div>
                        <span class="font-black text-xl text-gray-800">HINO</span>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <h3 class="text-2xl font-bold text-gray-700">Kalkulator TCO</h3>
                    </div>

                    <div class="tco-stepper" id="tcoStepper">
                        <div class="tco-step active" id="stepIndicator1">1</div>
                        <div class="tco-step" id="stepIndicator2">2</div>
                        <div class="tco-step" id="stepIndicator3">3</div>
                    </div>

                    ${tcoForm}
                </div>

            </div>
        </div>
    </section>

    <!-- PAGE 3: READY UNIT -->
    <section id="models" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="order-2 lg:order-1 relative">
                    <p class="text-xl text-gray-600 mb-2">Truk HINO Impian Anda Sudah Tersedia</p>
                    <h2 class="text-5xl md:text-7xl font-black text-[#0f3f26] mb-2" style="font-family: inherit;">READY UNIT</h2>
                    <h2 class="text-4xl md:text-6xl font-bold text-gray-900 mb-8" style="font-family: inherit;">- Siap Kirim!</h2>
                    
                    <p class="text-xl text-gray-600 mb-12 leading-relaxed">
                        Unit terbatas dengan perputaran sangat cepat. Dapatkan informasi stok terbaru, promo unit, dan konsultasi langsung dengan sales resmi kami hari ini.
                    </p>
                    
                    <p class="text-sm text-gray-500 mb-8">Ketersediaan unit dapat berubah sewaktu-waktu.</p>
                </div>

                <div class="order-1 lg:order-2 relative h-[400px] md:h-[500px]">
                    <!-- Placeholder untuk gambar 3 truk tumpang tindih -->
                    <div class="absolute top-0 right-0 w-full h-full bg-gray-100 rounded-3xl overflow-hidden flex items-center justify-center">
                        <img src="/img/slider/truck-slide3.png" class="w-full h-full object-contain transform scale-110" alt="Hino Trucks">
                    </div>

                    <!-- Sales Representative & Button (Absolute Positioned over trucks) -->
                    <div class="absolute -bottom-10 right-0 md:-right-10 flex flex-col items-end z-20">
                        <div class="flex items-center gap-4 mb-2">
                            <!-- Tombol WA Kapsul Hijau Gelap -->
                            <a href="https://wa.me/6281280061238" target="_blank" class="bg-[#0f3f26] hover:bg-hino-green text-white px-8 py-4 rounded-full shadow-2xl transition-colors transform hover:scale-105">
                                <span class="block text-sm font-medium opacity-90">Chat WhatsApp Sekarang</span>
                                <span class="block text-2xl font-bold tracking-wider">0812 8006 1238</span>
                            </a>
                            <!-- Placeholder Foto Sales Wanita -->
                            <div class="w-32 h-48 bg-gray-300 rounded-t-full rounded-b-lg border-4 border-white shadow-xl overflow-hidden flex items-end justify-center">
                                <span class="text-[10px] font-bold text-gray-500 mb-4">[Foto Sales]</span>
                            </div>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 bg-white/80 px-4 py-1 rounded-full backdrop-blur-sm mr-32">
                            Respon cepat &bull; Konsultasi gratis &bull; Info stok ter-update
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- PAGE 4: TESTIMONIALS -->
    <section class="py-24 bg-[#f4f7f5] relative overflow-hidden">
        <!-- Faded truck background watermark -->
        <div class="absolute -right-20 top-20 w-[600px] h-[600px] bg-gray-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: inherit;">Kepercayaan Pelanggan Adalah Prioritas Kami</h2>
                <p class="text-lg text-gray-600">Ratusan pelanggan telah mempercayakan kebutuhan armada dan servis HINO mereka bersama kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 relative border-t-4 border-hino-green">
                    <div class="absolute top-6 left-6 text-green-200">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
                    </div>
                    
                    <!-- Line art background -->
                    <div class="absolute right-4 top-1/2 opacity-10 text-gray-500">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </div>

                    <div class="flex items-center gap-4 mb-6 relative z-10 mt-6">
                        <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-md">
                            <!-- Placeholder -->
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Hasbie Affan RH</h4>
                            <p class="text-sm text-gray-600 flex items-center gap-1">PT Transport Corp <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></p>
                        </div>
                    </div>
                    <p class="text-gray-700 font-medium relative z-10">Luar biasa pelayanan sales-nya. Unit diterima dalam keadaan baik. Terima kasih Pak.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 relative border-t-4 border-hino-green transform md:-translate-y-4">
                    <div class="absolute top-6 left-6 text-green-200">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
                    </div>
                    
                    <div class="flex items-center gap-4 mb-6 relative z-10 mt-6">
                        <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-md"></div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">M G-Man</h4>
                            <p class="text-sm text-gray-600 flex items-center gap-1">PT. Bakti Gudang <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></p>
                        </div>
                    </div>
                    <p class="text-gray-700 font-medium relative z-10">Mantabbbbbb jiwa... Dan Alhamdulillah dapat kupon makan siang di kantin. Kantinnya juga rapi dan bersih.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 relative border-t-4 border-hino-green">
                    <div class="absolute top-6 left-6 text-green-200">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
                    </div>

                    <div class="flex items-center gap-4 mb-6 relative z-10 mt-6">
                        <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-md"></div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Syaiful Nizar</h4>
                            <p class="text-sm text-gray-600 flex items-center gap-1">CV Lestari <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></p>
                        </div>
                    </div>
                    <p class="text-gray-700 font-medium relative z-10">Servis truk HINO di sini mantap. Teknisi cepat dan benar-benar paham masalahnya, truk langsung beres. Tempat nyaman, harga bersahabat.</p>
                </div>
            </div>

            <!-- 4 Icons Bottom Row -->
            <div class="flex flex-wrap justify-center gap-12 mt-12 pt-12 border-t border-gray-200">
                <div class="flex items-center gap-3 text-gray-700 font-semibold">
                    <svg class="w-8 h-8 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Pelayanan Profesional
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-semibold">
                    <svg class="w-8 h-8 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Sales Responsif
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-semibold">
                    <svg class="w-8 h-8 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Unit Berkualitas
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-semibold">
                    <svg class="w-8 h-8 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Servis Terpercaya
                </div>
            </div>
        </div>
    </section>

    <!-- PAGE 5: FOOTER & CONTACT -->
    <section id="contact" class="bg-[#f0fdf4] relative pt-24 pb-0 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Kiri: Kontak -->
                <div class="pr-0 md:pr-12">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="font-family: inherit;">
                        Siap Menemukan<br> Unit HINO Terbaik<br> Untuk Bisnis Anda?
                    </h2>
                    <p class="text-xl text-gray-600 mb-10">Konsultasikan kebutuhan armada Anda bersama tim sales profesional kami.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.093 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">WhatsApp / Sales Contact</h5>
                                <p class="text-sm text-gray-600">0812 8006 1238</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">HINO Armindo Perkasa</h5>
                                <p class="text-sm text-gray-600">www.hinoarmindo.co.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Alamat Dealer</h5>
                                <p class="text-sm text-gray-600">Jl. Daan Mogot, Tangerang</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Email</h5>
                                <p class="text-sm text-gray-600">sales@hinoarmindo.co.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Jam Operasional</h5>
                                <p class="text-sm text-gray-600">09:00 AM - 17:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <a href="https://wa.me/6281280061238" class="inline-block bg-gradient-to-r from-[#006429] to-[#009b44] hover:from-[#009b44] hover:to-[#006429] text-white px-8 py-4 rounded-full font-bold shadow-lg shadow-green-500/30 transition-all mb-10 transform hover:scale-105">
                        Hubungi Sales Sekarang
                    </a>

                    <div class="grid grid-cols-2 gap-4 text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Dealer Resmi HINO
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Ready Unit
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pelayanan Profesional
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Servis & Sparepart
                        </div>
                    </div>
                </div>

                <!-- Kanan: Gambar Gedung Dealer -->
                <div class="relative flex items-end justify-center mt-12 lg:mt-0">
                    <div class="w-full h-full min-h-[400px] bg-gray-200 rounded-3xl overflow-hidden relative shadow-2xl flex items-center justify-center">
                        <img src="/img/slider/truck-slide3.png" class="w-full h-full object-cover">
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Copyright line -->
        <div class="border-t border-green-200/50 py-6 text-center text-gray-500 text-sm bg-white/50 backdrop-blur-sm relative z-10">
            &copy; {{ date('Y') }} Armindo Perkasa - Authorized HINO Dealer
        </div>
    </section>

    </main>

    ${tcoScript}

    @include('layouts.partials.footer')
@endsection
`;

fs.writeFileSync('c:\\xampp\\htdocs\\LaravelProject\\Sales\\WebSales\\resources\\views\\index.blade.php', newIndex);
console.log('Index updated using utf16le!');
