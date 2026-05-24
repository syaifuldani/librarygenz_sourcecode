<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LibraryGenz — Warm Editorial Library Management</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-cream-50 text-navy-900 selection:bg-coral-200 selection:text-coral-900">

    <!-- Global Layout Wrapper -->
    <div class="min-h-screen flex flex-col justify-between">
        
        <!-- Header / Navigation Bar -->
        <header class="border-b border-cream-300/60 bg-cream-50/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 h-16 flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-coral-500 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="font-serif text-xl font-bold tracking-wide text-navy-800">Library<span class="text-coral-500">Genz</span></span>
                </a>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center space-x-8 text-xs font-semibold uppercase tracking-wider text-navy-600">
                    <a href="#fitur" class="hover:text-coral-500 transition-colors">Fitur Utama</a>
                    <a href="#statistik" class="hover:text-coral-500 transition-colors">Statistik</a>
                    <a href="#tentang" class="hover:text-coral-500 transition-colors">Tentang Kami</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-navy-700 hover:text-navy-900 px-3 py-2 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-coral-500 hover:bg-coral-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                        Daftar Anggota
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1">
            
            <!-- 1. Hero Section -->
            <section class="py-20 sm:py-28 relative overflow-hidden bg-gradient-to-b from-cream-100/30 to-cream-50">
                <div class="max-w-7xl mx-auto px-6 sm:px-8 text-center relative z-10">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xxs font-bold bg-coral-50 text-coral-600 border border-coral-200/50 uppercase tracking-widest mb-6">
                        Era Baru Manajemen Perpustakaan
                    </span>
                    <h1 class="font-serif text-4xl sm:text-6xl font-bold tracking-tight text-navy-950 max-w-4xl mx-auto leading-[1.15]">
                        Temukan Kebijaksanaan Lewat Lembaran Halaman <span class="text-coral-500 italic">LibraryGenz</span>
                    </h1>
                    <p class="mt-6 text-sm sm:text-base text-navy-600 max-w-2xl mx-auto leading-relaxed">
                        Kami menghadirkan kembali kecintaan membaca dengan visual modern, manajemen transparan, dan akses peminjaman buku instan. Mulai jelajahi koleksi kami sekarang.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-8 py-3 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200 text-center">
                            Gabung Menjadi Anggota
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto border border-cream-300 bg-white hover:bg-cream-100/50 text-navy-800 px-8 py-3 rounded-lg text-sm font-bold transition-all duration-200 text-center">
                            Masuk Ke Pustaka &rarr;
                        </a>
                    </div>
                </div>
                <!-- Artistic Background Accent Elements -->
                <div class="absolute -top-40 -left-40 w-96 h-96 bg-coral-100/30 rounded-full blur-3xl"></div>
                <div class="absolute -right-40 bottom-0 w-96 h-96 bg-navy-200/20 rounded-full blur-3xl"></div>
            </section>

            <!-- 2. Feature Highlights -->
            <section id="fitur" class="py-16 sm:py-24 border-y border-cream-300/40 bg-white">
                <div class="max-w-7xl mx-auto px-6 sm:px-8">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-navy-950">
                            Fitur Terbaik untuk Pengalaman Terbaik
                        </h2>
                        <p class="mt-3 text-xs sm:text-sm text-navy-500">
                            Nikmati efisiensi operasional dan kenyamanan literatur dengan visual yang menawan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-12">
                        <!-- Feature 1 -->
                        <div class="flex flex-col p-6 rounded-xl border border-cream-300/60 hover:shadow-sm transition duration-200 bg-cream-50/20">
                            <div class="w-10 h-10 rounded-lg bg-navy-800 text-cream-100 flex items-center justify-center mb-6">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="font-serif text-lg font-bold text-navy-950">E-Katalog Interaktif</h3>
                            <p class="mt-3 text-xs text-navy-600 leading-relaxed">
                                Jelajahi ratusan buku dengan pencarian instan, filter kategori cerdas, dan visual kover minimalis yang premium.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="flex flex-col p-6 rounded-xl border border-cream-300/60 hover:shadow-sm transition duration-200 bg-cream-50/20">
                            <div class="w-10 h-10 rounded-lg bg-coral-500 text-white flex items-center justify-center mb-6 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <h3 class="font-serif text-lg font-bold text-navy-950">Peminjaman Alur Mandiri</h3>
                            <p class="mt-3 text-xs text-navy-600 leading-relaxed">
                                Ajukan peminjaman buku dalam satu ketukan. Sistem kami mengotomatisasi verifikasi antrean secara real-time.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="flex flex-col p-6 rounded-xl border border-cream-300/60 hover:shadow-sm transition duration-200 bg-cream-50/20">
                            <div class="w-10 h-10 rounded-lg bg-navy-800 text-cream-100 flex items-center justify-center mb-6">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-serif text-lg font-bold text-navy-950">Aturan Denda Transparan</h3>
                            <p class="mt-3 text-xs text-navy-600 leading-relaxed">
                                Pantau keterlambatan pengembalian dan kalkulasi denda otomatis flat Rp2.000 / hari secara transparan tanpa biaya siluman.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Library Statistics (Dynamic) -->
            <section id="statistik" class="py-16 sm:py-24 bg-navy-800 text-cream-100 relative overflow-hidden">
                <!-- Background Geometric Grids -->
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <div class="max-w-7xl mx-auto px-6 sm:px-8 relative z-10">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                        <div>
                            <span class="block font-serif text-4xl sm:text-5xl font-bold text-coral-400">{{ number_format($stats['books']) }}</span>
                            <span class="block text-xxs sm:text-xs font-semibold tracking-wider text-navy-300 uppercase mt-2">Buku Terdaftar</span>
                        </div>
                        <div>
                            <span class="block font-serif text-4xl sm:text-5xl font-bold text-coral-400">{{ number_format($stats['categories']) }}</span>
                            <span class="block text-xxs sm:text-xs font-semibold tracking-wider text-navy-300 uppercase mt-2">Kategori Buku</span>
                        </div>
                        <div>
                            <span class="block font-serif text-4xl sm:text-5xl font-bold text-coral-400">{{ number_format($stats['members']) }}</span>
                            <span class="block text-xxs sm:text-xs font-semibold tracking-wider text-navy-300 uppercase mt-2">Pembaca Aktif</span>
                        </div>
                        <div>
                            <span class="block font-serif text-4xl sm:text-5xl font-bold text-coral-400">{{ number_format($stats['transactions']) }}</span>
                            <span class="block text-xxs sm:text-xs font-semibold tracking-wider text-navy-300 uppercase mt-2">Transaksi Diproses</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. About LibraryGenz -->
            <section id="tentang" class="py-16 sm:py-24 bg-cream-50">
                <div class="max-w-7xl mx-auto px-6 sm:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-6 space-y-6">
                            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-navy-950 leading-tight">
                                Visi Kami: Mendekatkan Ilmu Pengetahuan Dengan Keindahan
                            </h2>
                            <p class="text-xs sm:text-sm text-navy-700 leading-relaxed">
                                Di LibraryGenz, kami percaya bahwa tempat berkumpulnya ilmu tidak harus terasa kaku dan membosankan. Melalui visual yang hangat, layout yang proporsional, dan arsitektur data yang andal, kami menghidupkan kembali esensi literatur fisik di dalam portal digital.
                            </p>
                            <p class="text-xs sm:text-sm text-navy-700 leading-relaxed">
                                Setiap interaksi kami rancang secara teliti — mulai dari transisi tombol hingga kejelasan laporan denda — guna memastikan pengalaman administrasi perpustakaan Anda bebas hambatan dan penuh kebahagiaan.
                            </p>
                        </div>
                        
                        <!-- Visual Panel (Mockup Styled Editorial Block) -->
                        <div class="lg:col-span-6 bg-navy-800 p-8 sm:p-12 rounded-xl text-cream-100 border border-navy-700 shadow-lg relative overflow-hidden group">
                            <div class="absolute -right-16 -top-16 w-48 h-48 bg-coral-500/20 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                            <h3 class="font-serif text-xl font-bold text-cream-50 mb-4">Jam Layanan Kami</h3>
                            <div class="space-y-4 text-xs text-navy-300">
                                <div class="flex justify-between border-b border-navy-700 pb-2">
                                    <span>Senin - Jumat</span>
                                    <span class="font-semibold text-cream-50">08:00 &mdash; 18:00</span>
                                </div>
                                <div class="flex justify-between border-b border-navy-700 pb-2">
                                    <span>Sabtu</span>
                                    <span class="font-semibold text-cream-50">09:00 &mdash; 15:00</span>
                                </div>
                                <div class="flex justify-between pb-2">
                                    <span>Minggu & Hari Libur</span>
                                    <span class="text-coral-400 font-semibold">Tutup</span>
                                </div>
                            </div>
                            <div class="mt-8 pt-6 border-t border-navy-700 flex items-center space-x-3 text-xxs tracking-wider uppercase font-semibold text-navy-400">
                                <svg class="w-4 h-4 text-coral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Gedung Rektorat Lt. 2, Kampus Genz</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. CTA login/register -->
            <section class="py-16 sm:py-24 border-t border-cream-300/40 bg-gradient-to-b from-cream-50 to-cream-100/50">
                <div class="max-w-5xl mx-auto px-6 sm:px-8 text-center bg-navy-800 text-cream-100 p-8 sm:p-16 rounded-2xl border border-navy-700 shadow-md relative overflow-hidden">
                    <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-coral-500/10 rounded-full blur-xl"></div>
                    
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight text-cream-50">
                        Siap Memulai Perjalanan Membaca?
                    </h2>
                    <p class="mt-4 text-xs sm:text-sm text-navy-300 max-w-xl mx-auto leading-relaxed">
                        Dapatkan kemudahan akses peminjaman buku fisik dan kelola aktivitas bacaan Anda sekarang secara terpadu.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-8 py-3 rounded-lg text-sm font-bold shadow-sm transition-colors text-center">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto border border-navy-700 hover:bg-navy-900 text-cream-100 px-8 py-3 rounded-lg text-sm font-bold transition-colors text-center">
                            Masuk Portal Anggota
                        </a>
                    </div>
                </div>
            </section>

        </main>

        <!-- 6. Footer -->
        <footer class="py-12 border-t border-cream-300 bg-cream-100/30 text-navy-500">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Brand logo in footer -->
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded bg-coral-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="font-serif text-sm font-bold tracking-wide text-navy-800">Library<span class="text-coral-500">Genz</span></span>
                </div>
                <div class="text-xxs sm:text-xs text-center text-navy-400">
                    &copy; {{ date('Y') }} LibraryGenz. Warm Editorial Library Management. Seluruh hak cipta dilindungi.
                </div>
                <div class="flex items-center space-x-4 text-xxs font-semibold uppercase tracking-wider text-navy-400">
                    <a href="#fitur" class="hover:text-navy-700 transition-colors">Fitur</a>
                    <a href="#statistik" class="hover:text-navy-700 transition-colors">Statistik</a>
                    <a href="#tentang" class="hover:text-navy-700 transition-colors">Tentang</a>
                </div>
            </div>
        </footer>

    </div>

</body>
</html>
