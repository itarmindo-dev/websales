@php
    $salesWhatsapp = preg_replace('/\D+/', '', (string) ($sale->whatsapp_number ?? $sale->whatsapp));
    $dealerWhatsapp = preg_replace('/\D+/', '', (string) $defaultWhatsapp);
    $whatsapp = $salesWhatsapp ?: $dealerWhatsapp;
    $usesDealerWhatsapp = ! $salesWhatsapp && (bool) $dealerWhatsapp;
    $whatsappMessage = rawurlencode($usesDealerWhatsapp
        ? "Halo Armindo Perkasa, saya membuka profil sales {$sale->name} dan ingin berkonsultasi mengenai unit HINO."
        : "Halo {$sale->name}, saya ingin berkonsultasi mengenai unit HINO.");
    $whatsappUrl = $whatsapp ? "https://wa.me/{$whatsapp}?text={$whatsappMessage}" : null;
    $facebookUrl = Str::startsWith((string) ($sale->facebook_link ?? $sale->facebook), ['http://', 'https://'])
        ? ($sale->facebook_link ?? $sale->facebook)
        : null;
    $instagramUrl = Str::startsWith((string) ($sale->instagram_link ?? $sale->instagram), ['http://', 'https://'])
        ? ($sale->instagram_link ?? $sale->instagram)
        : null;
    $profileImage = $sale->mediaUrl($sale->photo);
    if ($sale->photo && ! $profileImage) {
        $profileImage = asset('img/team/ca-team-iner1.2.png');
    }
    $heroImage = $sale->mediaUrl($sale->hero_image) ?: asset('img/slider/herosales.png');
    $footerImage = $sale->mediaUrl($sale->footer_image) ?: asset('img/slider/footersales.png');
    $documentationImages = collect($sale->documentation_photos ?? [])
        ->map(fn (string $path) => $sale->mediaUrl($path))
        ->filter()
        ->values();
    if (filled($sale->documentation_photos) && $documentationImages->isEmpty()) {
        $documentationImages = collect([
            asset('img/portfolio/portfolio-big-1.3.png'),
            asset('img/portfolio/ca-project3.3.png'),
            asset('img/portfolio/ca-project3.4.png'),
        ]);
    }
    $heroTitle = $sale->hero_title ?: 'Armada tepat untuk perjalanan bisnis yang lebih jauh.';
    $heroDescription = $sale->hero_description
        ?: ($sale->slogan ?: 'Konsultasi unit, informasi stok, dan pendampingan pembelian HINO yang disusun sesuai kebutuhan operasional Anda.');
    $footerTitle = $sale->footer_title ?: 'Mari susun armada yang siap bekerja.';
    $footerDescription = $sale->footer_description
        ?: 'Ceritakan muatan, rute, dan target usaha Anda. Konsultasi pertama dapat dimulai langsung melalui WhatsApp.';
    $hasWork = $sale->sections->isNotEmpty() || $documentationImages->isNotEmpty();
@endphp

<x-layouts.sales
    :title="$sale->name.' - Sales HINO Armindo Perkasa'"
    :description="'Hubungi '.$sale->name.' untuk konsultasi unit HINO Armindo Perkasa.'"
>
    <div class="sales-page">
        <header class="sales-header">
            <a href="{{ route('home') }}" class="sales-brand" aria-label="Kembali ke beranda Armindo Perkasa">
                <x-application-logo inverted class="sales-brand-lockup" />
            </a>

            <nav class="sales-nav" aria-label="Navigasi profil sales">
                <a href="#tentang">Tentang</a>
                @if ($hasWork)
                    <a href="#cerita">Cerita</a>
                @endif
                <a href="#kontak">Kontak</a>
            </nav>

            @if ($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="sales-nav-cta">
                    <span>Mulai konsultasi</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9" /></svg>
                </a>
            @endif
        </header>

        <main>
            <section class="sales-hero" style="--sales-hero-image: url('{{ $heroImage }}')">
                <div class="sales-hero-orbit" aria-hidden="true"></div>
                <div class="sales-hero-word" aria-hidden="true">MELAJU</div>

                <div class="sales-hero-copy">
                    <p class="sales-kicker">Sales resmi HINO <span></span> Armindo Perkasa</p>
                    <h1>{{ $heroTitle }}</h1>
                    <p class="sales-hero-description">{{ $heroDescription }}</p>
                    <div class="sales-hero-actions">
                        @if ($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="sales-button sales-button--solid">Chat WhatsApp</a>
                        @endif
                        <a href="{{ route('home', ['sales' => $sale->slug]) }}#tco" class="sales-button sales-button--ghost">Kalkulator TCO</a>
                    </div>
                </div>

                <aside class="sales-person" aria-label="Profil {{ $sale->name }}">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="Foto {{ $sale->name }}">
                    @else
                        <span class="sales-person-initial">{{ Str::upper(Str::substr($sale->name, 0, 1)) }}</span>
                    @endif
                    <div>
                        <p>{{ $sale->name }}</p>
                        <span>{{ $sale->tagline ?: 'HINO Sales Executive' }}</span>
                    </div>
                </aside>

                <div class="sales-hero-foot">
                    <span>01 / Profil</span>
                    <span>{{ $sale->specialties ?: 'Konsultasi armada HINO' }}</span>
                    <a href="#tentang">Scroll untuk mengenal lebih dekat &darr;</a>
                </div>
            </section>

            <section id="tentang" class="sales-intro">
                <div class="sales-section-index" aria-hidden="true">01</div>
                <div class="sales-intro-heading">
                    <p class="sales-kicker sales-kicker--dark">Pendekatan konsultatif</p>
                    <h2>Bukan sekadar memilih truk. <em>Menyusun armada yang bekerja.</em></h2>
                </div>
                <div class="sales-intro-copy">
                    <p class="sales-lead">{{ $sale->bio ?: 'Saya membantu Anda memilih unit HINO berdasarkan kebutuhan usaha, karakter muatan, rute, dan pola operasional sehari-hari.' }}</p>
                    <dl class="sales-contact-list">
                        @if ($whatsapp)
                            <div><dt>WhatsApp</dt><dd>+{{ $whatsapp }}</dd></div>
                        @endif
                        @if ($sale->phone)
                            <div><dt>Telepon</dt><dd>{{ $sale->phone }}</dd></div>
                        @endif
                        @if ($sale->specialties)
                            <div><dt>Fokus unit</dt><dd>{{ $sale->specialties }}</dd></div>
                        @endif
                    </dl>
                </div>
            </section>

            <section class="sales-capabilities" aria-label="Layanan sales">
                <div><span>01</span><h3>Konsultasi unit</h3><p>Pemilihan kendaraan berdasarkan muatan, rute, dan target operasional.</p></div>
                <div><span>02</span><h3>Informasi stok</h3><p>Konfirmasi ketersediaan unit dan pendampingan proses pembelian.</p></div>
                <div><span>03</span><h3>Layanan purna jual</h3><p>Koordinasi kebutuhan karoseri serta informasi layanan setelah serah terima.</p></div>
            </section>

            @if ($sale->sections->isNotEmpty())
                <div id="cerita" class="sales-sections">
                    @foreach ($sale->sections as $section)
                        @php
                            $sectionNumber = str_pad((string) ($loop->iteration + 1), 2, '0', STR_PAD_LEFT);
                            $sectionMedia = $section->mediaUrl();
                            $videoLayout = in_array($section->layout, ['video_left', 'video_right'], true)
                                ? $section->layout
                                : 'full_width';
                            $sectionClass = match ($section->type) {
                                'image_text' => 'sales-content sales-content--'.$section->layout,
                                'video' => 'sales-content sales-content--video sales-content--'.$videoLayout,
                                default => 'sales-content sales-content--text',
                            };
                        @endphp

                        <section class="{{ $sectionClass }}">
                            <div class="sales-section-index" aria-hidden="true">{{ $sectionNumber }}</div>

                            @if ($section->type === 'image_text')
                                @if ($sectionMedia)
                                    <figure class="sales-content-media">
                                        <img src="{{ $sectionMedia }}" alt="{{ $section->title }}" loading="lazy">
                                    </figure>
                                @endif
                                <div class="sales-content-copy">
                                    <p class="sales-kicker sales-kicker--dark">{{ $section->eyebrow ?: 'Cerita lapangan' }}</p>
                                    <h2>{{ $section->title }}</h2>
                                    @if ($section->body)
                                        <div class="sales-content-body">{{ $section->body }}</div>
                                    @endif
                                    @if ($section->button_label && $section->button_url)
                                        <a href="{{ $section->button_url }}" target="_blank" rel="noopener noreferrer" class="sales-text-link">{{ $section->button_label }} <span>&nearr;</span></a>
                                    @endif
                                </div>
                            @elseif ($section->type === 'video')
                                <div class="sales-video-copy">
                                    <header class="sales-video-heading">
                                        <p class="sales-kicker sales-kicker--dark">{{ $section->eyebrow ?: 'Video' }}</p>
                                        <h2>{{ $section->title }}</h2>
                                        @if ($section->body)<p class="sales-video-description">{{ $section->body }}</p>@endif
                                    </header>
                                    @if ($section->button_label && $section->button_url)
                                        <a href="{{ $section->button_url }}" target="_blank" rel="noopener noreferrer" class="sales-text-link">{{ $section->button_label }} <span>&nearr;</span></a>
                                    @endif
                                </div>
                                <div class="sales-video-frame">
                                    @if ($section->media_path && $section->hasDirectVideo())
                                        <video controls preload="metadata">
                                            <source src="{{ $sectionMedia }}">
                                            Browser Anda tidak mendukung pemutar video.
                                        </video>
                                    @elseif ($section->videoEmbedUrl())
                                        <iframe src="{{ $section->videoEmbedUrl() }}" title="{{ $section->title }}" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    @elseif ($sectionMedia && $section->hasDirectVideo())
                                        <video controls preload="metadata">
                                            <source src="{{ $sectionMedia }}">
                                            Browser Anda tidak mendukung pemutar video.
                                        </video>
                                    @elseif ($section->media_url)
                                        <a href="{{ $section->media_url }}" target="_blank" rel="noopener noreferrer" class="sales-video-external">Buka video <span>&nearr;</span></a>
                                    @else
                                        <div class="sales-video-empty">Media video belum ditambahkan.</div>
                                    @endif
                                </div>
                            @else
                                <div class="sales-editorial-copy">
                                    <p class="sales-kicker">{{ $section->eyebrow ?: 'Catatan' }}</p>
                                    <h2>{{ $section->title }}</h2>
                                    @if ($section->body)<div>{{ $section->body }}</div>@endif
                                    @if ($section->button_label && $section->button_url)
                                        <a href="{{ $section->button_url }}" target="_blank" rel="noopener noreferrer" class="sales-text-link sales-text-link--light">{{ $section->button_label }} <span>&nearr;</span></a>
                                    @endif
                                </div>
                            @endif
                        </section>
                    @endforeach
                </div>
            @endif

            @if ($documentationImages->isNotEmpty())
                <section id="{{ $sale->sections->isEmpty() ? 'cerita' : 'dokumentasi' }}" class="sales-gallery">
                    <div class="sales-gallery-heading">
                        <p class="sales-kicker sales-kicker--dark">Dokumentasi nyata</p>
                        <h2>Perjalanan unit, <em>dari konsultasi sampai serah terima.</em></h2>
                    </div>
                    <div class="sales-gallery-grid">
                        @foreach ($documentationImages as $documentationImage)
                            <figure>
                                <img src="{{ $documentationImage }}" alt="Dokumentasi penyerahan unit oleh {{ $sale->name }}" loading="lazy">
                                <figcaption>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} / HINO Armindo Perkasa</figcaption>
                            </figure>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="kontak" class="sales-footer-cta" style="--sales-footer-image: url('{{ $footerImage }}')">
                <div class="sales-footer-orbit" aria-hidden="true"></div>
                <div class="sales-footer-copy">
                    <p class="sales-kicker">Langkah berikutnya</p>
                    <h2>{{ $footerTitle }}</h2>
                    <p>{{ $footerDescription }}</p>
                    @if ($whatsappUrl)
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="sales-button sales-button--light">Hubungi {{ $sale->name }}</a>
                    @endif
                </div>

                <div class="sales-footer-panel">
                    <div>
                        <x-application-logo inverted class="sales-footer-lockup" />
                        <p>Armindo Perkasa<br>Authorized HINO Dealer</p>
                    </div>
                    <dl>
                        @if ($whatsapp)<div><dt>{{ $usesDealerWhatsapp ? 'WhatsApp dealer' : 'WhatsApp' }}</dt><dd>+{{ $whatsapp }}</dd></div>@endif
                        @if ($sale->phone)<div><dt>Telepon</dt><dd>{{ $sale->phone }}</dd></div>@endif
                        <div><dt>Sales consultant</dt><dd>{{ $sale->name }}</dd></div>
                    </dl>
                    <div class="sales-social-links">
                        @if ($instagramUrl)<a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer">Instagram</a>@endif
                        @if ($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer">Facebook</a>@endif
                        <a href="{{ route('home') }}">Website utama</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="sales-footer">
            <p>&copy; {{ now()->year }} Armindo Perkasa</p>
            <p>Profil resmi {{ $sale->name }}</p>
        </footer>
    </div>
</x-layouts.sales>
