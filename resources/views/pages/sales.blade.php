@php
    $whatsapp = preg_replace('/\D+/', '', (string) ($sale->whatsapp_number ?? $sale->whatsapp));
    $whatsappMessage = rawurlencode("Halo {$sale->name}, saya ingin berkonsultasi mengenai unit HINO.");
    $facebookUrl = Str::startsWith((string) ($sale->facebook_link ?? $sale->facebook), ['http://', 'https://'])
        ? ($sale->facebook_link ?? $sale->facebook)
        : null;
    $instagramUrl = Str::startsWith((string) ($sale->instagram_link ?? $sale->instagram), ['http://', 'https://'])
        ? ($sale->instagram_link ?? $sale->instagram)
        : null;
@endphp

<x-layouts.sales
    :title="$sale->name.' - Sales HINO Armindo Perkasa'"
    :description="'Hubungi '.$sale->name.' untuk konsultasi unit HINO Armindo Perkasa.'"
>
    <header class="border-b border-gray-200 bg-white">
        <nav class="mx-auto flex h-18 max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" aria-label="Kembali ke beranda Armindo Perkasa">
                <img src="{{ asset('img/logo/logohinopth.png') }}" alt="HINO" class="h-10 w-36 object-contain">
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#models" class="hidden text-sm font-semibold text-gray-700 hover:text-green-800 sm:inline">Model Truk</a>
                @if ($whatsapp)
                    <a href="https://wa.me/{{ $whatsapp }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-full bg-green-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                        Hubungi Sales
                    </a>
                @endif
            </div>
        </nav>
    </header>

    <main>
        <section class="overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-green-700 text-white">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 md:grid-cols-[minmax(0,1fr)_340px] md:py-20 lg:px-8">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.16em] text-green-200">Sales resmi HINO Armindo Perkasa</p>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">{{ $sale->name }}</h1>
                    <p class="mt-3 text-lg font-medium text-green-100">{{ $sale->tagline ?: 'Siap membantu kebutuhan armada bisnis Anda' }}</p>
                    @if ($sale->specialties)
                        <p class="mt-5 inline-flex rounded-full border border-green-300/30 bg-white/10 px-4 py-2 text-sm text-green-50">Spesialisasi: {{ $sale->specialties }}</p>
                    @endif
                    <p class="mt-6 max-w-2xl text-base leading-7 text-green-50/90">{{ $sale->slogan ?: 'Dapatkan informasi unit, ketersediaan stok, dan konsultasi sesuai kebutuhan operasional bisnis Anda.' }}</p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @if ($whatsapp)
                            <a href="https://wa.me/{{ $whatsapp }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-lg bg-white px-5 py-3 text-sm font-semibold text-green-900 transition hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-900">
                                Chat WhatsApp
                            </a>
                        @endif
                        <a href="{{ route('home') }}#tco" class="inline-flex rounded-lg border border-white/60 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-900">
                            Buka Kalkulator TCO
                        </a>
                    </div>
                </div>

                <div class="mx-auto w-full max-w-sm">
                    @if ($sale->photo)
                        <img src="{{ $sale->mediaUrl($sale->photo) }}" alt="Foto {{ $sale->name }}" class="aspect-square w-full rounded-3xl border-4 border-white/20 object-cover shadow-2xl">
                    @else
                        <div class="grid aspect-square w-full place-items-center rounded-3xl border-4 border-white/20 bg-white/10 text-7xl font-semibold text-white shadow-2xl">
                            {{ Str::upper(Str::substr($sale->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="mx-auto grid max-w-7xl gap-8 px-4 py-14 sm:px-6 md:grid-cols-[minmax(0,1.4fr)_minmax(280px,0.6fr)] lg:px-8 lg:py-20">
            <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-semibold text-gray-900">Tentang {{ $sale->name }}</h2>
                <div class="mt-4 whitespace-pre-line leading-7 text-gray-600">{{ $sale->bio ?: 'Siap membantu Anda memilih unit HINO yang sesuai dengan kebutuhan usaha dan pola operasional armada.' }}</div>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-green-50 p-4">
                        <p class="font-semibold text-green-900">Konsultasi unit</p>
                        <p class="mt-1 text-sm leading-6 text-green-800">Pemilihan kendaraan sesuai muatan dan rute.</p>
                    </div>
                    <div class="rounded-xl bg-green-50 p-4">
                        <p class="font-semibold text-green-900">Informasi stok</p>
                        <p class="mt-1 text-sm leading-6 text-green-800">Konfirmasi ketersediaan dan proses pembelian.</p>
                    </div>
                    <div class="rounded-xl bg-green-50 p-4">
                        <p class="font-semibold text-green-900">Purna jual</p>
                        <p class="mt-1 text-sm leading-6 text-green-800">Informasi layanan setelah unit diterima.</p>
                    </div>
                </div>
            </article>

            <aside class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900">Kontak</h2>
                <dl class="mt-5 space-y-5 text-sm">
                    @if ($whatsapp)
                        <div>
                            <dt class="font-medium text-gray-500">WhatsApp</dt>
                            <dd class="mt-1 font-semibold text-gray-900">+{{ $whatsapp }}</dd>
                        </div>
                    @endif
                    @if ($sale->phone)
                        <div>
                            <dt class="font-medium text-gray-500">Telepon</dt>
                            <dd class="mt-1 font-semibold text-gray-900">{{ $sale->phone }}</dd>
                        </div>
                    @endif
                </dl>

                @if ($facebookUrl || $instagramUrl)
                    <div class="mt-7 border-t border-gray-200 pt-5">
                        <p class="text-sm font-medium text-gray-500">Media sosial</p>
                        <div class="mt-3 flex flex-wrap gap-3 text-sm font-semibold">
                            @if ($facebookUrl)
                                <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:underline">Facebook</a>
                            @endif
                            @if ($instagramUrl)
                                <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="text-pink-700 hover:underline">Instagram</a>
                            @endif
                        </div>
                    </div>
                @endif
            </aside>
        </section>

        @if ($sale->documentation_photos)
            <section class="border-y border-gray-200 bg-white py-14 lg:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        <h2 class="text-2xl font-semibold text-gray-900">Dokumentasi penyerahan unit</h2>
                        <p class="mt-2 text-gray-600">Dokumentasi layanan dan penyerahan unit kepada pelanggan.</p>
                    </div>
                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($sale->documentation_photos as $documentationPhoto)
                            <img src="{{ $sale->mediaUrl($documentationPhoto) }}" alt="Dokumentasi penyerahan unit oleh {{ $sale->name }}" loading="lazy" class="aspect-[4/3] w-full rounded-xl object-cover">
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="bg-gray-50 py-14">
            <div class="mx-auto flex max-w-5xl flex-col items-center px-4 text-center sm:px-6">
                <h2 class="text-2xl font-semibold text-gray-900">Butuh rekomendasi unit HINO?</h2>
                <p class="mt-3 max-w-2xl text-gray-600">Sampaikan kebutuhan muatan, rute, dan pola operasional Anda agar rekomendasi unit lebih tepat.</p>
                @if ($whatsapp)
                    <a href="https://wa.me/{{ $whatsapp }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex rounded-lg bg-green-700 px-6 py-3 text-sm font-semibold text-white hover:bg-green-800">Hubungi {{ $sale->name }}</a>
                @endif
            </div>
        </section>
    </main>

    <footer class="border-t border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6 text-sm text-gray-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>&copy; {{ now()->year }} Armindo Perkasa</p>
            <a href="{{ route('home') }}" class="font-medium text-green-700 hover:text-green-900">Website utama</a>
        </div>
    </footer>
</x-layouts.sales>
