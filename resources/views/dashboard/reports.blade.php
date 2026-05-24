<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Laporan & <span class="text-coral-500">Analitik Data</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Pantau tren peminjaman, keterlambatan, dan keaktifan anggota LibraryGenz.
            </p>
        </div>
        <!-- Export Buttons -->
        <div class="flex flex-wrap gap-2 shrink-0">
            <a href="{{ route('reports.export.statistics') }}"
               class="inline-flex items-center gap-1.5 bg-coral-500 hover:bg-coral-600 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Statistik
            </a>
            <a href="{{ route('reports.export.borrowings') }}"
               class="inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                Export Peminjaman
            </a>
            <a href="{{ route('reports.export.fines') }}"
               class="inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                Export Denda
            </a>
        </div>
    </div>

    <!-- Stats Row: Overdue Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Overdue Count -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-navy-400 uppercase tracking-wider">Total Buku Overdue Saat Ini</span>
                <h3 class="font-serif text-3xl font-bold text-coral-600 mt-2">
                    {{ $reportData['overdue_stats']['total_overdue'] }} Buku
                </h3>
                <p class="text-xxs text-navy-500 mt-1">Peminjaman aktif melewati batas waktu</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-coral-500/10 flex items-center justify-center text-coral-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>

        <!-- Card 2: Unpaid Fine Balance -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-navy-400 uppercase tracking-wider">Total Piutang Denda Unpaid</span>
                <h3 class="font-serif text-3xl font-bold text-navy-900 mt-2">
                    Rp{{ number_format($reportData['overdue_stats']['total_unpaid_fines'], 0, ',', '.') }}
                </h3>
                <p class="text-xxs text-navy-500 mt-1">Denda aktif yang belum dilunasi</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-navy-800/10 flex items-center justify-center text-navy-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Card 3: Avg Overdue Days -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-navy-400 uppercase tracking-wider">Rata-rata Keterlambatan</span>
                <h3 class="font-serif text-3xl font-bold text-emerald-600 mt-2">
                    {{ $reportData['overdue_stats']['average_late_days'] }} Hari
                </h3>
                <p class="text-xxs text-navy-500 mt-1">Durasi rata-rata keterlambatan per pengembalian</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m0 0l3 3m-3-3L5 6m3 6h12m0 0l-4-4m4 4l-4 4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Borrowing Trend Chart/List -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm flex flex-col">
            <h4 class="font-serif text-lg font-bold text-navy-950 mb-1">Tren Peminjaman Buku</h4>
            <p class="text-xs text-navy-500 mb-6">Distribusi frekuensi peminjaman dalam 12 bulan terakhir.</p>

            <div class="space-y-4 flex-1">
                @forelse($reportData['borrowing_trend'] as $month => $count)
                    <div>
                        <div class="flex justify-between text-xs text-navy-800 mb-1">
                            <span class="font-semibold">{{ $month }}</span>
                            <span class="font-bold">{{ $count }} peminjaman</span>
                        </div>
                        @php
                            $maxVal = max($reportData['borrowing_trend']->toArray() ?: [1]);
                            $percentage = min(100, round(($count / $maxVal) * 100));
                        @endphp
                        <div class="w-full bg-cream-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-coral-500 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-navy-400 py-12 text-center">Belum ada transaksi peminjaman terekam.</p>
                @endforelse
            </div>
        </div>

        <!-- Most Borrowed Books -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm flex flex-col">
            <h4 class="font-serif text-lg font-bold text-navy-950 mb-1">Katalog Buku Paling Populer</h4>
            <p class="text-xs text-navy-500 mb-6">Peringkat buku teratas berdasarkan frekuensi total peminjaman.</p>

            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th scope="col" class="px-4 py-2 text-left text-xxs font-bold text-navy-500 uppercase">Peringkat</th>
                            <th scope="col" class="px-4 py-2 text-left text-xxs font-bold text-navy-500 uppercase">Buku</th>
                            <th scope="col" class="px-4 py-2 text-right text-xxs font-bold text-navy-500 uppercase">Jumlah Pinjam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cream-200 text-navy-800 text-xs">
                        @forelse($reportData['most_borrowed_books'] as $index => $book)
                            <tr class="hover:bg-cream-100/20">
                                <td class="px-4 py-3 whitespace-nowrap font-bold text-coral-600">
                                    #{{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-navy-900">{{ $book->title }}</div>
                                    <div class="text-xxs text-navy-400">Karya {{ $book->author }}</div>
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-navy-900 whitespace-nowrap">
                                    {{ $book->borrowings_count }} kali
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-xs text-navy-400">Belum ada peminjaman buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Members Panel -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm mb-8 flex flex-col">
        <h4 class="font-serif text-lg font-bold text-navy-950 mb-1">Anggota Paling Aktif</h4>
        <p class="text-xs text-navy-500 mb-6">Anggota perpustakaan yang paling sering melakukan peminjaman buku.</p>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-cream-300">
                <thead class="bg-cream-100/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase">Anggota</th>
                        <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase">Email</th>
                        <th scope="col" class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase">Total Peminjaman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200 text-navy-800 text-xs">
                    @forelse($reportData['active_members'] as $member)
                        <tr class="hover:bg-cream-100/20">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs uppercase mr-3">
                                        {{ substr($member->name, 0, 2) }}
                                    </div>
                                    <div class="font-semibold text-navy-900">{{ $member->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-navy-600">
                                {{ $member->email }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-coral-600 whitespace-nowrap">
                                {{ $member->borrowings_count }} Peminjaman
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-xs text-navy-400">Belum ada anggota terdaftar dengan aktivitas peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
