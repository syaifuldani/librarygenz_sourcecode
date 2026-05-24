<nav class="sticky top-0 z-40 backdrop-blur-md bg-cream-50/90 border-b border-cream-300/60 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 transition-colors">
    <!-- Left Section: Mobile Menu Button & Dynamic Title -->
    <div class="flex items-center space-x-3 lg:space-x-0 min-w-0">
        <!-- Mobile Sidebar Hamburger Toggle -->
        <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-navy-500 hover:text-navy-800 hover:bg-cream-200/50 focus:outline-none focus:ring-2 focus:ring-coral-500 transition-colors">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Current Section Name -->
        <h1 class="font-serif text-sm sm:text-base md:text-lg font-bold text-navy-900 truncate">
            @if(request()->routeIs('*dashboard'))
                Ringkasan Utama
            @elseif(request()->routeIs('books.*'))
                Katalog Buku
            @elseif(request()->routeIs('categories.*'))
                Kategori Buku
            @elseif(request()->routeIs('borrowings.*') || request()->routeIs('borrowings'))
                Manajemen Peminjaman
            @elseif(request()->routeIs('fines.*') || request()->routeIs('fines'))
                Denda & Keterlambatan
            @elseif(request()->routeIs('reports.*') || request()->routeIs('reports'))
                Laporan Analitik
            @elseif(request()->routeIs('profile.*') || request()->routeIs('profile'))
                Pengaturan Akun
            @elseif(request()->routeIs('admin.users.*') || request()->routeIs('admin.users'))
                Manajemen Pengguna
            @else
                LibraryGenz
            @endif
        </h1>
    </div>

    <!-- Center Section: Search Bar -->
    <div class="hidden md:flex flex-1 justify-center max-w-lg px-4">
        <div class="relative w-full max-w-xs sm:max-w-sm lg:max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="h-4 w-4 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Cari buku, penulis, kategori..." class="w-full pl-9 pr-4 py-1.5 text-xs bg-cream-100/60 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-all">
        </div>
    </div>

    <!-- Right Section: Notification & User Dropdown -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        <!-- Notification Bell (Visual Accent) -->
        <button type="button" class="p-2 rounded-lg text-navy-500 hover:text-navy-800 hover:bg-cream-200/50 relative focus:outline-none transition-colors">
            <span class="sr-only">View notifications</span>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="absolute top-2 right-2 block h-2 w-2 rounded-full bg-coral-500 ring-2 ring-cream-50"></span>
        </button>

        <!-- Divider -->
        <div class="h-5 w-px bg-cream-300"></div>

        <!-- User Settings Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-1.5 border border-cream-300 text-xs font-semibold rounded-lg text-navy-700 bg-cream-100/50 hover:bg-cream-200/50 hover:text-navy-900 focus:outline-none transition ease-in-out duration-150">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 shrink-0"></span>
                    <div class="max-w-[70px] sm:max-w-[120px] truncate">{{ Auth::user()->name }}</div>
                    <svg class="ms-1.5 fill-current h-3.5 w-3.5 text-navy-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="block px-4 py-2 text-[10px] text-navy-400 uppercase tracking-wider border-b border-cream-200">
                    Akun Anda
                </div>

                <x-dropdown-link :href="route('profile.edit')" class="text-xs text-navy-700 hover:bg-cream-100 hover:text-navy-900">
                    {{ __('Edit Profil') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-xs text-coral-600 hover:bg-coral-50 hover:text-coral-800">
                        {{ __('Keluar Sesi') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
