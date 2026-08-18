<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Testimoni</h1>
                <p class="mt-1 text-sm text-gray-500">Testimoni aktif ditampilkan berdasarkan nomor urut terkecil.</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" class="rounded-lg bg-green-700 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-green-800">Tambah Testimoni</a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @include('admin.landing._tabs')

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="status">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @if ($testimonials->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <h2 class="font-semibold text-gray-900">Belum ada testimoni</h2>
                        <p class="mt-2 text-sm text-gray-500">Tambahkan pengalaman pelanggan yang sudah disetujui untuk dipublikasikan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-600">
                                <tr>
                                    <th class="px-6 py-3">Urutan</th>
                                    <th class="px-6 py-3">Pelanggan</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($testimonials as $testimonial)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold text-gray-700">{{ $testimonial->sort_order }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex min-w-[300px] items-center gap-3">
                                                @if ($testimonial->photo)
                                                    <img src="{{ asset($testimonial->photo) }}" alt="" class="h-11 w-11 rounded-full object-cover">
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $testimonial->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $testimonial->company ?: 'Perusahaan tidak dicantumkan' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $testimonial->is_active ? 'Tampil' : 'Disembunyikan' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="font-medium text-blue-700 hover:text-blue-900">Edit</a>
                                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm({{ Js::from('Hapus testimoni '.$testimonial->name.'?') }})">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="font-medium text-red-700 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($testimonials->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">{{ $testimonials->links() }}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
