<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Sales Profile') }}
            </h2>
            <a href="{{ route('admin.sales.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Sales Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Photo</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Kontak</th>
                                <th scope="col" class="px-6 py-3">Link URL</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        @if($sale->photo)
                                            <img src="{{ asset('storage/'.$sale->photo) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">?</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $sale->name }}</td>
                                    <td class="px-6 py-4">
                                        WA: {{ $sale->whatsapp }}<br>
                                        Telp: {{ $sale->phone }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('sales.profile', $sale->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                                            /sales/{{ $sale->slug }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="{{ route('admin.sales.edit', $sale->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Belum ada data sales.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
