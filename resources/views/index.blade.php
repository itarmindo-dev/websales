@extends('layouts.marketing')

@section('title', 'Armindo Perkasa - Dealer Resmi HINO')

@section('content')
<a class="skip-link" href="#main-content">Lewati ke konten utama</a>

<div x-data="{ menuOpen: false }" @keydown.escape.window="menuOpen = false">
    <header class="site-header">
        <nav class="site-nav" aria-label="Navigasi utama">
            <a href="#home" class="brand-hino" aria-label="Armindo Perkasa - Beranda">
                <img src="{{ asset('img/logo/logohinopth.png') }}" alt="HINO">
            </a>

            <div class="desktop-nav">
                <a href="#home" class="is-active">Beranda</a>
                <a href="#models">Model Truk</a>
                <a href="#tco">Kalkulator TCO</a>
                <a href="#testimonials">Testimoni</a>
                <a href="#contact">Tentang Kami</a>
            </div>

            <div class="nav-actions">
                <img class="brand-armindo" src="{{ asset('img/logo/logoap1.png') }}" alt="PT Armindo Perkasa">
                <a class="button button-primary nav-cta" href="https://wa.me/6281280061238?text=Halo%20Armindo%20Perkasa,%20saya%20ingin%20konsultasi%20unit%20HINO." target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    Hubungi Sales
                </a>
                <button class="menu-toggle" type="button" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen.toString()" aria-controls="mobile-navigation">
                    <span class="sr-only">Buka menu navigasi</span>
                    <i class="fa-solid" :class="menuOpen ? 'fa-xmark' : 'fa-bars'" aria-hidden="true"></i>
                </button>
            </div>
        </nav>

        <div id="mobile-navigation" class="mobile-nav" x-cloak x-show="menuOpen" x-transition.opacity @click.outside="menuOpen = false">
            <a href="#home" @click="menuOpen = false">Beranda</a>
            <a href="#models" @click="menuOpen = false">Model Truk</a>
            <a href="#tco" @click="menuOpen = false">Kalkulator TCO</a>
            <a href="#testimonials" @click="menuOpen = false">Testimoni</a>
            <a href="#contact" @click="menuOpen = false">Tentang Kami</a>
            <a href="https://wa.me/6281280061238?text=Halo%20Armindo%20Perkasa,%20saya%20ingin%20konsultasi%20unit%20HINO." target="_blank" rel="noopener noreferrer">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Hubungi Sales
            </a>
        </div>
    </header>

    <main id="main-content">
        <section id="home" class="hero-section" aria-labelledby="hero-title">
            <div class="section-container hero-inner">
                <img class="hero-map" src="{{ asset('img/shape/map-4.png') }}" alt="Jaringan Armindo Perkasa di Tangerang, Ciputat, Ciawi, dan Cirebon">
                <img class="hero-truck" src="{{ asset('img/slider/truck-slide4.png') }}" alt="HINO 500 dump truck berwarna hijau">

                <div class="hero-copy">
                    <p class="eyebrow">Distributor resmi HINO Indonesia</p>
                    <h1 id="hero-title">Armindo Perkasa</h1>
                    <p class="hero-lead">Performa tangguh, mitra bisnis terpercaya.<br>Jaringan layanan nasional.</p>

                    <div class="hero-actions">
                        <a class="button button-primary" href="https://wa.me/6281280061238?text=Halo%20Armindo%20Perkasa,%20saya%20ingin%20konsultasi%20unit%20HINO." target="_blank" rel="noopener noreferrer">Konsultasi Unit</a>
                        <a class="button button-outline" href="#models">Lihat Produk</a>
                    </div>

                    <div class="hero-credentials" aria-label="Kredensial dealer">
                        <div class="credential-item">
                            <i class="fa-solid fa-shield-check" aria-hidden="true"></i>
                            <span><small>Terakreditasi</small>HINO Motor Sales Indonesia</span>
                        </div>
                        <div class="credential-item">
                            <i class="fa-solid fa-trophy" aria-hidden="true"></i>
                            <span><small>Penghargaan</small>Dealer Terbaik</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tco" class="tco-section" aria-labelledby="tco-title">
            <div class="section-container tco-grid">
                <div class="tco-intro">
                    <p class="section-kicker">Perencanaan armada</p>
                    <h2 id="tco-title">Cari Tahu Estimasi Biaya Operasional Armada <span>HINO Anda</span></h2>
                    <p class="section-lead">Investasi armada yang cerdas dimulai dari perhitungan yang tepat.</p>
                    <p class="section-description">Dapatkan proyeksi biaya bahan bakar, perawatan berkala, pengeluaran operasional, dan total biaya kepemilikan sebelum berinvestasi pada unit HINO baru.</p>

                    <div class="benefit-list" aria-label="Manfaat kalkulator TCO">
                        <div class="benefit-item">
                            <i class="fa-solid fa-chart-column" aria-hidden="true"></i>
                            <span>Simulasi biaya operasional</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fa-solid fa-gas-pump" aria-hidden="true"></i>
                            <span>Estimasi efisiensi bahan bakar</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                            <span>Proyeksi biaya perawatan</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fa-solid fa-coins" aria-hidden="true"></i>
                            <span>Analisis investasi armada</span>
                        </div>
                    </div>

                    <div class="promo-note">
                        <i class="fa-solid fa-gift" aria-hidden="true"></i>
                        <p>Kesempatan mendapatkan <strong>merchandise eksklusif HINO</strong> dan voucher operasional bagi pelanggan terpilih.</p>
                    </div>

                    <a class="text-link" href="https://wa.me/6281280061238?text=Halo%20Armindo%20Perkasa,%20saya%20ingin%20langsung%20konsultasi%20dengan%20sales." target="_blank" rel="noopener noreferrer">
                        Langsung hubungi sales <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    </a>
                </div>

                <div id="tco-calculator-app" class="tco-app-shell" aria-live="polite"></div>
            </div>
        </section>

        <section id="models" class="ready-section" aria-labelledby="ready-title">
            <div class="section-container ready-grid">
                <div class="ready-copy">
                    <p class="section-kicker">Truk HINO impian Anda sudah tersedia</p>
                    <h2 id="ready-title"><span>Ready Unit</span><br>- Siap Kirim!</h2>
                    <p>Unit terbatas dengan perputaran cepat. Dapatkan informasi stok terbaru, promo unit, dan konsultasi langsung dengan sales resmi kami hari ini.</p>
                    <small>Ketersediaan unit dapat berubah sewaktu-waktu.</small>
                </div>

                <div class="ready-visual">
                    <img src="{{ asset('img/shape/bus-3.png') }}" alt="Lineup kendaraan HINO siap kirim">
                    <a class="ready-contact" href="https://wa.me/6281280061238?text=Halo%20Armindo%20Perkasa,%20saya%20ingin%20menanyakan%20stok%20unit%20HINO." target="_blank" rel="noopener noreferrer">
                        <span>Chat WhatsApp Sekarang</span>
                        <strong>0812 8006 1238</strong>
                        <small><i class="fa-solid fa-bolt" aria-hidden="true"></i> Respon cepat · Konsultasi gratis</small>
                    </a>
                </div>
            </div>
        </section>

        <section id="testimonials" class="testimonial-section" aria-labelledby="testimonial-title">
            <img class="testimonial-watermark" src="{{ asset('img/slider/truck-slide5.png') }}" alt="" aria-hidden="true">
            <div class="section-container testimonial-inner">
                <div class="section-heading">
                    <h2 id="testimonial-title">Kepercayaan Pelanggan Adalah Prioritas Kami</h2>
                    <p>Pengalaman pelanggan menjadi dasar kami untuk terus memberi layanan penjualan dan purna jual yang lebih baik.</p>
                </div>

                <div class="testimonial-grid">
                    <article class="testimonial-card">
                        <i class="fa-solid fa-quote-left quote-icon" aria-hidden="true"></i>
                        <div class="customer-info">
                            <img src="{{ asset('img/testimonial/ca-testimonial-ier1.1.png') }}" alt="Foto Hasbie Affan RH">
                            <div><h3>Hasbie Affan RH</h3><p>PT Transport Corp <i class="fa-solid fa-circle-check" aria-label="Pelanggan terverifikasi"></i></p></div>
                        </div>
                        <blockquote>Pelayanan sales responsif dan jelas. Unit diterima dalam keadaan baik, proses serah terima juga rapi.</blockquote>
                    </article>

                    <article class="testimonial-card">
                        <i class="fa-solid fa-quote-left quote-icon" aria-hidden="true"></i>
                        <div class="customer-info">
                            <img src="{{ asset('img/testimonial/ca-testimonial-ier1.2.png') }}" alt="Foto M G-Man">
                            <div><h3>M G-Man</h3><p>PT Bakti Gudang <i class="fa-solid fa-circle-check" aria-label="Pelanggan terverifikasi"></i></p></div>
                        </div>
                        <blockquote>Konsultasinya membantu memilih unit sesuai muatan dan rute. Informasi biaya dijelaskan sejak awal.</blockquote>
                    </article>

                    <article class="testimonial-card">
                        <i class="fa-solid fa-quote-left quote-icon" aria-hidden="true"></i>
                        <div class="customer-info">
                            <img src="{{ asset('img/testimonial/ca-testi3.2.png') }}" alt="Foto Syaiful Nizar">
                            <div><h3>Syaiful Nizar</h3><p>CV Lestari <i class="fa-solid fa-circle-check" aria-label="Pelanggan terverifikasi"></i></p></div>
                        </div>
                        <blockquote>Teknisi memahami kebutuhan armada kami. Servis terjadwal, pengerjaan cepat, dan truk kembali beroperasi.</blockquote>
                    </article>
                </div>

                <div class="service-promises" aria-label="Komitmen layanan">
                    <span><i class="fa-solid fa-handshake" aria-hidden="true"></i> Pelayanan Profesional</span>
                    <span><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> Sales Responsif</span>
                    <span><i class="fa-solid fa-truck" aria-hidden="true"></i> Unit Berkualitas</span>
                    <span><i class="fa-solid fa-user-gear" aria-hidden="true"></i> Servis Terpercaya</span>
                </div>
            </div>
        </section>

        <section id="contact" class="contact-section" aria-labelledby="contact-title">
            <div class="section-container contact-grid">
                <div class="contact-copy">
                    <p class="section-kicker">Dealer resmi HINO</p>
                    <h2 id="contact-title">Siap Menemukan Unit HINO Terbaik Untuk Bisnis Anda?</h2>
                    <p>Konsultasikan kebutuhan armada Anda bersama tim sales profesional kami.</p>

                    <div class="contact-list">
                        <a href="https://wa.me/6281280061238" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                            <span><small>WhatsApp / Sales</small>0812 8006 1238</span>
                        </a>
                        <a href="https://www.hinoarmindo.co.id" target="_blank" rel="noopener noreferrer">
                            <i class="fa-solid fa-globe" aria-hidden="true"></i>
                            <span><small>HINO Armindo</small>www.hinoarmindo.co.id</span>
                        </a>
                        <div>
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <span><small>Alamat Dealer</small>Jl. Daan Mogot, Tangerang</span>
                        </div>
                        <a href="mailto:sales@hinoarmindo.co.id">
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                            <span><small>Email</small>sales@hinoarmindo.co.id</span>
                        </a>
                        <div>
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            <span><small>Jam Operasional</small>09.00–17.00 WIB</span>
                        </div>
                    </div>

                    <a class="button button-primary" href="https://wa.me/6281280061238?text=Halo%20Armindo%20Perkasa,%20saya%20ingin%20konsultasi%20unit%20HINO." target="_blank" rel="noopener noreferrer">Hubungi Sales Sekarang</a>

                    <ul class="dealer-benefits">
                        <li><i class="fa-solid fa-shield-check" aria-hidden="true"></i> Dealer Resmi HINO</li>
                        <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Ready Unit</li>
                        <li><i class="fa-solid fa-hand-holding-heart" aria-hidden="true"></i> Pelayanan Profesional</li>
                        <li><i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i> Servis &amp; Sparepart</li>
                    </ul>
                </div>

            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Armindo Perkasa - Authorized HINO Dealer</p>
    </footer>
</div>
@endsection
