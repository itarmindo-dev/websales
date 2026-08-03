<style>
    /* 1. Kandang Utama */
    .spinner-wrapper {
        position: relative;
        width: 220px; 
        height: 220px;
        margin: 0 auto 30px auto; 
    }

    /* 2. Garis Lintasan (Rel statis putus-putus) */
    .spinner-wrapper .spinner-track {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 3px dashed #e0e0e0; 
        border-radius: 50%;
    }

    /* 3. Orbit Truk (Awalnya diem, nunggu komando JS) */
    .truck-orbit {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 20; 
        opacity: 0; /* Sembunyiin dulu truknya */
        transition: opacity 0.3s ease; /* Transisi halus pas truk muncul */
    }

    /* Class ini bakal disuntik JS buat nyalain mesin truk */
    .truck-orbit.start-engine {
        opacity: 1;
        animation: spin-truck 2s linear infinite; 
    }

    /* 4. Ikon Truk (Di ujung atas) */
    .truck-orbit img {
        position: absolute;
        top: -15px; 
        left: 50%;
        transform: translateX(-50%); 
        width: 40px; 
        height: auto;
    }

    /* 5. Pembungkus Logo - Awalnya bener-bener ngumpet */
    .logo-hino-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0; 
        transform: scale(0.8); /* Agak dikecilin dikit buat efek nge-zoom */
    }

    /* Class ini bakal disuntik JS buat ngasih efek Fade-in */
    .logo-hino-container.is-ready {
        animation: fadeInLogo 0.6s ease-out forwards; 
    }

    /* 6. Logo Hino */
    .logo-hino-container img {
        width: 150px; 
        height: auto;
    }

    /* --- KEYFRAMES (Dapur Animasinya) --- */
    
    /* Putaran Truk */
    @keyframes spin-truck {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Efek Logo Muncul */
    @keyframes fadeInLogo {
        0% { opacity: 0; transform: scale(0.8); }
        100% { opacity: 1; transform: scale(1); }
    }
</style>

<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
            
            <div class="spinner-wrapper">
                <div class="spinner-track"></div>

                <div class="truck-orbit" id="truckOrbit">
                    <img src="{{ asset('img/icon/truck-16.png') }}" alt="Truk Loading">
                </div>

                <div class="logo-hino-container" id="logoContainer">
                    <img src="{{ asset('img/icon/logohino2.png') }}" id="hinoLogo" alt="Logo Hino">
                </div>
            </div>
            
            <div class="txt-loading">
                <span data-text-preloader="H" class="letters-loading">H</span>
                <span data-text-preloader="I" class="letters-loading">I</span>
                <span data-text-preloader="N" class="letters-loading">N</span>
                <span data-text-preloader="O" class="letters-loading">O</span>
            </div>
        </div>
        
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left"><div class="bg"></div></div>
                <div class="col-3 loader-section section-left"><div class="bg"></div></div>
                <div class="col-3 loader-section section-right"><div class="bg"></div></div>
                <div class="col-3 loader-section section-right"><div class="bg"></div></div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen-elemen yang mau diatur
        var logoImg = document.getElementById('hinoLogo');
        var logoContainer = document.getElementById('logoContainer');
        var truckOrbit = document.getElementById('truckOrbit');

        // Fungsi buat nge-gas animasi
        function triggerAnimations() {
            // 1. Muncilin logo HINO secara elegan
            logoContainer.classList.add('is-ready');
            
            // 2. Kasih jeda 0.4 detik, baru truknya muncul & jalan muter
            setTimeout(function() {
                truckOrbit.classList.add('start-engine');
            }, 400); 
        }

        // Cek kondisi gambarnya
        if (logoImg.complete) {
            // Kalau gambar udah ke-load dari cache (internet kenceng / udah pernah buka)
            triggerAnimations();
        } else {
            // Kalau gambar masih proses download (internet lagi lelet / baru pertama buka)
            logoImg.addEventListener('load', triggerAnimations);
        }
    });
</script>