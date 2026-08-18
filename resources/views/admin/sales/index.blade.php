<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Profil Sales</h1>
                <p class="mt-1 text-sm text-gray-500">Setiap profil memiliki halaman publik yang dapat dibagikan.</p>
            </div>
            <a href="{{ route('admin.sales.create') }}" class="inline-flex items-center justify-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                Tambah Profil
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-8rem)] bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @if ($sales->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <h2 class="font-semibold text-gray-900">Belum ada profil sales</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">Tambahkan data sales untuk membuat halaman kontak publik dengan tautan WhatsApp dan dokumentasi penyerahan unit.</p>
                        <a href="{{ route('admin.sales.create') }}" class="mt-5 inline-flex rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-800">Tambah Profil Pertama</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-600">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Sales</th>
                                    <th scope="col" class="px-6 py-3">Kontak</th>
                                    <th scope="col" class="px-6 py-3">Akun sales</th>
                                    <th scope="col" class="px-6 py-3">Halaman publik</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($sale->photo)
                                                    <img src="{{ $sale->mediaUrl($sale->photo) }}" alt="Foto {{ $sale->name }}" class="h-11 w-11 rounded-full object-cover">
                                                @else
                                                    <span class="grid h-11 w-11 place-items-center rounded-full bg-green-50 font-semibold text-green-800">{{ Str::upper(Str::substr($sale->name, 0, 1)) }}</span>
                                                @endif
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $sale->name }}</p>
                                                    <p class="mt-0.5 text-xs text-gray-500">Diperbarui {{ $sale->updated_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            <p>{{ $sale->whatsapp_number ? '+'.$sale->whatsapp_number : 'WhatsApp belum diisi' }}</p>
                                            @if ($sale->phone)
                                                <p class="mt-1 text-xs text-gray-500">{{ $sale->phone }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($sale->user)
                                                <p class="text-sm text-gray-700">{{ $sale->user->email }}</p>
                                                <span class="mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $sale->user->is_sales ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                    {{ $sale->user->is_sales ? 'Dapat login' : 'Dinonaktifkan' }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-500">Belum terhubung</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('sales.profile', $sale->slug) }}" target="_blank" rel="noopener" class="font-medium text-green-700 hover:text-green-900 hover:underline">
                                                /sales/{{ $sale->slug }}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.sales.edit', $sale) }}" class="font-medium text-blue-700 hover:text-blue-900">Edit</a>
                                                <form method="POST" action="{{ route('admin.sales.destroy', $sale) }}" onsubmit="return confirm({{ Js::from('Hapus profil '.$sale->name.' beserta semua fotonya?') }})">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-700 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($sales->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">
                            {{ $sales->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
