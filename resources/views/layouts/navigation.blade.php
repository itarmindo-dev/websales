@php
    $currentUser = Auth::user();
    $currentSalesProfile = $currentUser->is_sales ? $currentUser->salesProfile : null;
@endphp

<nav x-data="{ open: false }" class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex min-w-0">
                <a href="{{ $currentUser->is_admin ? route('dashboard') : route('sales.self.edit') }}" class="flex shrink-0 items-center" aria-label="Panel Armindo Perkasa">
                    <x-application-logo class="h-9 w-32" />
                </a>

                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    @if ($currentUser->is_admin)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.*')">Profil Sales</x-nav-link>
                        <x-nav-link :href="route('admin.landing.edit')" :active="request()->routeIs('admin.landing.*', 'admin.truck-models.*', 'admin.testimonials.*')">Landing Page</x-nav-link>
                    @else
                        <x-nav-link :href="route('sales.self.edit')" :active="request()->routeIs('sales.self.*')">Profil Saya</x-nav-link>
                        @if ($currentSalesProfile)
                            <x-nav-link :href="route('sales.profile', $currentSalesProfile->slug)" :active="false" target="_blank" rel="noopener">Halaman Publik</x-nav-link>
                        @endif
                    @endif
                    <x-nav-link :href="route('home')" :active="false" target="_blank" rel="noopener">
                        Lihat Website
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden items-center sm:flex">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Pengaturan Akun</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button
                    type="button"
                    @click="open = !open"
                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-600"
                    :aria-expanded="open"
                    aria-controls="admin-mobile-menu"
                >
                    <span class="sr-only">Buka navigasi</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="admin-mobile-menu" x-show="open" x-cloak class="border-t border-gray-100 sm:hidden">
        <div class="space-y-1 py-2">
            @if ($currentUser->is_admin)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.*')">Profil Sales</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.landing.edit')" :active="request()->routeIs('admin.landing.*', 'admin.truck-models.*', 'admin.testimonials.*')">Landing Page</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('sales.self.edit')" :active="request()->routeIs('sales.self.*')">Profil Saya</x-responsive-nav-link>
                @if ($currentSalesProfile)
                    <x-responsive-nav-link :href="route('sales.profile', $currentSalesProfile->slug)" target="_blank" rel="noopener">Halaman Publik</x-responsive-nav-link>
                @endif
            @endif
            <x-responsive-nav-link :href="route('home')" target="_blank" rel="noopener">Lihat Website</x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 pb-2 pt-4">
            <div class="px-4">
                <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Pengaturan Akun</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
