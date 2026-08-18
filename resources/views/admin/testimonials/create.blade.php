<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Tambah Testimoni</h1>
            <p class="mt-1 text-sm text-gray-500">Publikasikan hanya testimoni yang sudah mendapat persetujuan pelanggan.</p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @include('admin.landing._tabs')

            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @csrf
                @include('admin.testimonials._form', ['testimonial' => null, 'submitLabel' => 'Simpan Testimoni'])
            </form>
        </div>
    </div>
</x-app-layout>
