<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Tambah Profil Sales</h1>
            <p class="mt-1 text-sm text-gray-500">Isi informasi yang benar-benar akan ditampilkan pada halaman publik.</p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.sales.store') }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @csrf
                @include('admin.sales._form', [
                    'sale' => null,
                    'submitLabel' => 'Simpan Profil',
                    'cancelRoute' => route('admin.sales.index'),
                    'showAccountFields' => true,
                ])
            </form>
        </div>
    </div>
</x-app-layout>
