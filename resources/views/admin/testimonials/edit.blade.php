<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Edit Testimoni</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui testimoni {{ $testimonial->name }}.</p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @include('admin.landing._tabs')

            <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @csrf
                @method('PATCH')
                @include('admin.testimonials._form', ['testimonial' => $testimonial, 'submitLabel' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
</x-app-layout>
