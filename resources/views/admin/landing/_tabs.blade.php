<nav class="mb-6 flex flex-wrap gap-2" aria-label="Pengelolaan landing page">
    <a href="{{ route('admin.landing.edit') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.landing.*') ? 'bg-green-700 text-white' : 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">Konten Utama</a>
    <a href="{{ route('admin.truck-models.index') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.truck-models.*') ? 'bg-green-700 text-white' : 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">Model Truk</a>
    <a href="{{ route('admin.testimonials.index') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.testimonials.*') ? 'bg-green-700 text-white' : 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">Testimoni</a>
</nav>
