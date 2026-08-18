<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Profil Sales Saya</h1>
                <p class="mt-1 text-sm text-gray-500">Data yang disimpan langsung ditampilkan pada halaman publik Anda.</p>
            </div>
            @if ($sale)
                <a href="{{ route('sales.profile', $sale->slug) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Lihat Halaman Publik</a>
            @endif
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="status">{{ session('success') }}</div>
            @endif

            @unless ($sale)
                <div class="mb-5 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                    Profil Anda belum dipublikasikan. Lengkapi nama dan data yang diperlukan, lalu tekan Simpan Profil.
                </div>
            @endunless

            <form method="POST" action="{{ route('sales.self.update') }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @csrf
                @method('PATCH')
                @include('admin.sales._form', [
                    'sale' => $sale,
                    'submitLabel' => $sale ? 'Simpan Perubahan' : 'Simpan Profil',
                    'cancelRoute' => route('sales.self.edit'),
                    'showAccountFields' => false,
                ])
            </form>
        </div>
    </div>
</x-app-layout>
