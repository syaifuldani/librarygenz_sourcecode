<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Manajemen <span class="text-coral-500">Denda & Keterlambatan</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Kelola pembayaran denda, bebaskan denda, dan pantau analitik keuangan.
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('reports.export.fines') }}"
               class="inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('borrowings.overdue') }}"
               class="inline-flex items-center gap-1.5 bg-coral-500 hover:bg-coral-600 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Lihat Overdue
            </a>
        </div>
    </div>

    <x-flash-alerts />

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xxs font-semibold text-navy-400 uppercase tracking-wider">Denda Unpaid</span>
                <h3 class="font-serif text-2xl font-bold text-coral-600 mt-1.5">Rp{{ number_format($analytics['total_unpaid'], 0, ',', '.') }}</h3>
                <p class="text-xxs text-navy-500 mt-0.5">Belum ditagih</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-coral-500/10 flex items-center justify-center text-coral-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xxs font-semibold text-navy-400 uppercase tracking-wider">Denda Terkumpul</span>
                <h3 class="font-serif text-2xl font-bold text-emerald-600 mt-1.5">Rp{{ number_format($analytics['total_paid'], 0, ',', '.') }}</h3>
                <p class="text-xxs text-navy-500 mt-0.5">Sudah dibayar</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xxs font-semibold text-navy-400 uppercase tracking-wider">Denda Dibebaskan</span>
                <h3 class="font-serif text-2xl font-bold text-navy-700 mt-1.5">Rp{{ number_format($analytics['total_waived'], 0, ',', '.') }}</h3>
                <p class="text-xxs text-navy-500 mt-0.5">Waived</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-navy-800/10 flex items-center justify-center text-navy-700 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2 4 4m0-7V3m0 0l3 3m-3-3L9 6M3 21h18"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('fines.manage') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Cari Anggota</label>
                <input type="text" name="member" value="{{ request('member') }}"
                       placeholder="Nama atau email..."
                       class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
            </div>
            <div>
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Durasi Terlambat</label>
                <select name="overdue_duration" class="text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    <option value="">Semua Keterlambatan</option>
                    <option value="1-7"  {{ request('overdue_duration') === '1-7'  ? 'selected' : '' }}>1 - 7 Hari</option>
                    <option value="8-14" {{ request('overdue_duration') === '8-14' ? 'selected' : '' }}>8 - 14 Hari</option>
                    <option value="15+"  {{ request('overdue_duration') === '15+'  ? 'selected' : '' }}>15+ Hari</option>
                </select>
            </div>
            <button type="submit" class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-4 py-2 rounded-lg text-xs font-bold transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['member','overdue_duration']))
                <a href="{{ route('fines.manage') }}"
                   class="border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-4 py-2 rounded-lg text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Alpine.js Tabs -->
    <div x-data="{ activeTab: 'unpaid' }" class="space-y-5">
        <div class="border-b border-cream-300">
            <nav class="-mb-px flex space-x-6">
                <button @click="activeTab = 'unpaid'"
                    :class="activeTab === 'unpaid' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700'"
                    class="whitespace-nowrap py-3.5 px-1 border-b-2 font-serif text-sm font-bold flex items-center gap-2 transition-colors">
                    Belum Dibayar
                    <span :class="activeTab === 'unpaid' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                          class="py-0.5 px-2 rounded-full text-xxs font-bold transition-colors">
                        {{ $unpaidFines->total() }}
                    </span>
                </button>
                <button @click="activeTab = 'resolved'"
                    :class="activeTab === 'resolved' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700'"
                    class="whitespace-nowrap py-3.5 px-1 border-b-2 font-serif text-sm font-bold flex items-center gap-2 transition-colors">
                    Log Riwayat
                    <span :class="activeTab === 'resolved' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                          class="py-0.5 px-2 rounded-full text-xxs font-bold transition-colors">
                        {{ $resolvedFines->total() }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- TAB: UNPAID -->
        <div x-show="activeTab === 'unpaid'" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Tagihan Denda Aktif</h4>
                <p class="text-xs text-navy-500 mt-0.5">Terima pembayaran tunai atau bebaskan denda dengan alasan resmi.</p>
            </div>

            @if($unpaidFines->isEmpty())
                <x-empty-state type="fines" title="Tidak Ada Denda Aktif"
                    message="Semua denda sudah diselesaikan. Tidak ada tagihan yang menunggu." />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Terlambat</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Denda</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($unpaidFines as $fine)
                                <tr class="hover:bg-cream-100/20 transition-colors" x-data="{ showWaiveForm: false }">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                {{ substr($fine->borrowing->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="text-xs font-semibold text-navy-900">{{ $fine->borrowing->user->name }}</div>
                                                <div class="text-xxs text-navy-400">{{ $fine->borrowing->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-semibold text-navy-900">{{ $fine->borrowing->book->title }}</div>
                                        <div class="text-xxs text-navy-400 mt-0.5">{{ $fine->borrowing->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-coral-100 text-coral-800">
                                            {{ $fine->late_days }} hari
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-coral-600">
                                        Rp{{ number_format($fine->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div x-show="!showWaiveForm" class="flex items-center justify-end gap-2">
                                            <form action="{{ route('fines.pay', $fine) }}" method="POST" class="inline"
                                                  onsubmit="event.preventDefault(); confirmAction(this, 'Terima Pembayaran', 'Konfirmasi penerimaan pembayaran tunai Rp{{ number_format($fine->amount, 0, ',', '.') }} dari {{ $fine->borrowing->user->name }}?', 'Ya, Terima', false)">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-coral-500 hover:bg-coral-600 text-white px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors">
                                                    Terima Bayar
                                                </button>
                                            </form>
                                            <button @click="showWaiveForm = true"
                                                    class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-3 py-1.5 rounded-lg text-xxs font-semibold transition-colors">
                                                Bebaskan
                                            </button>
                                        </div>
                                        <div x-show="showWaiveForm" style="display:none;" class="mt-2 text-left">
                                            <form action="{{ route('fines.waive', $fine) }}" method="POST" class="space-y-2">
                                                @csrf
                                                <input type="text" name="notes" placeholder="Alasan pembebasan..." required
                                                       class="w-full px-2 py-1.5 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500">
                                                <div class="flex gap-1.5 justify-end">
                                                    <button type="submit" class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-3 py-1 rounded-lg text-xxs font-bold">Bebaskan</button>
                                                    <button type="button" @click="showWaiveForm = false"
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
                @if($unpaidFines->hasPages())
                    <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                        {{ $unpaidFines->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- TAB: RESOLVED -->
        <div x-show="activeTab === 'resolved'" style="display:none;" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Log Denda Selesai</h4>
                <p class="text-xs text-navy-500 mt-0.5">Denda yang sudah lunas dibayar atau dibebaskan.</p>
            </div>

            @if($resolvedFines->isEmpty())
                <x-empty-state type="fines" title="Belum Ada Riwayat Denda"
                    message="Belum ada denda yang diselesaikan." />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Terlambat</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Denda</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($resolvedFines as $fine)
                                <tr class="hover:bg-cream-100/20 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-semibold text-navy-900">{{ $fine->borrowing->user->name }}</div>
                                        <div class="text-xxs text-navy-400">{{ $fine->borrowing->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-semibold text-navy-900">{{ $fine->borrowing->book->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600 hidden sm:table-cell">{{ $fine->late_days }} hari</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-navy-950">
                                        Rp{{ number_format($fine->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($fine->status === 'paid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-800">Lunas</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-navy-100 text-navy-800">Dibebaskan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600 hidden sm:table-cell">
                                        {{ $fine->paid_at ? $fine->paid_at->translatedFormat('d M Y') : $fine->updated_at->translatedFormat('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($resolvedFines->hasPages())
                    <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                        {{ $resolvedFines->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
