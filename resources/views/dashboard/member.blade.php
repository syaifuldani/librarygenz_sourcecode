<x-app-layout>
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
                Dashboard <span class="text-coral-500">Anggota</span>
            </h2>
            <p class="mt-2 text-sm text-navy-500">
                Cari buku di katalog, ajukan peminjaman baru, dan pantau status pengembalian Anda.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('books.index') }}" class="bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all duration-200">
                Cari & Pinjam Buku
            </a>
        </div>
    </div>

    <!-- Member Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Catalog books count -->
        <div class="bg-navy-800 text-cream-100 p-6 rounded-xl border border-navy-700 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-300 uppercase tracking-wider">Katalog Tersedia</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-cream-50">{{ number_format($stats['catalog_available']) }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-400">
                Buku siap dipinjam sekarang
            </div>
        </div>

        <!-- Card 2: Active loans count -->
        <div class="bg-cream-100/60 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Sedang Dipinjam</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-900">{{ $stats['books_borrowed'] }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                Batas maksimal 3 buku aktif
            </div>
        </div>

        <!-- Card 3: Returned count -->
        <div class="bg-cream-50 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Riwayat Selesai</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-950">{{ $stats['completed_history'] }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                Buku yang telah Anda kembalikan
            </div>
        </div>

        <!-- Card 4: Fines unpaid -->
        <div class="bg-coral-50 border border-coral-200 p-6 rounded-xl shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-coral-800 uppercase tracking-wider">Tagihan Denda Anda</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-coral-700">Rp {{ number_format($stats['active_fines_unpaid'], 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center text-xs text-coral-600">
                Denda keterlambatan berjalan
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns: Table of current loans -->
        <div class="lg:col-span-2 bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-5 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
                <div>
                    <h4 class="font-serif text-lg font-bold text-navy-950">Buku Yang Sedang Dipinjam</h4>
                    <p class="text-xs text-navy-500 mt-1">Daftar buku perpustakaan yang sedang berada di tangan Anda.</p>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Judul Buku</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Batas Kembali</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Sisa / Terlambat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @forelse($stats['active_borrowings'] as $borrowing)
                            @php
                                $isOverdue = $borrowing->status === 'overdue' || ($borrowing->due_date && $borrowing->due_date->isPast());
                                $daysDiff = $borrowing->due_date ? today()->diffInDays($borrowing->due_date, false) : 0;
                            @endphp
                            <tr class="hover:bg-cream-100/20 transition-colors {{ $isOverdue ? 'bg-coral-50/10 hover:bg-coral-50/20' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-semibold {{ $isOverdue ? 'text-coral-800 font-bold' : 'text-navy-900' }}">{{ $borrowing->book->title }}</div>
                                    <div class="text-xxs {{ $isOverdue ? 'text-coral-500' : 'text-navy-400' }} mt-0.5">Karya {{ $borrowing->book->author }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                    {{ $borrowing->borrow_date ? $borrowing->borrow_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs {{ $isOverdue ? 'text-coral-600 font-semibold' : 'text-navy-600' }}">
                                    {{ $borrowing->due_date ? $borrowing->due_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    @if($isOverdue)
                                        <span class="text-coral-600 font-bold">Terlambat {{ abs($daysDiff) }} hari</span>
                                    @else
                                        <span class="text-emerald-600 font-semibold">{{ $daysDiff }} hari lagi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($isOverdue)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-coral-100 text-coral-800 border border-coral-200">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-800">
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-0">
                                    <x-empty-state type="borrowings" title="Tidak Ada Peminjaman Aktif"
                                        message="Anda tidak memiliki buku yang sedang dipinjam saat ini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex items-center justify-between text-xs text-navy-500">
                <span>Peminjaman Aktif: {{ $stats['books_borrowed'] }} Buku</span>
                <a href="{{ route('borrowings.history') }}" class="font-bold text-coral-500 hover:text-coral-600">Lihat Semua Riwayat &rarr;</a>
            </div>
        </div>

        <!-- Right Side Columns: Borrowing Guidelines -->
        <div class="space-y-6">
            <!-- Guidelines -->
            <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-lg font-bold text-navy-950 mb-3">Aturan Pinjam Buku</h4>
                <ul class="space-y-2 text-xs text-navy-700 list-disc list-inside leading-relaxed">
                    <li>Maksimal meminjam <span class="font-semibold">3 buku</span> sekaligus.</li>
                    <li>Durasi peminjaman maksimal adalah <span class="font-semibold">7 hari</span> sejak disetujui.</li>
                    <li>Denda keterlambatan berlaku flat <span class="font-semibold">Rp2.000 / hari</span>.</li>
                </ul>
            </div>

            <!-- FAQ Panel -->
            <div class="bg-navy-800 border border-navy-700 text-cream-100 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-md font-bold text-cream-50 mb-2">Ingin Mengembalikan Buku?</h4>
                <p class="text-xs text-navy-300 leading-relaxed mb-4">
                    Silakan bawa buku fisik Anda ke loket pustakawan, lalu serahkan buku agar pustakawan memverifikasi pengembalian di dalam sistem.
                </p>
                <div class="w-full bg-coral-500 text-center text-white py-1.5 px-3 rounded-lg text-xs font-bold shadow-sm">
                    Hubungi Pustakawan
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
