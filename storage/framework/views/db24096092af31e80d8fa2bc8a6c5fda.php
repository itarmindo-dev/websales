<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.partials.header.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.partials.header.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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

                    <style>
                    /* Custom Styling untuk TCO Multi-Step Inline */
                    .tco-text-emerald { color: #059669; }
                    .tco-bg-emerald { background-color: #059669; }
                    
                    .tco-hero-title {
                        font-size: 2.2rem; font-weight: 800; line-height: 1.3;
                        color: #047857; margin-bottom: 15px;
                    }
                    
                    .tco-feature-icon {
                        width: 60px; height: 60px; border-radius: 50%;
                        background: #ecfdf5; display: flex; align-items: center; justify-content: center;
                        margin: 0 auto 10px; color: #059669; font-size: 24px;
                        border: 2px solid #a7f3d0; transition: all 0.3s ease;
                    }
                    .tco-feature-item:hover .tco-feature-icon {
                        background: #059669; color: #fff; transform: translateY(-5px);
                    }
                    .tco-promo-box {
                        background: #fff; border: 1px solid #a7f3d0; border-left: 5px solid #059669;
                        border-radius: 8px; padding: 15px 20px; box-shadow: 0 4px 6px rgba(5, 150, 105, 0.05);
                    }
                    .tco-glass-card {
                        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px);
                        border: 1px solid rgba(5, 150, 105, 0.2); border-radius: 20px;
                        padding: 30px; box-shadow: 0 20px 40px rgba(5, 150, 105, 0.08);
                        position: relative; min-height: 450px;
                    }
                    /* Step Progress Bar */
                    .tco-stepper {
                        display: flex; justify-content: space-between; margin-bottom: 25px; position: relative;
                    }
                    .tco-stepper::before {
                        content: ''; position: absolute; top: 50%; left: 0; width: 100%; height: 3px;
                        background: #e5e7eb; z-index: 1; transform: translateY(-50%);
                    }
                    .tco-step {
                        position: relative; z-index: 2; background: #fff; width: 35px; height: 35px;
                        border-radius: 50%; display: flex; align-items: center; justify-content: center;
                        font-weight: bold; border: 3px solid #e5e7eb; color: #9ca3af; transition: all 0.3s;
                    }
                    .tco-step.active { border-color: #059669; background: #059669; color: #fff; }
                    .tco-step.completed { border-color: #059669; background: #fff; color: #059669; }
                    /* Form Inputs */
                    .tco-input-group { margin-bottom: 15px; }
                    .tco-input-group label {
                        font-weight: 600; color: #374151; margin-bottom: 6px; display: block; font-size: 0.9rem;
                    }
                    .tco-input-group input, .tco-input-group select {
                        width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 8px;
                        background: #f9fafb; transition: border-color 0.3s; font-size: 0.95rem;
                    }
                    .tco-input-group input:focus, .tco-input-group select:focus {
                        outline: none; border-color: #059669; background: #fff; box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
                    }
                    /* Buttons */
                    .tco-btn {
                        padding: 12px 25px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;
                    }
                    .tco-btn-next { background: linear-gradient(135deg, #059669, #047857); color: white; width: 100%; box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2); }
                    .tco-btn-next:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(5, 150, 105, 0.3); color: white;}
                    .tco-btn-prev { background: #e5e7eb; color: #4b5563; }
                    .tco-btn-prev:hover { background: #d1d5db; }
                    
                    /* Step Container Visibility */
                    .tco-step-container { display: none; animation: fadeIn 0.4s ease-in-out; }
                    .tco-step-container.active { display: block; }
                    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                    /* Result UI (General Teaser) */
                    .tco-result-wrapper { display: none; animation: fadeIn 0.5s ease-in-out; }
                    .tco-res-total-box {
                        background: linear-gradient(135deg, #059669, #047857);
                        color: white; padding: 25px; border-radius: 12px; text-align: center; margin-bottom: 20px;
                        box-shadow: 0 10px 20px rgba(5,150,105,0.2);
                    }
                    .tco-res-total-box h2 { color: white; font-weight: 900; font-size: 2.2rem; margin: 10px 0; }
                    .tco-res-sub {
                        background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 15px; text-align: center;
                    }
                    /* Tombol Direct CS / WhatsApp */
                    .tco-btn-direct-cs {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                        color: #ffffff !important;
                        padding: 14px 28px;
                        border-radius: 50px;
                        font-weight: 700;
                        font-size: 0.95rem;
                        text-decoration: none;
                        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
                        transition: all 0.3s ease;
                        position: relative;
                        border: 2px solid transparent;
                        animation: pulseAttention 2s infinite;
                    }
                    .tco-btn-direct-cs:hover {
                        transform: translateY(-4px) scale(1.02);
                        box-shadow: 0 12px 25px rgba(5, 150, 105, 0.4);
                        border: 2px solid #a7f3d0;
                        animation: none;
                    }
                    .tco-btn-direct-cs .btn-icon {
                        background: rgba(255, 255, 255, 0.2);
                        border-radius: 50%;
                        width: 36px;
                        height: 36px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-left: 12px;
                        font-size: 1.2rem;
                        transition: transform 0.3s ease;
                    }
                    .tco-btn-direct-cs:hover .btn-icon {
                        transform: rotate(15deg) scale(1.1);
                    }
                    @keyframes pulseAttention {
                        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
                        70% { box-shadow: 0 0 0 15px rgba(16, 185, 129, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
                    }
                </style>


    <main id="vue-app" class="font-sans antialiased text-gray-800 bg-white selection:bg-green-500 selection:text-white">

    <!-- PAGE 1: HERO SECTION -->
    <section class="hero-bg-gradient pt-[110px] pb-10 overflow-hidden relative">
        <!-- Interactive Map for Desktop - Positioned as wide background element -->
        <div class="hidden lg:block absolute top-[80px] left-0 w-[90%] h-[280px] z-0 pointer-events-none">
            <java-interactive-map></java-interactive-map>
        </div>

        <div class="container relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                <!-- Kiri: Teks -->
                <div class="relative z-10 text-left flex flex-col items-start mt-[-40px] lg:mt-0">

                    <!-- Spacer untuk desktop agar teks turun di bawah map -->
                    <div class="hidden lg:block h-[200px]"></div>

                    <h2 class="text-hino-green font-bold tracking-wider text-sm md:text-base mb-2">DISTRIBUTOR RESMI HINO INDONESIA</h2>
                    <h1 class="text-4xl sm:text-5xl md:text-5xl font-black text-[#0f3f26] leading-tight mb-4 tracking-tight" style="font-family: inherit;">
                        ARMINDO PERKASA
                    </h1>
                    <p class="text-base sm:text-lg text-gray-600 mb-6 font-medium">
                        PERFORMA TANGGUH, MITRA BISNIS TERPERCAYA.<br class="hidden md:block"> JARINGAN LAYANAN NASIONAL.
                    </p>

                    <div class="flex flex-wrap justify-start gap-4 mb-8 w-full">
                        <a href="#contact" class="bg-hino-green hover:bg-hino-green-dark text-white px-8 py-4 rounded-full font-bold transition-all shadow-xl shadow-green-500/40 transform hover:-translate-y-1 text-sm sm:text-base text-center w-full sm:w-auto">
                            KONSULTASI UNIT
                        </a>
                        <a href="#models" class="bg-white border-2 border-[#0f3f26] text-[#0f3f26] hover:bg-[#0f3f26] hover:text-white px-8 py-4 rounded-full font-bold transition-all transform hover:-translate-y-1 text-sm sm:text-base text-center w-full sm:w-auto">
                            LIHAT PRODUK
                        </a>
                    </div>

                    <div class="flex flex-wrap justify-start items-center gap-6 sm:gap-8 text-sm font-semibold text-gray-600 w-full">
                        <div class="flex flex-col sm:flex-row items-start text-left gap-2 sm:gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-normal">TERAKREDITASI</span>
                                HINO MOTOR SALES
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start text-left gap-2 sm:gap-3">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-normal">PENGHARGAAN</span>
                                DEALER TERBAIK
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Vue Truck Showcase -->
                <div class="relative w-full h-[280px] lg:h-[500px] flex items-center justify-center overflow-visible">
                    <!-- Platform Bulat -->
                    <div class="absolute bottom-0 lg:bottom-10 w-[80%] h-[40px] lg:h-[60px] bg-black/20 rounded-[100%] blur-xl pointer-events-none"></div>
                    
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

        <div class="container relative z-10">
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
                        <div class="flex gap-2 shrink-0">
                            <!-- Merchandise Box -->
                            <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-200 flex flex-col items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path>
                                </svg>
                                <span class="text-[8px] font-bold text-gray-600 text-center leading-tight">Merchandise</span>
                            </div>
                            
                            <!-- Gift Card Box -->
                            <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-200 flex flex-col items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"></path>
                                </svg>
                                <span class="text-[8px] font-bold text-gray-600 text-center leading-tight">Gift Card</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol CS: Sejajar di kolom kiri, di bawah kotak promo -->
                    <div class="text-center mt-6">
                        <a href="https://api.whatsapp.com/send/?phone=6281280061238&text=Saya%20dari%20web%20ingin%20mendapatkan%20merchandise%20eksklusif%20HINO%20%26%20voucher%20operasional%20secara%20langsung%20tanpa%20mengisi%20TCO...%0A%0ANama:%0APerusahaan/Perorangan:%0AKebutuhan:%0A&type=phone_number&app_absent=0" target="_blank" class="tco-btn-direct-cs">
                            <span class="btn-text">Saya malas isi, mau langsung hubungi CS!</span>
                            <span class="btn-icon"><i class="fa-brands fa-whatsapp"></i></span>
                        </a>
                    </div>
                </div>

                <!-- Kalkulator Component -->
                <div class="glass-card rounded-2xl p-5 md:p-8 relative mt-10 lg:mt-0">
                    <!-- Judul form -->
                    <div class="d-flex align-items-center mb-4 pb-3" style="border-bottom: 1px solid #e5e7eb;">
                                <img src="<?php echo e(asset('img/logo/logohinopth.png')); ?>" alt="Logo Hino" style="height: 50px; width: auto; object-fit: contain; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.1));">
                                <span class="mx-3" style="width: 2px; height: 25px; background: #d1d5db;"></span>
                                <h4 class="m-0 tco-text-emerald" style="font-weight: 700; letter-spacing: 0.5px;">Kalkulator TCO</h4>
                     </div>


                    <div class="tco-stepper" id="tcoStepper">
                        <div class="tco-step active" id="stepIndicator1">1</div>
                        <div class="tco-step" id="stepIndicator2">2</div>
                        <div class="tco-step" id="stepIndicator3">3</div>
                    </div>

                                                <form id="tcoFullForm" onsubmit="return false;">
                                
                                <div class="tco-step-container active" id="step1">
                                    <h5 class="font-bold mb-3" style="color: #374151;">Data Operasional Dasar</h5>
                                    <div class="tco-input-group mb-3">
                                        <label>AVG KM Harian:</label>
                                        <input type="number" id="inp_km" placeholder="Contoh: 100" required>
                                    </div>
                                    <div class="tco-input-group mb-3">
                                        <label>Hari Operasional / Tahun:</label>
                                        <input type="number" id="inp_hari" placeholder="Contoh: 300" required>
                                    </div>
                                    <div class="tco-input-group mb-4">
                                        <label>Periode Kepemilikan (Tahun):</label>
                                        <select id="inp_periode" class="d-block" required>
                                            <option value="1">1 Tahun</option>
                                            <option value="2">2 Tahun</option>
                                            <option value="3">3 Tahun</option>
                                            <option value="4">4 Tahun</option>
                                            <option value="5" selected>5 Tahun</option>
                                        </select>
                                    </div>
                                    <button type="button" class="tco-btn tco-btn-next" onclick="nextStep(1)">Selanjutnya <i class="fa-solid fa-arrow-right ml-1"></i></button>
                                </div>
                                <div class="tco-step-container" id="step2">
                                    <h5 class="font-bold mb-3" style="color: #374151;">Spesifikasi Unit HINO</h5>
                                    <div class="tco-input-group">
                                        <label>Tipe Unit:</label>
                                        <select id="inp_tipe" class="d-block" required>
                                            <option value="">- Pilih Tipe -</option>
                                            <option value="115">Dutro 115 Series</option>
                                            <option value="136">Dutro 136 Series</option>
                                        </select>
                                    </div>
                                    <div class="tco-input-group">
                                        <label>Kategori Model:</label>
                                        <select id="inp_kategori" class="d-block" disabled required>
                                            <option value="">- Pilih Tipe Dulu -</option>
                                        </select>
                                    </div>
                                    <div class="tco-input-group mb-4">
                                        <label>Kondisi Jalan Dominan:</label>
                                        <select id="inp_kondisi" class="d-block" disabled required>
                                            <option value="1">Liku-liku / Perbukitan</option>
                                            <option value="2">Dalam Kota / Dataran Rendah</option>
                                            <option value="3">Pegunungan / Medan Terjal</option>
                                            <option value="4" selected>All Around (Kombinasi)</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <button type="button" class="tco-btn tco-btn-prev" onclick="prevStep(2)"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</button>
                                        <button type="button" class="tco-btn tco-btn-next" style="width: auto;" onclick="nextStep(2)">Selanjutnya <i class="fa-solid fa-arrow-right ml-1"></i></button>
                                    </div>
                                </div>
                                <div class="tco-step-container" id="step3">
                                    <h5 class="font-bold mb-3" style="color: #374151;">Data Finansial & Kontak</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="tco-input-group">
                                                <label>Harga Unit + Pajak (Rp):</label>
                                                <input type="number" id="inp_hrg_unit" placeholder="Cth: 450000000">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="tco-input-group">
                                                <label>Harga Karoseri (Rp):</label>
                                                <input type="number" id="inp_hrg_karoseri" placeholder="Cth: 90000000">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="tco-input-group">
                                                <label>Bunga Flat (%):</label>
                                                <input type="number" id="inp_bunga" step="0.01" placeholder="Cth: 7.5">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="tco-input-group">
                                                <label>Durasi Kredit/Bunga:</label>
                                                <select id="inp_durasi_bunga" class="d-block">
                                                    <option value="0">Cash (0 Tahun)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="tco-input-group">
                                                <label>Harga Solar:</label>
                                                <input type="number" id="inp_hrg_solar" value="6800">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="tco-input-group">
                                                <label>Harga 1 Set Ban (Rp):</label>
                                                <input type="number" id="inp_hrg_ban" value="" placeholder="Cth: 14000000">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="tco-input-group">
                                                <label>Umur Ban (KM):</label>
                                                <input type="number" id="inp_umur_ban" value="" placeholder="Cth: 40000">
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border-top: 1px dashed #d1d5db; margin: 10px 0 15px;">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="tco-input-group mb-4">
                                                <label class="text-danger" style="font-weight: 700;">Nama (Wajib):</label>
                                                <input type="text" id="inp_nama" placeholder="Masukkan Nama" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="tco-input-group mb-4">
                                                <label class="text-danger" style="font-weight: 700;">No. WA (Wajib):</label>
                                                <input type="tel" id="inp_wa" placeholder="0812xxxxxx" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <button type="button" class="tco-btn tco-btn-prev" onclick="prevStep(3)"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali</button>
                                        <button type="button" class="tco-btn tco-btn-next" style="width: auto;" id="btnHitungTcoFull">HITUNG TCO FINAL</button>
                                    </div>
                                </div>
                            </form>

                            
                            <div class="tco-result-wrapper" id="tcoResult">
                                <!-- Thank You Message -->
                                <div class="text-center mb-4">
                                    <div style="width: 70px; height: 70px; margin: 0 auto 15px; background: linear-gradient(135deg, #009b44, #00c853); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,155,68,0.3);">
                                        <svg style="width: 36px; height: 36px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-[#0f3f26] mb-1" style="font-size: 1.4rem;">Terima Kasih!</h3>
                                    <h4 class="font-bold text-dark" style="font-size: 1.05rem;">Kalkulasi Berhasil, <span id="res_nama_user" class="tco-text-emerald"></span>!</h4>
                                    <p style="font-size: 1rem; color: #009b44; font-weight: 600; margin-top: 8px;">Sales Kami Akan Menghubungi Anda</p>
                                </div>

                                <div class="tco-res-total-box">
                                    <span style="font-size: 0.95rem; font-weight: 600;">ESTIMASI BIAYA KEPEMILIKAN PER KM</span>
                                    <h2 id="res_tco_km_utama">Rp 0</h2>
                                </div>


                                <!-- Email Status -->
                                <div id="emailStatus" class="p-3 mb-3" style="background:#e0f2fe; border: 1px solid #7dd3fc; border-radius:8px; font-size: 0.85rem; color: #0369a1; line-height: 1.5; text-align: center;">
                                    <i class="fa-solid fa-spinner fa-spin mr-1"></i> Mengirim laporan detail ke email...
                                </div>

                                <div class="p-3" style="background:#fff3cd; border: 1px solid #ffeeba; border-radius:8px; font-size: 0.85rem; color: #856404; line-height: 1.5;">
                                    <i class="fa-solid fa-info-circle mr-1"></i> <b>Penting:</b> Angka di atas adalah ringkasan general. Rincian komplit yang mencakup perhitungan <b>Penyusutan Nilai Aset (Depresiasi)</b>, <b>Beban Bunga</b>, dan <b>Biaya Servis Tahunan</b> telah kami <i>generate</i> dalam bentuk PDF.
                                    <br><br>
                                    Tim Sales kami akan segera mengirimkan <b>Dokumen Laporan PDF Lengkap</b> ke nomor WhatsApp Anda.
                                </div>
                                <div class="text-center mt-4">
                                    <button class="tco-btn tco-btn-prev w-100" onclick="location.reload()">Hitung Simulasi Baru</button>
                                </div>
                            </div>

                </div>

            </div>
        </div>
    </section>

    <!-- PAGE 3: READY UNIT -->
    <section id="models" class="py-24 bg-white relative">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="relative">
                    <p class="text-xl text-gray-600 mb-2">Truk HINO Impian Anda Sudah Tersedia</p>
                    <h2 class="text-5xl md:text-7xl font-black text-[#0f3f26] mb-2" style="font-family: inherit;">READY UNIT</h2>
                    <h2 class="text-4xl md:text-6xl font-bold text-gray-900 mb-8" style="font-family: inherit;">Siap Kirim!</h2>
                    
                    <p class="text-xl text-gray-600 mb-12 leading-relaxed">
                        Unit terbatas dengan perputaran sangat cepat. Dapatkan informasi stok terbaru, promo unit, dan konsultasi langsung dengan sales resmi kami hari ini.
                    </p>
                    
                    <p class="text-sm text-gray-500 mb-8">Ketersediaan unit dapat berubah sewaktu-waktu.</p>
                </div>

                <div class="relative h-[400px] md:h-[500px]">
                    <!-- Placeholder untuk gambar 3 truk tumpang tindih -->
                    <div class="absolute top-0 right-0 w-full h-full overflow-hidden flex items-center justify-center">
                        <img src="/img/shape/bus-3.png" class="w-full h-full object-contain transform scale-110" alt="Hino Trucks">
                    </div>

                    <!-- Sales Representative & Button -->
                    <div class="absolute -bottom-10 md:bottom-4 left-0 w-full flex flex-col items-center z-20 px-4">
                        <a href="https://wa.me/6281280061238" target="_blank" class="bg-[#0f3f26] hover:bg-hino-green text-white w-[95%] md:w-auto md:min-w-[360px] px-8 py-2.5 md:py-3 rounded-full shadow-[0_10px_25px_-5px_rgba(15,63,38,0.5)] transition-all transform hover:scale-105 hover:-translate-y-1 text-center mb-2 border border-white/20">
                            <span class="block text-xs md:text-sm font-semibold text-[#8bf6b2] tracking-widest uppercase mb-0.5">Chat WhatsApp Sekarang</span>
                            <span class="block text-xl md:text-2xl font-extrabold tracking-widest">0812 8006 1238</span>
                        </a>
                        <p class="text-[11px] md:text-sm font-bold text-gray-700 bg-white/90 md:bg-transparent px-4 py-1.5 md:p-0 rounded-full text-center shadow-sm md:shadow-none">
                            <i class="fa-solid fa-bolt text-yellow-500 mr-1"></i> Respon Cepat &bull; Konsultasi Gratis
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- PAGE 4: TESTIMONIALS -->
    <section class="py-32 md:py-24 bg-[#f4f7f5] relative overflow-hidden">
        <!-- Faded truck background watermark -->
        <div class="absolute -right-20 top-20 w-[600px] h-[600px] bg-gray-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container relative z-10">
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
    <section id="contact" class="bg-[#f3f4f6] lg:bg-[#f0fdf4] relative pt-24 pb-0 lg:pb-24 overflow-hidden">
        <!-- Background Image for Mobile (Transparent/Watermark) -->
        <div class="absolute inset-0 z-0 lg:hidden pointer-events-none">
            <img src="/img/shape/armindo1.png" alt="Dealer Armindo Mobile" class="w-full h-full object-cover" style="opacity: 0.15;">
        </div>
        
        <!-- Armindo Background Image (Desktop: fade left, positioned right) -->
        <div class="hidden lg:block absolute top-0 right-0 w-[55%] h-full z-0 pointer-events-none">
            <div class="w-full h-full bg-cover bg-center bg-no-repeat" style="background-image: url('/img/shape/armindo1.png'); -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,0.7) 20%, rgba(0,0,0,0.3) 50%, transparent 85%); mask-image: linear-gradient(to left, rgba(0,0,0,0.7) 20%, rgba(0,0,0,0.3) 50%, transparent 85%);"></div>
        </div>
        <div class="container relative z-10 pb-16 lg:pb-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Kiri: Kontak -->
                <div class="pr-0 md:pr-12 text-center sm:text-left flex flex-col items-center sm:items-start">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="font-family: inherit;">
                        Siap Menemukan<br> Unit HINO Terbaik<br> Untuk Bisnis Anda?
                    </h2>
                    <p class="text-xl text-gray-600 mb-10">Konsultasikan kebutuhan armada Anda bersama tim sales profesional kami.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10 w-full">
                        <div class="flex items-start gap-4 text-left">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.093 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">WhatsApp / Sales</h5>
                                <p class="text-sm text-gray-600">0812 8006 1238</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 text-left">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">HINO Armindo</h5>
                                <p class="text-sm text-gray-600">www.hinoarmindo.co.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 text-left">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Alamat Dealer</h5>
                                <p class="text-sm text-gray-600">Jl. Daan Mogot, Tangerang</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 text-left">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-hino-green flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Email</h5>
                                <p class="text-sm text-gray-600">sales@hinoarmindo.co.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 text-left">
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
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <svg class="w-5 h-5 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pelayanan Profesional
                        </div>
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <svg class="w-5 h-5 text-hino-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Servis & Sparepart
                        </div>
                    </div>
                </div>


            </div>
        </div>
        
        <!-- Copyright line -->
        <div class="border-t border-green-200/50 py-6 text-center text-gray-500 text-sm bg-white/50 backdrop-blur-sm relative z-10">
            &copy; <?php echo e(date('Y')); ?> Armindo Perkasa - Authorized HINO Dealer
        </div>
    </section>

    </main>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const bbmData = {
                            '115': {
                                'Dutro 115 HD STD':  { '1': 4.09, '2': 6.99, '3': 5.95, '4': 5.53 },
                                'Dutro 115 LD STD':  { '1': 5.03, '2': 5.09, '3': 6.15, '4': 5.77 },
                                'Dutro 115 SD STD':  { '1': 6.05, '2': 12.74, '3': 9.56, '4': 8.11 },
                                'Dutro 115 SDL STD': { '1': 4.74, '2': 8.40,  '3': 6.83, '4': 5.71 },
                                'Dutro 115 SDR STD': { '1': 6.34, '2': 10.25, '3': 9.10, '4': 7.96 }
                            },
                            '136': {
                                'Dutro 136 HD 64':   { '1': 3.55, '2': 9.27,  '3': 6.40, '4': 4.36 },
                                'Dutro 136 HDL 64':  { '1': 8.81, '2': 10.77, '3': 3.67, '4': 7.44 },
                                'Dutro 136 HDX':     { '1': 4.55, '2': 7.01,  '3': 7.12, '4': 6.15 },
                                'Dutro 136 HDX PTO': { '1': 4.55, '2': 7.01,  '3': 7.12, '4': 6.15 },
                                'Dutro 136 MDL':     { '1': 5.01, '2': 8.91,  '3': 8.10, '4': 7.27 }
                            }
                        };
                        const HARGA_SERVIS_TAHUN_1 = 7271111;
                        window.nextStep = function(current) {
                            if (current === 1) {
                                if (!document.getElementById('inp_km').value || !document.getElementById('inp_hari').value) {
                                    alert("Mohon isi Jarak Tempuh KM dan Hari Operasi!"); return;
                                }
                                let per = parseInt(document.getElementById('inp_periode').value);
                                let selDurasi = document.getElementById('inp_durasi_bunga');
                                selDurasi.innerHTML = '<option value="0">Cash (0 Tahun)</option>';
                                for(let i=1; i<=per; i++) {
                                    selDurasi.innerHTML += `<option value="${i}">${i} Tahun</option>`;
                                }
                            }
                            if (current === 2) {
                                if (!document.getElementById('inp_tipe').value || !document.getElementById('inp_kategori').value) {
                                    alert("Mohon lengkapi Spesifikasi Unit Hino Anda!"); return;
                                }
                            }
                            document.getElementById('step' + current).classList.remove('active');
                            document.getElementById('stepIndicator' + current).classList.add('completed');
                            document.getElementById('stepIndicator' + current).classList.remove('active');
                            
                            let next = current + 1;
                            document.getElementById('step' + next).classList.add('active');
                            document.getElementById('stepIndicator' + next).classList.add('active');
                        }
                        window.prevStep = function(current) {
                            document.getElementById('step' + current).classList.remove('active');
                            document.getElementById('stepIndicator' + current).classList.remove('active');
                            
                            let prev = current - 1;
                            document.getElementById('step' + prev).classList.add('active');
                            document.getElementById('stepIndicator' + prev).classList.remove('completed');
                            document.getElementById('stepIndicator' + prev).classList.add('active');
                        }
                        document.getElementById('inp_tipe').addEventListener('change', function() {
                            const tipe = this.value;
                            const elKat = document.getElementById('inp_kategori');
                            const elKon = document.getElementById('inp_kondisi');
                            elKat.innerHTML = '<option value="">- Pilih Kategori -</option>';
                            
                            if(tipe && bbmData[tipe]) {
                                Object.keys(bbmData[tipe]).forEach(k => {
                                    elKat.innerHTML += `<option value="${k}">${k}</option>`;
                                });
                                elKat.disabled = false;
                            } else {
                                elKat.disabled = true; elKon.disabled = true;
                            }
                        });
                        document.getElementById('inp_kategori').addEventListener('change', function() {
                            const elKon = document.getElementById('inp_kondisi');
                            if(this.value) { elKon.disabled = false; elKon.value = '4'; } else { elKon.disabled = true; }
                        });
                        document.getElementById('btnHitungTcoFull').addEventListener('click', function() {
                            const nama = document.getElementById('inp_nama').value.trim();
                            const wa = document.getElementById('inp_wa').value.trim();
                            if (!nama || !wa) {
                                alert("PERHATIAN: Nama dan No. WhatsApp WAJIB diisi untuk melihat hasil kalkulasi.");
                                document.getElementById('inp_nama').focus();
                                return;
                            }
                            const hrg_unit = parseFloat(document.getElementById('inp_hrg_unit').value) || 0;
                            if (hrg_unit <= 0) { alert("Harga Unit wajib diisi untuk menghitung CAPEX!"); document.getElementById('inp_hrg_unit').focus(); return; }
                            const km_hari = parseFloat(document.getElementById('inp_km').value);
                            const hari_ops = parseFloat(document.getElementById('inp_hari').value);
                            const periode = parseFloat(document.getElementById('inp_periode').value);
                            
                            const tipe = document.getElementById('inp_tipe').value;
                            const kategori = document.getElementById('inp_kategori').value;
                            const kondisi = document.getElementById('inp_kondisi').value;
                            const konsumsiBBM = bbmData[tipe][kategori][kondisi];
                            const hrg_karoseri = parseFloat(document.getElementById('inp_hrg_karoseri').value) || 0;
                            const bunga = parseFloat(document.getElementById('inp_bunga').value) || 0;
                            const dur_bunga = parseFloat(document.getElementById('inp_durasi_bunga').value) || 0;
                            
                            const hrg_solar = parseFloat(document.getElementById('inp_hrg_solar').value) || 0;
                            if (hrg_solar <= 0) { alert("Harga Solar wajib diisi!"); document.getElementById('inp_hrg_solar').focus(); return; }
                            
                            const hrg_ban = parseFloat(document.getElementById('inp_hrg_ban').value) || 0;
                            if (hrg_ban <= 0) { alert("Harga 1 Set Ban wajib diisi!"); document.getElementById('inp_hrg_ban').focus(); return; }
                            
                            const umur_ban = parseFloat(document.getElementById('inp_umur_ban').value) || 0;
                            if (umur_ban <= 0) { alert("Umur Ban (KM) wajib diisi!"); document.getElementById('inp_umur_ban').focus(); return; }
                            const total_km = km_hari * hari_ops * periode;
                            
                            const harga_pokok = hrg_unit + hrg_karoseri;
                            const total_bunga = harga_pokok * (bunga / 100) * dur_bunga;
                            const total_akuisisi = harga_pokok + total_bunga;
                            const total_liter = Math.ceil(total_km / konsumsiBBM);
                            const total_biaya_solar = total_liter * hrg_solar;
                            
                            const jml_ban = (umur_ban > 0) ? (total_km / umur_ban) : 0;
                            const total_biaya_ban = (Math.round(jml_ban * 100) / 100) * hrg_ban;
                            
                            let total_biaya_servis = 0;
                            let biaya_srv_berjalan = HARGA_SERVIS_TAHUN_1;
                            for(let thn=1; thn<=periode; thn++) {
                                if(thn > 1) biaya_srv_berjalan = Math.round(biaya_srv_berjalan * 1.15);
                                total_biaya_servis += biaya_srv_berjalan;
                            }
                            const total_opex = total_biaya_solar + total_biaya_ban + total_biaya_servis;
                            let hjk = harga_pokok;
                            for(let thn=1; thn<=periode; thn++) {
                                let depr_rate = (thn === 1) ? 0.15 : 0.10;
                                hjk = hjk * (1 - depr_rate);
                            }
                            const tco_final = (total_akuisisi + total_opex) - hjk;
                            const tco_per_bln = Math.floor(tco_final / (periode * 12));
                            const tco_per_km = (total_km > 0) ? Math.floor(tco_final / total_km) : 0;
                            const fmtRp = (n) => 'Rp ' + Math.round(n).toLocaleString('id-ID');

                            // Update UI
                            document.getElementById('res_nama_user').innerText = nama;
                            document.getElementById('res_tco_km_utama').innerText = fmtRp(tco_per_km);
                            
                            document.getElementById('tcoFullForm').style.display = 'none';
                            document.getElementById('tcoStepper').style.display = 'none';
                            
                            const resWrapper = document.getElementById('tcoResult');
                            resWrapper.style.display = 'block';

                            // Kondisi jalan label mapping
                            const kondisiLabels = {'1': 'Liku-liku / Perbukitan', '2': 'Dalam Kota / Dataran Rendah', '3': 'Pegunungan / Medan Terjal', '4': 'All Around (Kombinasi)'};

                            // AJAX: Kirim data ke backend untuk generate PDF & email
                            const emailStatus = document.getElementById('emailStatus');
                            fetch('/tco/submit', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    nama: nama,
                                    no_wa: wa,
                                    avg_km_harian: km_hari,
                                    hari_operasi: hari_ops,
                                    periode_tco: periode,
                                    konsumsi_bbm: konsumsiBBM,
                                    harga_unit: hrg_unit,
                                    harga_karoseri: hrg_karoseri,
                                    bunga_flat: bunga,
                                    durasi_bunga: dur_bunga,
                                    harga_solar: hrg_solar,
                                    harga_ban: hrg_ban,
                                    umur_ban: umur_ban,
                                    tipe_unit: tipe,
                                    kategori_model: kategori,
                                    kondisi_jalan: kondisiLabels[kondisi] || kondisi,
                                }),
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    emailStatus.style.background = '#d1fae5';
                                    emailStatus.style.borderColor = '#6ee7b7';
                                    emailStatus.style.color = '#065f46';
                                    emailStatus.innerHTML = '<i class="fa-solid fa-check-circle mr-1"></i> Laporan Berhasil dibuat. Tim Kami Akan Menghubungi Anda. Terima Kasih ';
                                } else {
                                    emailStatus.style.background = '#fee2e2';
                                    emailStatus.style.borderColor = '#fca5a5';
                                    emailStatus.style.color = '#991b1b';
                                    emailStatus.innerHTML = '<i class="fa-solid fa-exclamation-circle mr-1"></i> ' + (data.message || 'Gagal mengirim email.');
                                }
                            })
                            .catch(err => {
                                emailStatus.style.background = '#fee2e2';
                                emailStatus.style.borderColor = '#fca5a5';
                                emailStatus.style.color = '#991b1b';
                                emailStatus.innerHTML = '<i class="fa-solid fa-exclamation-circle mr-1"></i> Gagal mengirim email. Silakan hubungi kami langsung.';
                                console.error('TCO Email Error:', err);
                            });
                        });
                    });
                </script>

                <!-- Frontend Security Scripts -->
                <script>
                    // Mencegah Klik Kanan (Context Menu)
                    document.addEventListener('contextmenu', event => event.preventDefault());

                    // Mencegah Shortcut Keyboard (F12, Inspect Element, View Source, Save Page)
                    document.onkeydown = function (e) {
                        // Mencegah F12
                        if (e.keyCode == 123) return false;
                        
                        // Mencegah Ctrl+Shift+I / Ctrl+Shift+C / Ctrl+Shift+J (Inspect Element)
                        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'i'.charCodeAt(0))) return false;
                        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'C'.charCodeAt(0) || e.keyCode == 'c'.charCodeAt(0))) return false;
                        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'J'.charCodeAt(0) || e.keyCode == 'j'.charCodeAt(0))) return false;
                        
                        // Mencegah Ctrl+U (View Source) dan Ctrl+S (Save Page)
                        if (e.ctrlKey && (e.keyCode == 'U'.charCodeAt(0) || e.keyCode == 'u'.charCodeAt(0))) return false;
                        if (e.ctrlKey && (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 's'.charCodeAt(0))) return false;
                    }
                </script>
            </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', ['title' => '01'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/index.blade.php ENDPATH**/ ?>