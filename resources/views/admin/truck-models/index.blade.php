<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Model Truk</h1>
                <p class="mt-1 text-sm text-gray-500">Model aktif ditampilkan berdasarkan nomor urut terkecil.</p>
            </div>
            <a href="{{ route('admin.truck-models.create') }}" class="rounded-lg bg-green-700 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-green-800">Tambah Model</a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @include('admin.landing._tabs')
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="status">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @if ($truckModels->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <h2 class="font-semibold text-gray-900">Belum ada model truk</h2>
                        <p class="mt-2 text-sm text-gray-500">Tambahkan model yang ingin ditampilkan pada landing page.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-600">
                                <tr>
                                    <th class="px-6 py-3">Urutan</th>
                                    <th class="px-6 py-3">Model</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($truckModels as $truckModel)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold text-gray-700">{{ $truckModel->sort_order }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex min-w-[260px] items-center gap-3">
                                                @if ($truckModel->image)
                                                    <img src="{{ asset($truckModel->image) }}" alt="" class="h-14 w-20 rounded-lg bg-gray-50 object-contain">
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $truckModel->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $truckModel->series ?: 'Tanpa nama seri' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $truckModel->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $truckModel->is_active ? 'Tampil' : 'Disembunyikan' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.truck-models.edit', $truckModel) }}" class="font-medium text-blue-700 hover:text-blue-900">Edit</a>
                                                <form method="POST" action="{{ route('admin.truck-models.destroy', $truckModel) }}" onsubmit="return confirm({{ Js::from('Hapus model '.$truckModel->name.'?') }})">
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
                    @if ($truckModels->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">{{ $truckModels->links() }}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
