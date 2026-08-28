<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Edit Profil Sales</h1>
            <p class="mt-1 text-sm text-gray-500">Perubahan langsung diterapkan pada halaman publik {{ $sale->name }}.</p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.sales.update', $sale) }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @csrf
                @method('PATCH')
                @include('admin.sales._form', [
                    'sale' => $sale,
                    'submitLabel' => 'Simpan Perubahan',
                    'cancelRoute' => route('admin.sales.index'),
                    'showAccountFields' => true,
                ])
            </form>
        </div>
    </div>
</x-app-layout>
