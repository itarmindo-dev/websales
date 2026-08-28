@php
    $storedSections = $sale?->sections?->keyBy('id') ?? collect();
    $sectionFormData = old('sections');
    $normalizeSectionLayout = static function (string $type, ?string $layout): string {
        if ($type === 'video') {
            return in_array($layout, ['full_width', 'video_left', 'video_right'], true)
                ? $layout
                : 'full_width';
        }

        if ($type === 'image_text') {
            return in_array($layout, ['media_left', 'media_right', 'full_width'], true)
                ? $layout
                : 'media_left';
        }

        return 'full_width';
    };

    if ($sectionFormData === null) {
        $sectionFormData = ($sale?->sections ?? collect())->map(fn ($section) => [
            'key' => 'section-'.$section->id,
            'id' => $section->id,
            'type' => $section->type,
            'layout' => $normalizeSectionLayout($section->type, $section->layout),
            'eyebrow' => $section->eyebrow,
            'title' => $section->title,
            'body' => $section->body,
            'media_url' => $section->media_url,
            'media_preview_url' => $section->media_path ? $section->mediaUrl() : null,
            'media_name' => $section->media_path ? basename($section->media_path) : null,
            'button_label' => $section->button_label,
            'button_url' => $section->button_url,
            'is_active' => $section->is_active,
            'remove_media' => false,
            '_delete' => false,
        ])->values()->all();
    } else {
        $sectionFormData = collect($sectionFormData)->map(function ($section, $index) use ($storedSections, $normalizeSectionLayout) {
            $storedSection = isset($section['id']) ? $storedSections->get((int) $section['id']) : null;
            $type = $section['type'] ?? 'image_text';

            return [
                'key' => $storedSection ? 'section-'.$storedSection->id : 'restored-'.$index,
                'id' => $section['id'] ?? null,
                'type' => $type,
                'layout' => $normalizeSectionLayout($type, $section['layout'] ?? null),
                'eyebrow' => $section['eyebrow'] ?? '',
                'title' => $section['title'] ?? '',
                'body' => $section['body'] ?? '',
                'media_url' => $section['media_url'] ?? '',
                'media_preview_url' => $storedSection?->media_path ? $storedSection->mediaUrl() : null,
                'media_name' => $storedSection?->media_path ? basename($storedSection->media_path) : null,
                'button_label' => $section['button_label'] ?? '',
                'button_url' => $section['button_url'] ?? '',
                'is_active' => filter_var($section['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'remove_media' => filter_var($section['remove_media'] ?? false, FILTER_VALIDATE_BOOLEAN),
                '_delete' => filter_var($section['_delete'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ];
        })->values()->all();
    }
@endphp

<section class="border-t border-gray-200 pt-8" aria-labelledby="sections-heading" x-data="salesSectionBuilder(@js($sectionFormData))">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 id="sections-heading" class="text-base font-semibold text-gray-900">Susunan konten landing page</h2>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Tambahkan cerita, gambar, atau video. Urutan di bawah sama dengan urutan pada halaman publik.</p>
        </div>
        <button type="button" @click="addSection" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
            + Tambah section
        </button>
    </div>

    <div class="mt-6 space-y-5">
        <template x-if="sections.length === 0">
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center">
                <p class="font-medium text-gray-700">Belum ada section tambahan.</p>
                <p class="mt-1 text-sm text-gray-500">Bagian profil utama dan dokumentasi tetap tampil secara otomatis.</p>
            </div>
        </template>

        <template x-for="(section, index) in sections" :key="section.key">
            <div>
                <input type="hidden" :name="`sections[${index}][id]`" :value="section.id || ''">
                <input type="hidden" :name="`sections[${index}][_delete]`" :value="section._delete ? 1 : 0">

                <template x-if="section._delete">
                    <div class="flex items-center justify-between rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <span>Section <strong x-text="section.title || 'tanpa judul'"></strong> akan dihapus.</span>
                        <button type="button" @click="section._delete = false" class="font-semibold underline underline-offset-2">Batalkan</button>
                    </div>
                </template>

                <template x-if="! section._delete">
                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 bg-white px-4 py-3 sm:px-5">
                            <div class="flex items-center gap-3">
                                <span class="grid h-8 w-8 place-items-center rounded-full bg-green-50 text-sm font-bold text-green-800" x-text="String(index + 1).padStart(2, '0')"></span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900" x-text="section.title || 'Section baru'"></p>
                                    <p class="text-xs text-gray-500" x-text="typeLabel(section.type)"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="move(index, -1)" :disabled="index === 0" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-30" aria-label="Geser section ke atas">&uarr;</button>
                                <button type="button" @click="move(index, 1)" :disabled="index === sections.length - 1" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-30" aria-label="Geser section ke bawah">&darr;</button>
                                <button type="button" @click="removeSection(index)" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-red-700 hover:bg-red-50">Hapus</button>
                            </div>
                        </div>

                        <div class="grid gap-5 p-4 sm:grid-cols-2 sm:p-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-800">Jenis section</label>
                                <select x-model="section.type" @change="normalizeLayout(section)" :name="`sections[${index}][type]`" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                                    <option value="image_text">Gambar + teks</option>
                                    <option value="video">Video</option>
                                    <option value="text">Teks editorial</option>
                                </select>
                            </div>
                            <div x-show="section.type === 'image_text'">
                                <label class="block text-sm font-medium text-gray-800">Posisi gambar</label>
                                <select x-model="section.layout" :disabled="section.type !== 'image_text'" :name="`sections[${index}][layout]`" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                                    <option value="media_left">Gambar kiri</option>
                                    <option value="media_right">Gambar kanan</option>
                                    <option value="full_width">Gambar lebar</option>
                                </select>
                            </div>
                            <div x-show="section.type === 'video'">
                                <label class="block text-sm font-medium text-gray-800">Tata letak video</label>
                                <select x-model="section.layout" :disabled="section.type !== 'video'" :name="`sections[${index}][layout]`" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                                    <option value="full_width">Video lebar</option>
                                    <option value="video_left">Video kiri + teks kanan</option>
                                    <option value="video_right">Teks kiri + video kanan</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Mode kiri dan kanan menampilkan video sebagai card berdampingan dengan deskripsi.</p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-800">Label kecil</label>
                                <input x-model="section.eyebrow" :name="`sections[${index}][eyebrow]`" type="text" maxlength="80" placeholder="Contoh: Solusi armada / 01" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-800">Judul <span class="text-red-600">*</span></label>
                                <input x-model="section.title" :name="`sections[${index}][title]`" type="text" required maxlength="180" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-800">Deskripsi</label>
                                <textarea x-model="section.body" :name="`sections[${index}][body]`" rows="5" maxlength="3000" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600"></textarea>
                            </div>

                            <template x-if="section.type !== 'text'">
                                <div class="contents">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800" x-text="section.type === 'video' ? 'Upload video' : 'Upload gambar'"></label>
                                        <input :name="`sections[${index}][media_file]`" type="file" :accept="section.type === 'video' ? 'video/mp4,video/webm' : 'image/jpeg,image/png,image/webp'" class="mt-2 block w-full text-sm text-gray-600 file:me-3 file:rounded-lg file:border-0 file:bg-green-50 file:px-3 file:py-2 file:font-semibold file:text-green-800 hover:file:bg-green-100">
                                        <p class="mt-1 text-xs text-gray-500" x-text="section.type === 'video' ? 'MP4 atau WebM, maksimal 30 MB.' : 'JPG, PNG, atau WebP, maksimal 30 MB.'"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800" x-text="section.type === 'video' ? 'Atau link video' : 'Atau URL gambar'"></label>
                                        <input x-model="section.media_url" :name="`sections[${index}][media_url]`" type="url" maxlength="1000" :placeholder="section.type === 'video' ? 'YouTube, Vimeo, atau URL video langsung' : 'https://...'" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                                    </div>

                                    <div x-show="section.media_preview_url" class="sm:col-span-2 rounded-lg border border-gray-200 bg-white p-3">
                                        <div class="flex items-center gap-4">
                                            <img x-show="section.type === 'image_text'" :src="section.media_preview_url" alt="Preview media section" class="h-20 w-28 rounded-md object-cover">
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-800" x-text="section.media_name || 'Media saat ini'"></p>
                                                <label class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                                                    <input type="hidden" :name="`sections[${index}][remove_media]`" value="0">
                                                    <input type="checkbox" :name="`sections[${index}][remove_media]`" value="1" x-model="section.remove_media" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                    Hapus media saat ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div>
                                <label class="block text-sm font-medium text-gray-800">Label tombol (opsional)</label>
                                <input x-model="section.button_label" :name="`sections[${index}][button_label]`" type="text" maxlength="80" placeholder="Pelajari lebih lanjut" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800">URL tombol</label>
                                <input x-model="section.button_url" :name="`sections[${index}][button_url]`" type="url" maxlength="1000" placeholder="https://..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <input type="hidden" :name="`sections[${index}][is_active]`" value="0">
                                    <input type="checkbox" :name="`sections[${index}][is_active]`" value="1" x-model="section.is_active" class="rounded border-gray-300 text-green-700 focus:ring-green-600">
                                    Tampilkan section pada halaman publik
                                </label>
                            </div>
                        </div>
                    </article>
                </template>
            </div>
        </template>
    </div>
</section>
