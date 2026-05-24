<x-app-layout>
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
                Selamat Datang, <span class="text-coral-500">{{ Auth::user()->name }}</span>
            </h2>
            <p class="mt-2 text-sm text-navy-500">
                Berikut adalah ringkasan performa dan aktivitas perpustakaan LibraryGenz hari ini.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-cream-200 text-navy-700 border border-cream-300">
                <svg class="mr-1.5 h-4 w-4 text-navy-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ now()->translatedFormat('d F Y') }}
            </span>
            <button class="bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all duration-200">
                + Tambah Buku
            </button>
        </div>
    </div>

    <!-- Quick Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Navy theme -->
        <div class="bg-navy-800 text-cream-100 p-6 rounded-xl border border-navy-700 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200">
            <div class="absolute -right-4 -bottom-4 text-navy-700 opacity-20 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <p class="text-xs font-semibold text-navy-300 uppercase tracking-wider">Total Koleksi Buku</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-cream-50">1,248</h3>
            <div class="mt-4 flex items-center text-xs text-navy-400">
                <span class="text-coral-400 font-semibold mr-1">12</span> Kategori terdaftar
            </div>
        </div>

        <!-- Card 2: Cream theme -->
        <div class="bg-cream-100/60 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Peminjaman Aktif</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-900">42</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                <span class="bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded-full text-xxs mr-1.5">3 Pending</span>
                perlu verifikasi
            </div>
        </div>

        <!-- Card 3: Coral theme -->
        <div class="bg-coral-50 border border-coral-200 p-6 rounded-xl shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200">
            <p class="text-xs font-semibold text-coral-800 uppercase tracking-wider">Buku Terlambat</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-coral-700">7</h3>
            <div class="mt-4 flex items-center text-xs text-coral-600">
                <svg class="w-4 h-4 mr-1 text-coral-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Tindakan segera diperlukan
            </div>
        </div>

        <!-- Card 4: Light Cream theme -->
        <div class="bg-cream-50 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Total Denda Aktif</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-950">Rp 140,000</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                Tarif flat Rp2.000 / hari
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns: Table of borrowing requests -->
        <div class="lg:col-span-2 bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-5 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
                <div>
                    <h4 class="font-serif text-lg font-bold text-navy-950">Persetujuan Peminjaman</h4>
                    <p class="text-xs text-navy-500 mt-1">Daftar permintaan peminjaman buku yang menunggu konfirmasi.</p>
                </div>
                <span class="inline-block py-1 px-2.5 bg-coral-100 text-coral-700 text-xxs font-bold rounded-full">3 Permintaan</span>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Pengajuan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 class=text-right px-6 py-3 text-xxs font-bold text-navy-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        <!-- Request Row 1 -->
                        <tr class="hover:bg-cream-100/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs">
                                        RP
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-xs font-semibold text-navy-900">Rian Permana</div>
                                        <div class="text-xxs text-navy-400">rian.permana@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-semibold text-navy-900">Bumi Manusia</div>
                                <div class="text-xxs text-navy-400">Pramoedya Ananta Toer</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                24 Mei 2026
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-amber-100 text-amber-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-1">
                                <button class="bg-coral-500 hover:bg-coral-600 text-white px-2.5 py-1 rounded text-xxs font-semibold shadow-sm transition-colors duration-150">
                                    Setujui
                                </button>
                                <button class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-2.5 py-1 rounded text-xxs font-semibold transition-colors duration-150">
                                    Tolak
                                </button>
                            </td>
                        </tr>

                        <!-- Request Row 2 -->
                        <tr class="hover:bg-cream-100/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs">
                                        SA
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-xs font-semibold text-navy-900">Siti Aminah</div>
                                        <div class="text-xxs text-navy-400">siti.aminah@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-semibold text-navy-900">Laskar Pelangi</div>
                                <div class="text-xxs text-navy-400">Andrea Hirata</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                23 Mei 2026
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-amber-100 text-amber-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-1">
                                <button class="bg-coral-500 hover:bg-coral-600 text-white px-2.5 py-1 rounded text-xxs font-semibold shadow-sm transition-colors duration-150">
                                    Setujui
                                </button>
                                <button class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-2.5 py-1 rounded text-xxs font-semibold transition-colors duration-150">
                                    Tolak
                                </button>
                            </td>
                        </tr>

                        <!-- Request Row 3 -->
                        <tr class="hover:bg-cream-100/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs">
                                        DK
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-xs font-semibold text-navy-900">Dimas Kusuma</div>
                                        <div class="text-xxs text-navy-400">dimas.k@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-semibold text-navy-900">Filosofi Teras</div>
                                <div class="text-xxs text-navy-400">Henry Manampiring</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                22 Mei 2026
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-amber-100 text-amber-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-1">
                                <button class="bg-coral-500 hover:bg-coral-600 text-white px-2.5 py-1 rounded text-xxs font-semibold shadow-sm transition-colors duration-150">
                                    Setujui
                                </button>
                                <button class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-2.5 py-1 rounded text-xxs font-semibold transition-colors duration-150">
                                    Tolak
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex items-center justify-between text-xs text-navy-500">
                <span>Menampilkan 3 dari 3 antrean</span>
                <a href="#" class="font-bold text-coral-500 hover:text-coral-600">Lihat Semua Aktivitas &rarr;</a>
            </div>
        </div>

        <!-- Right 1 Column: Activity Feed & Rules quick look -->
        <div class="space-y-6">
            
            <!-- Activity Logs Section -->
            <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-lg font-bold text-navy-950 mb-4">Aktivitas Terbaru</h4>
                
                <div class="flow-root">
                    <ul class="-mb-8">
                        <!-- Activity 1 -->
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-cream-300" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-coral-100 flex items-center justify-center ring-8 ring-cream-50">
                                            <svg class="h-4 w-4 text-coral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-navy-800">
                                            Buku <span class="font-semibold text-navy-950">Filosofi Teras</span> terlambat dikembalikan oleh <span class="font-semibold text-navy-950">Dimas Kusuma</span>
                                        </p>
                                        <div class="text-right text-xxs text-navy-400 mt-0.5">
                                            1 jam yang lalu &bull; <span class="text-coral-500 font-semibold">+Rp4.000 denda</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Activity 2 -->
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-cream-300" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center ring-8 ring-cream-50">
                                            <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-navy-800">
                                            Pengembalian buku <span class="font-semibold text-navy-950">Cantik Itu Luka</span> oleh <span class="font-semibold text-navy-950">Siti Aminah</span> diverifikasi
                                        </p>
                                        <div class="text-right text-xxs text-navy-400 mt-0.5">
                                            3 jam yang lalu
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Activity 3 -->
                        <li>
                            <div class="relative pb-2">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-navy-100 flex items-center justify-center ring-8 ring-cream-50">
                                            <svg class="h-4 w-4 text-navy-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-navy-800">
                                            Admin menambahkan buku baru: <span class="font-semibold text-navy-950">Gadis Pantai</span>
                                        </p>
                                        <div class="text-right text-xxs text-navy-400 mt-0.5">
                                            Kemarin
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Fine System Configuration Panel (Quick View) -->
            <div class="bg-navy-800 border border-navy-700 text-cream-100 rounded-xl p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-3">
                    <span class="p-1 rounded bg-coral-500">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </span>
                    <h4 class="font-serif text-md font-bold text-cream-50">Sistem Denda & Aturan</h4>
                </div>
                <p class="text-xs text-navy-300 leading-relaxed">
                    Perpustakaan LibraryGenz menerapkan aturan flat denda keterlambatan sebesar:
                </p>
                <div class="my-4 py-3 px-4 bg-navy-900 border border-navy-700 rounded-lg text-center">
                    <span class="text-xs text-navy-400 block font-semibold">TARIF DENDA</span>
                    <span class="text-2xl font-serif font-bold text-coral-400">Rp 2.000 <span class="text-xs font-sans font-normal text-cream-100">/ hari</span></span>
                </div>
                <p class="text-xxs text-navy-400">
                    * Perhitungan denda otomatis terhitung secara real-time pada saat petugas pustakawan melakukan verifikasi pengembalian buku di sistem.
                </p>
            </div>

        </div>

    </div>
</x-app-layout>
