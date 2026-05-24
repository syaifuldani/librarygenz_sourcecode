<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-navy-900 bg-cream-50 h-full">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12">
            <!-- Left Hero Section (Visible on desktop) -->
            <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-navy-800 to-navy-950 p-12 text-cream-100 flex-col justify-between relative overflow-hidden">
                <!-- Decorative radial accent -->
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(232,90,58,0.12),transparent_50%)] pointer-events-none"></div>
                <div class="absolute -left-24 -bottom-24 w-96 h-96 rounded-full bg-navy-700/20 blur-3xl pointer-events-none"></div>
                <div class="absolute right-12 top-1/4 w-72 h-72 rounded-full bg-coral-500/5 blur-3xl pointer-events-none"></div>
                
                <!-- Decorative grid line pattern -->
                <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.012)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.012)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>

                <!-- Top Brand Area -->
                <div class="relative z-10">
                    <a href="/" class="flex items-center space-x-3 group">
                        <!-- Coral Accent Emblem -->
                        <div class="w-10 h-10 rounded-xl bg-coral-500 flex items-center justify-center shadow-lg shadow-coral-500/25 group-hover:scale-105 transition-transform duration-250">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="font-serif text-2xl font-bold tracking-wide text-cream-50">Library<span class="text-coral-400">Genz</span></span>
                    </a>
                </div>

                <!-- Center Copy Area -->
                <div class="my-auto relative z-10 max-w-md">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-coral-500/10 text-coral-300 border border-coral-500/20 mb-6">
                        System Portal v2.0
                    </span>
                    <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-white">
                        Warm Editorial<br>Library Management
                    </h2>
                    <p class="mt-4 text-xs sm:text-sm text-navy-200 leading-relaxed font-sans font-light">
                        Kelola perpustakaan digital modern dengan sistem multi-role terintegrasi. Jelajahi katalog buku secara instan, kelola transaksi secara real-time, dan pantau aktivitas dengan mudah.
                    </p>
                </div>

                <!-- Footer info -->
                <div class="relative z-10 pt-6 border-t border-navy-700/50 flex justify-between items-center text-[10px] text-navy-400 font-sans tracking-wide">
                    <span>&copy; {{ date('Y') }} LibraryGenz Inc.</span>
                    <span>Modern Editorial System</span>
                </div>
            </div>

            <!-- Right Content/Form Panel -->
            <div class="lg:col-span-7 flex flex-col justify-center min-h-screen px-4 sm:px-12 md:px-16 py-12 relative bg-cream-50">
                <!-- Tablet Header (Only visible on tablet/mobile where left hero is hidden) -->
                <div class="lg:hidden flex flex-col items-center mb-8">
                    <a href="/" class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-lg bg-coral-500 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="font-serif text-xl font-bold tracking-wide text-navy-900">Library<span class="text-coral-500">Genz</span></span>
                    </a>
                    <p class="text-[10px] text-navy-500 mt-2 tracking-wider uppercase font-semibold">Warm Editorial System</p>
                </div>

                <!-- Form container wrapper -->
                <div class="w-full max-w-md mx-auto">
                    <div class="bg-white border border-cream-200/80 shadow-xl shadow-navy-900/5 rounded-2xl p-6 sm:p-8 md:p-10 transition duration-200 relative overflow-hidden">
                        <!-- Tiny decorative top accent bar -->
                        <div class="absolute top-0 inset-x-0 h-1 bg-coral-500"></div>
                        
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
