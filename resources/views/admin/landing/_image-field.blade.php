<div>
    <label for="{{ $uploadField }}" class="block text-sm font-medium text-gray-800">{{ $label }}</label>
    @if ($currentPath)
        <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-center">
            <img src="{{ asset($currentPath) }}" alt="Pratinjau {{ $label }}" class="h-28 w-44 rounded-lg border border-gray-200 bg-gray-50 object-cover">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="remove_{{ $databaseField }}" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                Hapus gambar saat ini
            </label>
        </div>
    @endif
    <input id="{{ $uploadField }}" name="{{ $uploadField }}" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-sm text-gray-600 file:me-4 file:rounded-lg file:border-0 file:bg-green-50 file:px-4 file:py-2.5 file:font-semibold file:text-green-800 hover:file:bg-green-100">
    <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP. Maksimal 5 MB.</p>
</div>
