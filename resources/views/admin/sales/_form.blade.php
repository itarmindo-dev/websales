@php
    $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600';
    $labelClass = 'block text-sm font-medium text-gray-800';
@endphp

<div class="space-y-8 p-6 sm:p-8">
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            <p class="font-semibold">Periksa kembali data berikut:</p>
            <ul class="mt-2 list-disc space-y-1 ps-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section aria-labelledby="identity-heading">
        <h2 id="identity-heading" class="text-base font-semibold text-gray-900">Identitas sales</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="{{ $labelClass }}">Nama lengkap <span class="text-red-600">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $sale?->name) }}" required maxlength="255" class="{{ $inputClass }}">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <label for="tagline" class="{{ $labelClass }}">Jabatan atau tagline</label>
                <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $sale?->tagline) }}" maxlength="255" placeholder="Contoh: HINO Sales Executive" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="specialties" class="{{ $labelClass }}">Spesialisasi</label>
                <input id="specialties" name="specialties" type="text" value="{{ old('specialties', $sale?->specialties) }}" maxlength="500" placeholder="Contoh: HINO 300 dan HINO 500" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-2">
                <label for="slogan" class="{{ $labelClass }}">Slogan</label>
                <input id="slogan" name="slogan" type="text" value="{{ old('slogan', $sale?->slogan) }}" maxlength="255" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-2">
                <label for="bio" class="{{ $labelClass }}">Biografi singkat</label>
                <textarea id="bio" name="bio" rows="5" maxlength="1000" class="{{ $inputClass }}">{{ old('bio', $sale?->bio) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Maksimal 1.000 karakter.</p>
            </div>
        </div>
    </section>

    <section class="border-t border-gray-200 pt-8" aria-labelledby="contact-heading">
        <h2 id="contact-heading" class="text-base font-semibold text-gray-900">Kontak</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="whatsapp_number" class="{{ $labelClass }}">Nomor WhatsApp</label>
                <input id="whatsapp_number" name="whatsapp_number" type="tel" inputmode="tel" value="{{ old('whatsapp_number', $sale?->whatsapp_number ?? $sale?->whatsapp) }}" maxlength="20" placeholder="081280061238" class="{{ $inputClass }}">
                <p class="mt-1 text-xs text-gray-500">Awalan 0 akan otomatis diubah menjadi kode Indonesia 62.</p>
            </div>
            <div>
                <label for="phone" class="{{ $labelClass }}">Nomor telepon lain</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone', $sale?->phone) }}" maxlength="30" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="facebook_link" class="{{ $labelClass }}">URL Facebook</label>
                <input id="facebook_link" name="facebook_link" type="url" value="{{ old('facebook_link', $sale?->facebook_link ?? $sale?->facebook) }}" maxlength="255" placeholder="https://facebook.com/..." class="{{ $inputClass }}">
            </div>
            <div>
                <label for="instagram_link" class="{{ $labelClass }}">URL Instagram</label>
                <input id="instagram_link" name="instagram_link" type="url" value="{{ old('instagram_link', $sale?->instagram_link ?? $sale?->instagram) }}" maxlength="255" placeholder="https://instagram.com/..." class="{{ $inputClass }}">
            </div>
        </div>
    </section>

    <section class="border-t border-gray-200 pt-8" aria-labelledby="media-heading">
        <h2 id="media-heading" class="text-base font-semibold text-gray-900">Foto</h2>
        <div class="mt-4 space-y-6">
            <div>
                <label for="photo" class="{{ $labelClass }}">Foto profil</label>
                @if ($sale?->photo)
                    <div class="mt-2 flex items-center gap-4">
                        <img src="{{ Storage::disk('public')->url($sale->photo) }}" alt="Foto {{ $sale->name }}" class="h-24 w-24 rounded-lg object-cover">
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remove_photo" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            Hapus foto saat ini
                        </label>
                    </div>
                @endif
                <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-sm text-gray-600 file:me-4 file:rounded-lg file:border-0 file:bg-green-50 file:px-4 file:py-2.5 file:font-semibold file:text-green-800 hover:file:bg-green-100">
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
            </div>

            @if ($sale?->documentation_photos)
                <fieldset>
                    <legend class="{{ $labelClass }}">Dokumentasi saat ini</legend>
                    <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($sale->documentation_photos as $documentationPhoto)
                            <label class="overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                                <img src="{{ Storage::disk('public')->url($documentationPhoto) }}" alt="Dokumentasi {{ $sale->name }}" class="h-32 w-full object-cover">
                                <span class="flex items-center gap-2 p-3 text-sm text-gray-700">
                                    <input type="checkbox" name="remove_documentation_photos[]" value="{{ $documentationPhoto }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    Hapus foto
                                </span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endif

            <div>
                <label for="documentation_photos" class="{{ $labelClass }}">Tambah foto dokumentasi</label>
                <input id="documentation_photos" name="documentation_photos[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-gray-600 file:me-4 file:rounded-lg file:border-0 file:bg-green-50 file:px-4 file:py-2.5 file:font-semibold file:text-green-800 hover:file:bg-green-100">
                <p class="mt-1 text-xs text-gray-500">Maksimal 10 file per unggahan, masing-masing maksimal 2 MB.</p>
            </div>
        </div>
    </section>
</div>

<div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end sm:px-8">
    <a href="{{ route('admin.sales.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">{{ $submitLabel }}</button>
</div>
