<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola halaman publik tim sales Armindo Perkasa.</p>
            </div>
            <a href="{{ route('admin.sales.create') }}" class="mt-3 inline-flex items-center justify-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 sm:mt-0">
                Tambah Profil Sales
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 sm:grid-cols-3" aria-label="Ringkasan profil sales">
                <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Total profil sales</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $salesCount }}</p>
                </article>
                <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Memiliki foto profil</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $salesWithPhotoCount }}</p>
                </article>
                <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Kontak WhatsApp aktif</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $salesWithWhatsappCount }}</p>
                </article>
            </section>

            <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                    <div>
                        <h2 class="font-semibold text-gray-900">Profil terbaru</h2>
                        <p class="mt-1 text-sm text-gray-500">Lima profil yang terakhir ditambahkan atau diperbarui.</p>
                    </div>
                    <a href="{{ route('admin.sales.index') }}" class="text-sm font-semibold text-green-700 hover:text-green-900">Lihat semua</a>
                </div>

                @if ($recentSales->isEmpty())
                    <div class="px-5 py-12 text-center">
                        <p class="font-medium text-gray-800">Belum ada profil sales.</p>
                        <p class="mt-1 text-sm text-gray-500">Tambahkan profil pertama untuk membuat halaman sales publik.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($recentSales as $sale)
                            <li class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex min-w-0 items-center gap-3">
                                    @if ($sale->photo)
                                        <img src="{{ $sale->mediaUrl($sale->photo) }}" alt="" class="h-11 w-11 shrink-0 rounded-full object-cover">
                                    @else
                                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-green-50 font-semibold text-green-800">{{ Str::upper(Str::substr($sale->name, 0, 1)) }}</span>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-gray-900">{{ $sale->name }}</p>
                                        <p class="truncate text-sm text-gray-500">/sales/{{ $sale->slug }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 text-sm font-medium">
                                    <a href="{{ route('sales.profile', $sale->slug) }}" target="_blank" rel="noopener" class="text-gray-600 hover:text-gray-900">Buka halaman</a>
                                    <a href="{{ route('admin.sales.edit', $sale) }}" class="text-green-700 hover:text-green-900">Edit</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
