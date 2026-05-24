<!-- Desktop Sidebar (Hidden on mobile) -->
<aside class="hidden lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 lg:flex lg:flex-col lg:w-64 bg-navy-800 border-r border-navy-700 text-cream-100">
    <div class="h-16 flex items-center px-6 border-b border-navy-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <!-- Coral Accent Emblem -->
            <div class="w-8 h-8 rounded-lg bg-coral-500 flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="font-serif text-xl font-bold tracking-wide text-cream-50">Library<span class="text-coral-400">Genz</span></span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-7 overflow-y-auto sidebar-scrollbar">
        @if(Auth::user()->isAdmin())
            <!-- ADMIN DESKTOP MENU -->
            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Dashboard</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('*dashboard') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('*dashboard') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Ringkasan Utama
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Layanan Katalog</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('books.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('books.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('books.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Daftar Buku
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('categories.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Kategori Buku
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Aktivitas</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('borrowings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('borrowings.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Peminjaman
                            @php
                                $pendingCount = \App\Models\Borrowing::where('status', 'requested')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="ml-auto inline-block py-0.5 px-2 text-xs font-semibold rounded-full bg-coral-500/20 text-coral-300">{{ $pendingCount }} Baru</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fines.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('fines.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('fines.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Denda & Keterlambatan
                            @php
                                $unpaidCount = \App\Models\Fine::where('status', 'unpaid')->count();
                            @endphp
                            @if($unpaidCount > 0)
                                <span class="ml-auto inline-block py-0.5 px-2 text-xs font-semibold rounded-full bg-coral-500/20 text-coral-300">{{ $unpaidCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('reports.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Laporan Analitik
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Sistem</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Manajemen Pengguna
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.activity-logs') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.activity-logs') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('admin.activity-logs') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Log Aktivitas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('admin.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan Sistem
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Akun Saya</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.edit') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.settings') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Pengaturan Akun
                        </a>
                    </li>
                </ul>
            </div>
        @elseif(Auth::user()->isLibrarian())
            <!-- LIBRARIAN DESKTOP MENU -->
            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Dashboard</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('*dashboard') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('*dashboard') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Ringkasan Utama
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Layanan Katalog</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('books.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('books.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('books.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Daftar Buku
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('categories.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Kategori Buku
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Aktivitas</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('borrowings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('borrowings.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Peminjaman
                            @php
                                $pendingCount = \App\Models\Borrowing::where('status', 'requested')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="ml-auto inline-block py-0.5 px-2 text-xs font-semibold rounded-full bg-coral-500/20 text-coral-300">{{ $pendingCount }} Baru</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fines.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('fines.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('fines.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Denda & Keterlambatan
                            @php
                                $unpaidCount = \App\Models\Fine::where('status', 'unpaid')->count();
                            @endphp
                            @if($unpaidCount > 0)
                                <span class="ml-auto inline-block py-0.5 px-2 text-xs font-semibold rounded-full bg-coral-500/20 text-coral-300">{{ $unpaidCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('reports.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Laporan Analitik
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Sistem</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('users.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('users.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Daftar Pengguna
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Akun Saya</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.edit') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.settings') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Pengaturan Akun
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <!-- MEMBER DESKTOP MENU -->
            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Dashboard</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('*dashboard') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('*dashboard') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Ringkasan Utama
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Layanan Katalog</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('books.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('books.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('books.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Daftar Buku
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Aktivitas</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('borrowings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('borrowings.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Peminjaman Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fines.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('fines.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('fines.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Denda Saya
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Akun Saya</span>
                <ul class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.edit') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.settings') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Pengaturan Akun
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
</aside>

<!-- Mobile Sidebar Off-Canvas Drawer (Shown only when sidebarOpen is true) -->
<div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-navy-950/70 backdrop-blur-sm"></div>

    <!-- Slide Panel Container -->
    <div class="fixed inset-y-0 left-0 flex max-w-xs w-full">
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-navy-800 border-r border-navy-700 text-cream-100">

            <!-- Close Drawer Button -->
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Drawer Header Logo -->
            <div class="h-16 flex items-center px-6 border-b border-navy-700">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-coral-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="font-serif text-xl font-bold tracking-wide text-cream-50">Library<span class="text-coral-400">Genz</span></span>
                </a>
            </div>

            <!-- Drawer Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-7 overflow-y-auto sidebar-scrollbar">
                @if(Auth::user()->isAdmin())
                    <!-- ADMIN MOBILE MENU -->
                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Dashboard</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('*dashboard') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('*dashboard') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Ringkasan Utama
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Layanan Katalog</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('books.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('books.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('books.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Daftar Buku
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('categories.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Kategori Buku
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Aktivitas</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('borrowings.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('borrowings.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Peminjaman
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fines.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('fines.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('fines.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Denda & Keterlambatan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('reports.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Laporan Analitik
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Sistem</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('admin.users.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Manajemen Pengguna
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.activity-logs') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.activity-logs') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('admin.activity-logs') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    Log Aktivitas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('admin.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Pengaturan Sistem
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Akun Saya</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.edit') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.settings') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Pengaturan Akun
                                </a>
                            </li>
                        </ul>
                    </div>
                @elseif(Auth::user()->isLibrarian())
                    <!-- LIBRARIAN MOBILE MENU -->
                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Dashboard</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('*dashboard') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('*dashboard') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Ringkasan Utama
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Layanan Katalog</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('books.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('books.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('books.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Daftar Buku
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('categories.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Kategori Buku
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Aktivitas</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('borrowings.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('borrowings.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Peminjaman
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fines.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('fines.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('fines.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Denda & Keterlambatan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('reports.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Laporan Analitik
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Sistem</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('users.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('users.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Daftar Pengguna
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Akun Saya</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.edit') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.settings') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Pengaturan Akun
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- MEMBER MOBILE MENU -->
                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Dashboard</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('*dashboard') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('*dashboard') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Ringkasan Utama
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Layanan Katalog</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('books.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('books.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('books.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Daftar Buku
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Aktivitas</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('borrowings.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('borrowings.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Peminjaman Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fines.index') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('fines.*') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('fines.*') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Denda Saya
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <span class="px-2 text-xs font-semibold tracking-wider text-navy-400 uppercase">Akun Saya</span>
                        <ul class="mt-2 space-y-1">
                            <li>
                                <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.edit') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.settings') }}" @click="sidebarOpen = false" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('profile.settings') ? 'bg-navy-900 text-coral-400 border-r-4 border-coral-500' : 'text-navy-300 hover:bg-navy-700/50 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5 shrink-0 transition-colors {{ request()->routeIs('profile.settings') ? 'text-coral-400' : 'text-navy-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Pengaturan Akun
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </nav>
        </div>
    </div>
</div>
