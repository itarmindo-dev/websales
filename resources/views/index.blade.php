@extends('layouts.marketing')

@section('title', 'Armindo Perkasa - Dealer Resmi HINO')

@php
    $whatsapp = preg_replace('/\D+/', '', $settings->whatsapp_number);
    $generalWhatsappMessage = rawurlencode('Halo Armindo Perkasa, saya ingin konsultasi unit HINO.');
    $secondaryTarget = match (true) {
        $settings->models_enabled => '#models',
        $settings->tco_enabled => '#tco',
        $settings->testimonials_enabled => '#testimonials',
        $settings->contact_enabled => '#contact',
        default => '#home',
    };
    $benefitIcons = ['fa-chart-column', 'fa-gas-pump', 'fa-screwdriver-wrench', 'fa-coins'];
    $promiseIcons = ['fa-handshake', 'fa-mobile-screen-button', 'fa-truck', 'fa-user-gear'];
    $dealerIcons = ['fa-shield-check', 'fa-circle-check', 'fa-hand-holding-heart', 'fa-screwdriver-wrench'];
@endphp

@section('content')
<a class="skip-link" href="#main-content">Lewati ke konten utama</a>

<div x-data="{ menuOpen: false, scrolled: window.scrollY > 24 }" @scroll.window="scrolled = window.scrollY > 24" @keydown.escape.window="menuOpen = false">
    <header class="site-header" :class="{ 'is-scrolled': scrolled }">
        <nav class="site-nav" aria-label="Navigasi utama">
            <a href="#home" class="brand-hino" aria-label="Armindo Perkasa - Beranda">
                <img src="{{ asset('img/logo/logohinopth.png') }}" alt="HINO">
            </a>

            <div class="desktop-nav">
                <a href="#home" class="is-active" data-nav-section="home" aria-current="location">Beranda</a>
                @if ($settings->tco_enabled)<a href="#tco" data-nav-section="tco">Kalkulator TCO</a>@endif
                @if ($settings->models_enabled)<a href="#models" data-nav-section="models">Model Truk</a>@endif
                @if ($settings->testimonials_enabled)<a href="#testimonials" data-nav-section="testimonials">Testimoni</a>@endif
                @if ($settings->contact_enabled)<a href="#contact" data-nav-section="contact">Tentang Kami</a>@endif
            </div>

            <div class="nav-actions">
                <img class="brand-armindo" src="{{ asset('img/logo/logoap1.png') }}" alt="PT Armindo Perkasa">
                <a class="button button-primary nav-cta" href="https://wa.me/{{ $whatsapp }}?text={{ $generalWhatsappMessage }}" target="_blank" rel="noopener noreferrer">
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
            <a href="#home" class="is-active" data-nav-section="home" aria-current="location" @click="menuOpen = false">Beranda</a>
            @if ($settings->tco_enabled)<a href="#tco" data-nav-section="tco" @click="menuOpen = false">Kalkulator TCO</a>@endif
            @if ($settings->models_enabled)<a href="#models" data-nav-section="models" @click="menuOpen = false">Model Truk</a>@endif
            @if ($settings->testimonials_enabled)<a href="#testimonials" data-nav-section="testimonials" @click="menuOpen = false">Testimoni</a>@endif
            @if ($settings->contact_enabled)<a href="#contact" data-nav-section="contact" @click="menuOpen = false">Tentang Kami</a>@endif
            <a href="https://wa.me/{{ $whatsapp }}?text={{ $generalWhatsappMessage }}" target="_blank" rel="noopener noreferrer">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Hubungi Sales
            </a>
        </div>
    </header>

    <main id="main-content">
        <section id="home" class="hero-section" aria-labelledby="hero-title">
            @if ($settings->hero_background)
                <img class="hero-background" src="{{ asset($settings->hero_background) }}" alt="Armindo Perkasa dan kendaraan HINO">
            @endif

            <div class="section-container hero-inner">
                <div class="hero-copy">
                    <p class="eyebrow">{{ $settings->hero_eyebrow }}</p>
                    <h1 id="hero-title">{{ $settings->hero_title }}<br><span>{{ $settings->hero_highlight }}</span></h1>
                    <p class="hero-lead">{{ $settings->hero_description }}</p>

                    <div class="hero-actions">
                        <a class="button button-primary" href="https://wa.me/{{ $whatsapp }}?text={{ $generalWhatsappMessage }}" target="_blank" rel="noopener noreferrer">{{ $settings->hero_primary_label }}</a>
                        <a class="button button-outline" href="{{ $secondaryTarget }}">{{ $settings->hero_secondary_label }}</a>
                    </div>
                </div>

                @if ($settings->locations)
                    <div class="hero-locations" aria-label="Jaringan cabang Armindo Perkasa">
                        @foreach ($settings->locations as $location)
                            <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $location }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        @if ($settings->tco_enabled)
            <section id="tco" class="tco-section" aria-labelledby="tco-title">
                <div class="section-container tco-grid">
                    <div class="tco-intro">
                        <p class="section-kicker">{{ $settings->tco_kicker }}</p>
                        <h2 id="tco-title">{{ $settings->tco_title }} <span>{{ $settings->tco_highlight }}</span></h2>
                        <p class="section-lead">{{ $settings->tco_lead }}</p>
                        <p class="section-description">{{ $settings->tco_description }}</p>

                        @if ($settings->tco_benefits)
                            <div class="benefit-list" aria-label="Manfaat kalkulator TCO">
                                @foreach ($settings->tco_benefits as $benefit)
                                    <div class="benefit-item">
                                        <i class="fa-solid {{ $benefitIcons[$loop->index % count($benefitIcons)] }}" aria-hidden="true"></i>
                                        <span>{{ $benefit }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="promo-note">
                            <i class="fa-solid fa-gift" aria-hidden="true"></i>
                            <p>{{ $settings->tco_promo }}</p>
                        </div>

                        <a class="text-link" href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Halo Armindo Perkasa, saya ingin langsung konsultasi dengan sales.') }}" target="_blank" rel="noopener noreferrer">
                            Langsung hubungi sales <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                    </div>

                    <div id="tco-calculator-app" class="tco-app-shell" data-submit-url="{{ route('tco.submit') }}" aria-live="polite"></div>
                </div>
            </section>
        @endif

        @if ($settings->models_enabled)
            <section id="models" class="ready-section" aria-labelledby="ready-title">
                <div class="section-container ready-grid">
                    <div class="ready-copy">
                        <p class="section-kicker">{{ $settings->models_kicker }}</p>
                        <h2 id="ready-title"><span>{{ $settings->models_highlight }}</span><br>{{ $settings->models_title }}</h2>
                        <p>{{ $settings->models_description }}</p>
                        <small>{{ $settings->models_note }}</small>
                    </div>

                    <div class="ready-visual">
                        @if ($settings->models_image)<img src="{{ asset($settings->models_image) }}" alt="Lineup kendaraan HINO siap kirim">@endif
                        <a class="ready-contact" href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Halo Armindo Perkasa, saya ingin menanyakan stok unit HINO.') }}" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-whatsapp ready-contact-icon" aria-hidden="true"></i>
                            <span class="ready-contact-copy">
                                <span class="ready-contact-label">{{ $settings->models_cta_label }}</span>
                                <strong>{{ $settings->whatsapp_label }}</strong>
                                <small>{{ $settings->models_cta_subtitle }}</small>
                            </span>
                            <i class="fa-solid fa-arrow-right ready-contact-arrow" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                @if ($truckModels->isNotEmpty())
                    <div class="section-container truck-model-grid" aria-label="Daftar model truk HINO">
                        @foreach ($truckModels as $truckModel)
                            <article class="truck-model-card">
                                <div class="truck-model-image">
                                    @if ($truckModel->image)<img src="{{ asset($truckModel->image) }}" alt="{{ $truckModel->name }} {{ $truckModel->series }}" loading="lazy">@endif
                                </div>
                                <div class="truck-model-copy">
                                    @if ($truckModel->series)<p>{{ $truckModel->series }}</p>@endif
                                    <h3>{{ $truckModel->name }}</h3>
                                    @if ($truckModel->description)<div>{{ $truckModel->description }}</div>@endif
                                    <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode($truckModel->whatsapp_message ?: 'Halo Armindo Perkasa, saya ingin mengetahui informasi '.$truckModel->name.'.') }}" target="_blank" rel="noopener noreferrer">Tanya model ini <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        @if ($settings->testimonials_enabled)
            <section id="testimonials" class="testimonial-section" aria-labelledby="testimonial-title">
                @if ($settings->testimonials_watermark)<img class="testimonial-watermark" src="{{ asset($settings->testimonials_watermark) }}" alt="" aria-hidden="true">@endif
                <div class="section-container testimonial-inner">
                    <div class="section-heading">
                        <h2 id="testimonial-title">{{ $settings->testimonials_title }}</h2>
                        <p>{{ $settings->testimonials_description }}</p>
                    </div>

                    @if ($testimonials->isNotEmpty())
                        <div class="testimonial-grid">
                            @foreach ($testimonials as $testimonial)
                                <article class="testimonial-card">
                                    <i class="fa-solid fa-quote-left quote-icon" aria-hidden="true"></i>
                                    <div class="customer-info">
                                        @if ($testimonial->photo)<img src="{{ asset($testimonial->photo) }}" alt="Foto {{ $testimonial->name }}">@endif
                                        <div>
                                            <h3>{{ $testimonial->name }}</h3>
                                            @if ($testimonial->company)<p>{{ $testimonial->company }} @if($testimonial->is_verified)<i class="fa-solid fa-circle-check" aria-label="Pelanggan terverifikasi"></i>@endif</p>@endif
                                        </div>
                                    </div>
                                    <blockquote>{{ $testimonial->quote }}</blockquote>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    @if ($settings->service_promises)
                        <div class="service-promises" aria-label="Komitmen layanan">
                            @foreach ($settings->service_promises as $promise)
                                <span><i class="fa-solid {{ $promiseIcons[$loop->index % count($promiseIcons)] }}" aria-hidden="true"></i> {{ $promise }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif

        @if ($settings->contact_enabled)
            <section id="contact" class="contact-section" aria-labelledby="contact-title" @if($settings->contact_background) style="--contact-background: url('{{ asset($settings->contact_background) }}')" @endif>
                <div class="section-container contact-grid">
                    <div class="contact-copy">
                        <p class="section-kicker">{{ $settings->contact_kicker }}</p>
                        <h2 id="contact-title">{{ $settings->contact_title }}</h2>
                        <p>{{ $settings->contact_description }}</p>

                        <div class="contact-list">
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span><small>WhatsApp / Sales</small>{{ $settings->whatsapp_label }}</span></a>
                            @if ($settings->website_url)<a href="{{ $settings->website_url }}" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-globe" aria-hidden="true"></i><span><small>HINO Armindo</small>{{ $settings->website_label ?: $settings->website_url }}</span></a>@endif
                            <div><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span><small>Alamat Dealer</small>{{ $settings->address }}</span></div>
                            <a href="mailto:{{ $settings->email }}"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span><small>Email</small>{{ $settings->email }}</span></a>
                            <div><i class="fa-solid fa-clock" aria-hidden="true"></i><span><small>Jam Operasional</small>{{ $settings->business_hours }}</span></div>
                        </div>

                        <a class="button button-primary" href="https://wa.me/{{ $whatsapp }}?text={{ $generalWhatsappMessage }}" target="_blank" rel="noopener noreferrer">{{ $settings->contact_cta_label }}</a>

                        @if ($settings->dealer_benefits)
                            <ul class="dealer-benefits">
                                @foreach ($settings->dealer_benefits as $benefit)
                                    <li><i class="fa-solid {{ $dealerIcons[$loop->index % count($dealerIcons)] }}" aria-hidden="true"></i> {{ $benefit }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Armindo Perkasa - Authorized HINO Dealer</p>
    </footer>
</div>
@endsection
