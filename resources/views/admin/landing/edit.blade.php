<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Landing Page</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola teks, gambar, kontak, dan section yang tampil di halaman utama.</p>
            </div>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Buka Landing Page</a>
        </div>
    </x-slot>

    @php
        $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600';
        $labelClass = 'block text-sm font-medium text-gray-800';
    @endphp

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @include('admin.landing._tabs')

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="status">{{ session('success') }}</div>
            @endif

            <div class="mb-5 grid gap-4 sm:grid-cols-2">
                <a href="{{ route('admin.truck-models.index') }}" class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-green-300">
                    <p class="font-semibold text-gray-900">{{ $truckModelCount }} model truk</p>
                    <p class="mt-1 text-sm text-gray-500">Atur kartu model dan urutan tampil.</p>
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-green-300">
                    <p class="font-semibold text-gray-900">{{ $testimonialCount }} testimoni</p>
                    <p class="mt-1 text-sm text-gray-500">Kelola kutipan dan identitas pelanggan.</p>
                </a>
            </div>

            <form method="POST" action="{{ route('admin.landing.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                        <p class="font-semibold">Periksa kembali data berikut:</p>
                        <ul class="mt-2 list-disc space-y-1 ps-5">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="hero-settings">
                    <h2 id="hero-settings" class="text-lg font-semibold text-gray-900">Hero</h2>
                    <p class="mt-1 text-sm text-gray-500">Konten pertama yang dilihat pengunjung.</p>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div><label for="hero_eyebrow" class="{{ $labelClass }}">Label kecil</label><input id="hero_eyebrow" name="hero_eyebrow" value="{{ old('hero_eyebrow', $settings->hero_eyebrow) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="hero_title" class="{{ $labelClass }}">Judul utama</label><input id="hero_title" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="hero_highlight" class="{{ $labelClass }}">Judul sorotan</label><input id="hero_highlight" name="hero_highlight" value="{{ old('hero_highlight', $settings->hero_highlight) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="hero_description" class="{{ $labelClass }}">Deskripsi</label><textarea id="hero_description" name="hero_description" rows="3" required class="{{ $inputClass }}">{{ old('hero_description', $settings->hero_description) }}</textarea></div>
                        <div><label for="hero_primary_label" class="{{ $labelClass }}">Teks tombol utama</label><input id="hero_primary_label" name="hero_primary_label" value="{{ old('hero_primary_label', $settings->hero_primary_label) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="hero_secondary_label" class="{{ $labelClass }}">Teks tombol kedua</label><input id="hero_secondary_label" name="hero_secondary_label" value="{{ old('hero_secondary_label', $settings->hero_secondary_label) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="locations_text" class="{{ $labelClass }}">Lokasi cabang</label><textarea id="locations_text" name="locations_text" rows="4" required class="{{ $inputClass }}">{{ old('locations_text', implode(PHP_EOL, $settings->locations ?? [])) }}</textarea><p class="mt-1 text-xs text-gray-500">Satu lokasi per baris.</p></div>
                        <div class="sm:col-span-2">@include('admin.landing._image-field', ['label' => 'Background hero', 'databaseField' => 'hero_background', 'uploadField' => 'hero_background_upload', 'currentPath' => $settings->hero_background])</div>
                    </div>
                </section>

                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="tco-settings">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><h2 id="tco-settings" class="text-lg font-semibold text-gray-900">Pengantar Kalkulator TCO</h2><p class="mt-1 text-sm text-gray-500">Hanya konten pengantar; rumus dan pengiriman email tidak berubah.</p></div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700"><input type="hidden" name="tco_enabled" value="0"><input type="checkbox" name="tco_enabled" value="1" @checked(old('tco_enabled', $settings->tco_enabled)) class="rounded border-gray-300 text-green-700 focus:ring-green-600">Tampilkan section</label>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div><label for="tco_kicker" class="{{ $labelClass }}">Label kecil</label><input id="tco_kicker" name="tco_kicker" value="{{ old('tco_kicker', $settings->tco_kicker) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="tco_highlight" class="{{ $labelClass }}">Judul sorotan</label><input id="tco_highlight" name="tco_highlight" value="{{ old('tco_highlight', $settings->tco_highlight) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="tco_title" class="{{ $labelClass }}">Judul</label><input id="tco_title" name="tco_title" value="{{ old('tco_title', $settings->tco_title) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="tco_lead" class="{{ $labelClass }}">Kalimat utama</label><textarea id="tco_lead" name="tco_lead" rows="2" required class="{{ $inputClass }}">{{ old('tco_lead', $settings->tco_lead) }}</textarea></div>
                        <div class="sm:col-span-2"><label for="tco_description" class="{{ $labelClass }}">Deskripsi</label><textarea id="tco_description" name="tco_description" rows="3" required class="{{ $inputClass }}">{{ old('tco_description', $settings->tco_description) }}</textarea></div>
                        <div class="sm:col-span-2"><label for="tco_benefits_text" class="{{ $labelClass }}">Manfaat kalkulator</label><textarea id="tco_benefits_text" name="tco_benefits_text" rows="4" required class="{{ $inputClass }}">{{ old('tco_benefits_text', implode(PHP_EOL, $settings->tco_benefits ?? [])) }}</textarea><p class="mt-1 text-xs text-gray-500">Satu manfaat per baris; empat baris pertama menggunakan ikon yang tersedia.</p></div>
                        <div class="sm:col-span-2"><label for="tco_promo" class="{{ $labelClass }}">Catatan promo</label><textarea id="tco_promo" name="tco_promo" rows="2" required class="{{ $inputClass }}">{{ old('tco_promo', $settings->tco_promo) }}</textarea></div>
                    </div>
                </section>

                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="models-settings">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><h2 id="models-settings" class="text-lg font-semibold text-gray-900">Ready Unit & Model Truk</h2><p class="mt-1 text-sm text-gray-500">Konten pembuka section model truk.</p></div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700"><input type="hidden" name="models_enabled" value="0"><input type="checkbox" name="models_enabled" value="1" @checked(old('models_enabled', $settings->models_enabled)) class="rounded border-gray-300 text-green-700 focus:ring-green-600">Tampilkan section</label>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div><label for="models_kicker" class="{{ $labelClass }}">Label kecil</label><input id="models_kicker" name="models_kicker" value="{{ old('models_kicker', $settings->models_kicker) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="models_highlight" class="{{ $labelClass }}">Judul sorotan</label><input id="models_highlight" name="models_highlight" value="{{ old('models_highlight', $settings->models_highlight) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="models_title" class="{{ $labelClass }}">Judul</label><input id="models_title" name="models_title" value="{{ old('models_title', $settings->models_title) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="models_description" class="{{ $labelClass }}">Deskripsi</label><textarea id="models_description" name="models_description" rows="3" required class="{{ $inputClass }}">{{ old('models_description', $settings->models_description) }}</textarea></div>
                        <div class="sm:col-span-2"><label for="models_note" class="{{ $labelClass }}">Catatan stok</label><input id="models_note" name="models_note" value="{{ old('models_note', $settings->models_note) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="models_cta_label" class="{{ $labelClass }}">Teks CTA WhatsApp</label><input id="models_cta_label" name="models_cta_label" value="{{ old('models_cta_label', $settings->models_cta_label) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="models_cta_subtitle" class="{{ $labelClass }}">Keterangan CTA</label><input id="models_cta_subtitle" name="models_cta_subtitle" value="{{ old('models_cta_subtitle', $settings->models_cta_subtitle) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2">@include('admin.landing._image-field', ['label' => 'Gambar lineup', 'databaseField' => 'models_image', 'uploadField' => 'models_image_upload', 'currentPath' => $settings->models_image])</div>
                    </div>
                </section>

                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="testimonial-settings">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><h2 id="testimonial-settings" class="text-lg font-semibold text-gray-900">Testimoni</h2><p class="mt-1 text-sm text-gray-500">Judul section dan komitmen layanan.</p></div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700"><input type="hidden" name="testimonials_enabled" value="0"><input type="checkbox" name="testimonials_enabled" value="1" @checked(old('testimonials_enabled', $settings->testimonials_enabled)) class="rounded border-gray-300 text-green-700 focus:ring-green-600">Tampilkan section</label>
                    </div>
                    <div class="mt-6 grid gap-5">
                        <div><label for="testimonials_title" class="{{ $labelClass }}">Judul</label><input id="testimonials_title" name="testimonials_title" value="{{ old('testimonials_title', $settings->testimonials_title) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="testimonials_description" class="{{ $labelClass }}">Deskripsi</label><textarea id="testimonials_description" name="testimonials_description" rows="3" required class="{{ $inputClass }}">{{ old('testimonials_description', $settings->testimonials_description) }}</textarea></div>
                        <div><label for="service_promises_text" class="{{ $labelClass }}">Komitmen layanan</label><textarea id="service_promises_text" name="service_promises_text" rows="4" required class="{{ $inputClass }}">{{ old('service_promises_text', implode(PHP_EOL, $settings->service_promises ?? [])) }}</textarea><p class="mt-1 text-xs text-gray-500">Satu komitmen per baris.</p></div>
                        @include('admin.landing._image-field', ['label' => 'Watermark testimoni', 'databaseField' => 'testimonials_watermark', 'uploadField' => 'testimonials_watermark_upload', 'currentPath' => $settings->testimonials_watermark])
                    </div>
                </section>

                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="contact-settings">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><h2 id="contact-settings" class="text-lg font-semibold text-gray-900">Kontak & Tentang Kami</h2><p class="mt-1 text-sm text-gray-500">Sumber kontak ini juga digunakan oleh tombol WhatsApp di landing page.</p></div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700"><input type="hidden" name="contact_enabled" value="0"><input type="checkbox" name="contact_enabled" value="1" @checked(old('contact_enabled', $settings->contact_enabled)) class="rounded border-gray-300 text-green-700 focus:ring-green-600">Tampilkan section</label>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div><label for="contact_kicker" class="{{ $labelClass }}">Label kecil</label><input id="contact_kicker" name="contact_kicker" value="{{ old('contact_kicker', $settings->contact_kicker) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="contact_cta_label" class="{{ $labelClass }}">Teks tombol CTA</label><input id="contact_cta_label" name="contact_cta_label" value="{{ old('contact_cta_label', $settings->contact_cta_label) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="contact_title" class="{{ $labelClass }}">Judul</label><input id="contact_title" name="contact_title" value="{{ old('contact_title', $settings->contact_title) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="contact_description" class="{{ $labelClass }}">Deskripsi</label><textarea id="contact_description" name="contact_description" rows="3" required class="{{ $inputClass }}">{{ old('contact_description', $settings->contact_description) }}</textarea></div>
                        <div><label for="whatsapp_number" class="{{ $labelClass }}">Nomor WhatsApp</label><input id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}" required class="{{ $inputClass }}"><p class="mt-1 text-xs text-gray-500">Nomor untuk tautan, contoh 6281280061238.</p></div>
                        <div><label for="whatsapp_label" class="{{ $labelClass }}">Nomor yang ditampilkan</label><input id="whatsapp_label" name="whatsapp_label" value="{{ old('whatsapp_label', $settings->whatsapp_label) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="website_url" class="{{ $labelClass }}">URL website</label><input id="website_url" name="website_url" type="url" value="{{ old('website_url', $settings->website_url) }}" class="{{ $inputClass }}"></div>
                        <div><label for="website_label" class="{{ $labelClass }}">Label website</label><input id="website_label" name="website_label" value="{{ old('website_label', $settings->website_label) }}" class="{{ $inputClass }}"></div>
                        <div><label for="address" class="{{ $labelClass }}">Alamat</label><input id="address" name="address" value="{{ old('address', $settings->address) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="email" class="{{ $labelClass }}">Email</label><input id="email" name="email" type="email" value="{{ old('email', $settings->email) }}" required class="{{ $inputClass }}"></div>
                        <div><label for="business_hours" class="{{ $labelClass }}">Jam operasional</label><input id="business_hours" name="business_hours" value="{{ old('business_hours', $settings->business_hours) }}" required class="{{ $inputClass }}"></div>
                        <div class="sm:col-span-2"><label for="dealer_benefits_text" class="{{ $labelClass }}">Keunggulan dealer</label><textarea id="dealer_benefits_text" name="dealer_benefits_text" rows="4" required class="{{ $inputClass }}">{{ old('dealer_benefits_text', implode(PHP_EOL, $settings->dealer_benefits ?? [])) }}</textarea><p class="mt-1 text-xs text-gray-500">Satu keunggulan per baris.</p></div>
                        <div class="sm:col-span-2">@include('admin.landing._image-field', ['label' => 'Background kontak', 'databaseField' => 'contact_background', 'uploadField' => 'contact_background_upload', 'currentPath' => $settings->contact_background])</div>
                    </div>
                </section>

                <div class="sticky bottom-4 flex justify-end rounded-xl border border-gray-200 bg-white/95 p-4 shadow-lg backdrop-blur">
                    <button type="submit" class="rounded-lg bg-green-700 px-6 py-3 text-sm font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">Simpan Landing Page</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
