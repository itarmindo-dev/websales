@php
    $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600';
@endphp

<div class="space-y-6 p-6 sm:p-8">
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            <ul class="list-disc space-y-1 ps-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-800">Nama pelanggan <span class="text-red-600">*</span></label>
            <input id="name" name="name" value="{{ old('name', $testimonial?->name) }}" required class="{{ $inputClass }}">
        </div>
        <div>
            <label for="company" class="block text-sm font-medium text-gray-800">Perusahaan</label>
            <input id="company" name="company" value="{{ old('company', $testimonial?->company) }}" class="{{ $inputClass }}">
        </div>
        <div class="sm:col-span-2">
            <label for="quote" class="block text-sm font-medium text-gray-800">Isi testimoni <span class="text-red-600">*</span></label>
            <textarea id="quote" name="quote" rows="5" required class="{{ $inputClass }}">{{ old('quote', $testimonial?->quote) }}</textarea>
        </div>
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-800">Urutan tampil</label>
            <input id="sort_order" name="sort_order" type="number" min="0" max="999" value="{{ old('sort_order', $testimonial?->sort_order ?? 0) }}" required class="{{ $inputClass }}">
        </div>
        <div class="space-y-3 pt-6">
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                <input type="hidden" name="is_verified" value="0">
                <input type="checkbox" name="is_verified" value="1" @checked(old('is_verified', $testimonial?->is_verified ?? false)) class="rounded border-gray-300 text-green-700 focus:ring-green-600">
                Tampilkan tanda terverifikasi
            </label>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial?->is_active ?? true)) class="rounded border-gray-300 text-green-700 focus:ring-green-600">
                Tampilkan di landing page
            </label>
        </div>
        <div class="sm:col-span-2">
            <label for="photo" class="block text-sm font-medium text-gray-800">Foto pelanggan</label>
            @if ($testimonial?->photo)
                <div class="mt-2 flex items-center gap-4">
                    <img src="{{ asset($testimonial->photo) }}" alt="Foto {{ $testimonial->name }}" class="h-20 w-20 rounded-full object-cover">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="remove_photo" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        Hapus foto
                    </label>
                </div>
            @endif
            <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-sm text-gray-600 file:me-4 file:rounded-lg file:border-0 file:bg-green-50 file:px-4 file:py-2.5 file:font-semibold file:text-green-800 hover:file:bg-green-100">
            <p class="mt-1 text-xs text-gray-500">Maksimal 2 MB.</p>
        </div>
    </div>
</div>

<div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end sm:px-8">
    <a href="{{ route('admin.testimonials.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
    <button class="rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800">{{ $submitLabel }}</button>
</div>
