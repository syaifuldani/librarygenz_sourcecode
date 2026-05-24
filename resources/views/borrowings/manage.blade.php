<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Manajemen <span class="text-coral-500">Peminjaman</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Kelola persetujuan, serah terima buku fisik, dan proses pengembalian.
            </p>
        </div>
        <a href="{{ route('reports.export.borrowings', request()->only(['member','status','date_from','date_to'])) }}"
           class="shrink-0 inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </a>
    </div>

    <x-flash-alerts />

    <!-- Filter Bar -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('borrowings.manage') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Cari Anggota</label>
                <input type="text" name="member" value="{{ request('member') }}"
                       placeholder="Nama atau email anggota..."
                       class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
            </div>
            <div>
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Status Peminjaman</label>
                <select name="status" class="text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    <option value="">Semua Status</option>
                    <option value="requested" {{ request('status') === 'requested' ? 'selected' : '' }}>Pending (Diajukan)</option>
                    <option value="approved"  {{ request('status') === 'approved'  ? 'selected' : '' }}>Disetujui</option>
                    <option value="borrowed"  {{ request('status') === 'borrowed'  ? 'selected' : '' }}>Dipinjam</option>
                    <option value="overdue"   {{ request('status') === 'overdue'   ? 'selected' : '' }}>Terlambat (Overdue)</option>
                    <option value="returned"  {{ request('status') === 'returned'  ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
            </div>
            <div>
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
            </div>
            <button type="submit" class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-4 py-2 rounded-lg text-xs font-bold transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['member','status','date_from','date_to']))
                <a href="{{ route('borrowings.manage') }}"
                   class="border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-4 py-2 rounded-lg text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Alpine.js Tabs -->
    <div x-data="{ activeTab: 'pending' }" class="space-y-5">

        <!-- Tab Headers -->
        <div class="border-b border-cream-300 overflow-x-auto">
            <nav class="-mb-px flex space-x-6 min-w-max">
                <button @click="activeTab = 'pending'"
                    :class="activeTab === 'pending' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700'"
                    class="whitespace-nowrap py-3.5 px-1 border-b-2 font-serif text-sm font-bold flex items-center gap-2 transition-colors">
                    Permintaan Pending
                    <span :class="activeTab === 'pending' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                          class="py-0.5 px-2 rounded-full text-xxs font-bold transition-colors">
                        {{ $pendingRequests->total() }}
                    </span>
                </button>
                <button @click="activeTab = 'active'"
                    :class="activeTab === 'active' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700'"
                    class="whitespace-nowrap py-3.5 px-1 border-b-2 font-serif text-sm font-bold flex items-center gap-2 transition-colors">
                    Peminjaman Aktif
                    <span :class="activeTab === 'active' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                          class="py-0.5 px-2 rounded-full text-xxs font-bold transition-colors">
                        {{ $activeLoans->total() }}
                    </span>
                </button>
                <button @click="activeTab = 'past'"
                    :class="activeTab === 'past' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700'"
                    class="whitespace-nowrap py-3.5 px-1 border-b-2 font-serif text-sm font-bold flex items-center gap-2 transition-colors">
                    Log Riwayat
                    <span :class="activeTab === 'past' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                          class="py-0.5 px-2 rounded-full text-xxs font-bold transition-colors">
                        {{ $pastLogs->total() }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- TAB: PENDING REQUESTS -->
        <div x-show="activeTab === 'pending'" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Konfirmasi Permohonan Anggota</h4>
                <p class="text-xs text-navy-500 mt-0.5">Setujui untuk memotong stok buku, atau tolak dengan alasan.</p>
            </div>

            @if($pendingRequests->isEmpty())
                <x-empty-state type="borrowings" title="Tidak Ada Permintaan Pending"
                    message="Semua permohonan peminjaman sudah diproses. Tidak ada antrian baru." />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Diajukan</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Stok</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($pendingRequests as $borrowing)
                                <tr class="hover:bg-cream-100/20 transition-colors" x-data="{ showRejectForm: false }">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                {{ substr($borrowing->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="text-xs font-semibold text-navy-900">{{ $borrowing->user->name }}</div>
                                                <div class="text-xxs text-navy-400">{{ $borrowing->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-semibold text-navy-900">{{ $borrowing->book->title }}</div>
                                        <div class="text-xxs text-navy-400 mt-0.5">{{ $borrowing->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600 hidden sm:table-cell">
                                        {{ $borrowing->created_at->translatedFormat('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs hidden sm:table-cell">
                                        @if($borrowing->book->stock > 0)
                                            <span class="font-bold text-navy-900">{{ $borrowing->book->stock }} unit</span>
                                        @else
                                            <span class="font-bold text-coral-600">Habis (0)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div x-show="!showRejectForm" class="flex items-center justify-end gap-2">
                                            @if($borrowing->book->stock > 0)
                                                <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" class="inline"
                                                      onsubmit="event.preventDefault(); confirmAction(this, 'Setujui Peminjaman', 'Setujui peminjaman buku &quot;{{ addslashes($borrowing->book->title) }}&quot; untuk {{ $borrowing->user->name }}? Stok akan dikurangi.', 'Ya, Setujui', false)">
                                                    @csrf
                                                    <button type="submit"
                                                            class="bg-coral-500 hover:bg-coral-600 text-white px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors">
                                                        Setujui
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled class="bg-cream-200 text-navy-300 px-3 py-1.5 rounded-lg text-xxs font-bold cursor-not-allowed">
                                                    Setujui
                                                </button>
                                            @endif
                                            <button @click="showRejectForm = true"
                                                    class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-3 py-1.5 rounded-lg text-xxs font-semibold transition-colors">
                                                Tolak
                                            </button>
                                        </div>
                                        <div x-show="showRejectForm" style="display:none;" class="mt-2 text-left">
                                            <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST" class="space-y-2">
                                                @csrf
                                                <input type="text" name="notes" placeholder="Alasan penolakan..." required
                                                       class="w-full px-2 py-1.5 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500">
                                                <div class="flex gap-1.5 justify-end">
                                                    <button type="submit" class="bg-coral-600 hover:bg-coral-700 text-white px-3 py-1 rounded-lg text-xxs font-bold">Kirim Tolak</button>
                                                    <button type="button" @click="showRejectForm = false"
                                                            class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-3 py-1 rounded-lg text-xxs font-bold">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pendingRequests->hasPages())
                    <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                        {{ $pendingRequests->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- TAB: ACTIVE LOANS -->
        <div x-show="activeTab === 'active'" style="display:none;" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Serah Terima & Pengembalian</h4>
                <p class="text-xs text-navy-500 mt-0.5">Konfirmasi buku fisik diambil atau proses pengembalian.</p>
            </div>

            @if($activeLoans->isEmpty())
                <x-empty-state type="borrowings" title="Tidak Ada Peminjaman Aktif"
                    message="Tidak ada buku yang sedang dipinjam atau menunggu pengambilan saat ini." />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Batas Kembali</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($activeLoans as $borrowing)
                                <tr class="hover:bg-cream-100/20 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-semibold text-navy-900">{{ $borrowing->user->name }}</div>
                                        <div class="text-xxs text-navy-400">{{ $borrowing->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-semibold text-navy-900">{{ $borrowing->book->title }}</div>
                                        <div class="text-xxs text-navy-400 mt-0.5">{{ $borrowing->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600 hidden sm:table-cell">
                                        {{ $borrowing->due_date ? $borrowing->due_date->translatedFormat('d M Y') : 'Menunggu serah terima' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($borrowing->status)
                                            @case('approved')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-blue-100 text-blue-800">Siap Diambil</span>
                                                @break
                                            @case('borrowed')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-800">Dipinjam</span>
                                                @break
                                            @case('overdue')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-coral-200 text-coral-900 border border-coral-400 animate-pulse">Terlambat</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if($borrowing->status === 'approved')
                                            <form action="{{ route('borrowings.borrow', $borrowing) }}" method="POST" class="inline"
                                                  onsubmit="event.preventDefault(); confirmAction(this, 'Serahkan Buku', 'Konfirmasi buku &quot;{{ addslashes($borrowing->book->title) }}&quot; sudah diserahkan kepada {{ $borrowing->user->name }}?', 'Ya, Serahkan', false)">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors">
                                                    Serahkan Buku
                                                </button>
                                            </form>
                                        @elseif(in_array($borrowing->status, ['borrowed', 'overdue']))
                                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline"
                                                  onsubmit="event.preventDefault(); confirmAction(this, 'Tandai Dikembalikan', 'Konfirmasi buku &quot;{{ addslashes($borrowing->book->title) }}&quot; sudah diterima kembali dari {{ $borrowing->user->name }}?', 'Ya, Kembalikan', false)">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-coral-500 hover:bg-coral-600 text-white px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors">
                                                    Tandai Kembali
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($activeLoans->hasPages())
                    <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                        {{ $activeLoans->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- TAB: PAST LOGS -->
        <div x-show="activeTab === 'past'" style="display:none;" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Log Transaksi Historis</h4>
                <p class="text-xs text-navy-500 mt-0.5">Peminjaman yang sudah selesai (dikembalikan atau ditolak).</p>
            </div>

            @if($pastLogs->isEmpty())
                <x-empty-state type="logs" title="Belum Ada Riwayat"
                    message="Belum ada transaksi peminjaman yang selesai tercatat." />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Tgl Kembali</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($pastLogs as $borrowing)
                                <tr class="hover:bg-cream-100/20 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-semibold text-navy-900">{{ $borrowing->user->name }}</div>
                                        <div class="text-xxs text-navy-400">{{ $borrowing->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-semibold text-navy-900">{{ $borrowing->book->title }}</div>
                                        <div class="text-xxs text-navy-400 mt-0.5">{{ $borrowing->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600 hidden sm:table-cell">
                                        {{ $borrowing->borrow_date ? $borrowing->borrow_date->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600 hidden sm:table-cell">
                                        {{ $borrowing->return_date ? $borrowing->return_date->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($borrowing->status === 'returned')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-cream-300 text-navy-700">Dikembalikan</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-coral-100 text-coral-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs text-navy-500 max-w-xs truncate">
                                        {{ $borrowing->notes ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pastLogs->hasPages())
                    <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                        {{ $pastLogs->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</x-app-layout>
