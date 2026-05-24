<x-app-layout>
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
                Dashboard <span class="text-coral-500">Pustakawan</span>
            </h2>
            <p class="mt-2 text-sm text-navy-500">
                Verifikasi peminjaman, pantau jatuh tempo pengembalian, dan kelola katalog buku LibraryGenz.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-cream-200 text-navy-700 border border-cream-300">
                <svg class="mr-1.5 h-4 w-4 text-navy-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Petugas Aktif
            </span>
            <a href="{{ route('books.create') }}" class="bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all duration-200">
                + Daftarkan Buku Baru
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    <x-flash-alerts />

    <!-- Quick Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Books counter -->
        <div class="bg-navy-800 text-cream-100 p-6 rounded-xl border border-navy-700 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-300 uppercase tracking-wider">Katalog Buku</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-cream-50">{{ number_format($stats['total_books']) }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-400">
                Total judul buku terdaftar
            </div>
        </div>

        <!-- Card 2: Pending borrowings -->
        <div class="bg-cream-100/60 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Persetujuan Pending</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-coral-500">{{ $stats['pending_approval'] }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                Butuh keputusan persetujuan
            </div>
        </div>

        <!-- Card 3: Overdue books -->
        <div class="bg-coral-50 border border-coral-200 p-6 rounded-xl shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-coral-800 uppercase tracking-wider">Buku Overdue (Terlambat)</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-coral-700">{{ $stats['overdue_books'] }}</h3>
            <div class="mt-4 flex items-center text-xs text-coral-600">
                Harus segera dikembalikan
            </div>
        </div>

        <!-- Card 4: Fines Collected -->
        <div class="bg-cream-50 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Denda Selesai</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-950">Rp {{ number_format($stats['total_fines_processed'], 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                Akumulasi denda lunas & waived
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns: Table of borrowing requests -->
        <div class="lg:col-span-2 bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-5 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
                <div>
                    <h4 class="font-serif text-lg font-bold text-navy-950">Antrean Verifikasi Peminjaman</h4>
                    <p class="text-xs text-navy-500 mt-1">Daftar permintaan peminjaman buku terbaru yang diajukan oleh anggota.</p>
                </div>
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
                            <th scope="col" class="px-6 py-3 text-xxs font-bold text-navy-500 uppercase tracking-wider text-right w-56">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @forelse($stats['pending_queue'] as $borrowing)
                            <tr class="hover:bg-cream-100/20 transition-colors" x-data="{ showRejectForm: false, rejectNotes: '' }">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs uppercase">
                                            {{ substr($borrowing->user->name, 0, 2) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-xs font-semibold text-navy-900">{{ $borrowing->user->name }}</div>
                                            <div class="text-xxs text-navy-400">{{ $borrowing->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-semibold text-navy-900">{{ $borrowing->book->title }}</div>
                                    <div class="text-xxs text-navy-400 mt-0.5">{{ $borrowing->book->author }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                    {{ $borrowing->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                    <div x-show="!showRejectForm" class="flex items-center justify-end space-x-2">
                                        @if($borrowing->book->stock > 0)
                                            <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" class="inline"
                                                  onsubmit="event.preventDefault(); confirmAction(this, 'Setujui Peminjaman', 'Setujui peminjaman buku &quot;{{ addslashes($borrowing->book->title) }}&quot; untuk {{ $borrowing->user->name }}?', 'Ya, Setujui', false)">
                                                @csrf
                                                <button type="submit" class="bg-coral-500 hover:bg-coral-600 text-white px-2.5 py-1 rounded text-xxs font-bold shadow-sm transition-colors duration-150">
                                                    Setujui
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-cream-200 text-navy-300 px-2.5 py-1 rounded text-xxs font-bold cursor-not-allowed">
                                                Habis
                                            </button>
                                        @endif
                                        <button @click="showRejectForm = true" class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-2.5 py-1 rounded text-xxs font-semibold transition-colors duration-150">
                                            Tolak
                                        </button>
                                    </div>

                                    <div x-show="showRejectForm" style="display: none;" class="mt-2 text-left">
                                        <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST" class="space-y-2">
                                            @csrf
                                            <input type="text" name="notes" placeholder="Alasan penolakan..." required x-model="rejectNotes"
                                                class="w-full px-2 py-1 text-xs bg-cream-50 border border-cream-300 rounded-md text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500">
                                            <div class="flex items-center justify-end space-x-1">
                                                <button type="submit" class="bg-coral-600 hover:bg-coral-700 text-white px-2 py-0.5 rounded text-xxs font-bold shadow-sm">
                                                    Kirim
                                                </button>
                                                <button type="button" @click="showRejectForm = false; rejectNotes = ''" class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-2 py-0.5 rounded text-xxs font-bold">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-0">
                                    <x-empty-state type="borrowings" title="Tidak Ada Permintaan Pending"
                                        message="Semua permohonan peminjaman sudah diproses. Tidak ada antrian baru." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex items-center justify-between text-xs text-navy-500">
                <span>Menampilkan hingga 5 permintaan pending terlama</span>
                <a href="{{ route('borrowings.manage') }}" class="font-bold text-coral-500 hover:text-coral-600">Lihat Antrean Lengkap &rarr;</a>
            </div>
        </div>

        <!-- Right Side Columns: Activity Log and Fine Rates -->
        <div class="space-y-6">
            <!-- Activity Feed -->
            <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-lg font-bold text-navy-950 mb-4">Aktivitas Buku Terbaru</h4>
                <ul class="space-y-4 text-xs text-navy-800">
                    @forelse($stats['recent_activities'] as $act)
                        @php
                            $borderColor = match($act->activity_type) {
                                'borrow_request' => 'border-amber-500',
                                'approval' => 'border-blue-500',
                                'return' => 'border-emerald-500',
                                'fine_payment' => 'border-coral-500',
                                default => 'border-navy-500'
                            };
                        @endphp
                        <li class="border-l-2 {{ $borderColor }} pl-3">
                            <p class="font-semibold text-navy-950 leading-relaxed">{{ $act->description }}</p>
                            <span class="text-xxs text-navy-400 mt-1 block">
                                {{ $act->created_at->diffForHumans() }} &bull; oleh {{ $act->user ? $act->user->name : 'System' }}
                            </span>
                        </li>
                    @empty
                        <li class="text-navy-400 py-4 text-center">Belum ada aktivitas terekam saat ini.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Fine System Configuration Panel (Quick View) -->
            <div class="bg-navy-800 border border-navy-700 text-cream-100 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-md font-bold text-cream-50 mb-3">Aturan Keterlambatan</h4>
                <div class="my-4 py-3 px-4 bg-navy-900 border border-navy-700 rounded-lg text-center">
                    <span class="text-2xl font-serif font-bold text-coral-400">Rp {{ number_format($stats['late_fine_rules'], 0, ',', '.') }} <span class="text-xs font-sans font-normal text-cream-100">/ hari</span></span>
                </div>
                <p class="text-xxs text-navy-400 leading-relaxed">
                    Sistem otomatis mengalkulasi denda ketika Anda memproses pengembalian buku di menu verifikasi kembali.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>
