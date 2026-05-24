<x-app-layout>
    <!-- Header -->
    <div class="mb-6">
        <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
            Denda & <span class="text-coral-500">Keterlambatan Anda</span>
        </h2>
        <p class="mt-1.5 text-sm text-navy-500">
            Lihat denda aktif yang perlu dibayar serta riwayat penyelesaian denda keterlambatan Anda.
        </p>
    </div>

    <x-flash-alerts />

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Card: Unpaid Fine Count -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-navy-400 uppercase tracking-wider">Total Denda Belum Dibayar</span>
                <h3 class="font-serif text-3xl font-bold text-coral-600 mt-2">
                    Rp{{ number_format($unpaidFines->sum('amount'), 0, ',', '.') }}
                </h3>
                <p class="text-xxs text-navy-500 mt-1">Dari {{ $unpaidFines->count() }} transaksi denda aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-coral-500/10 flex items-center justify-center text-coral-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Card: Info/Policy -->
        <div class="bg-cream-100/40 border border-cream-300 rounded-xl p-6 shadow-sm flex items-start space-x-4">
            <div class="w-10 h-10 rounded-lg bg-navy-800/10 flex items-center justify-center text-navy-800 shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-serif text-sm font-bold text-navy-950">Kebijakan Denda LibraryGenz</h4>
                <p class="text-xs text-navy-600 mt-1.5 leading-relaxed">
                    Denda keterlambatan dihitung otomatis sejak hari pertama keterlambatan setelah batas waktu pinjam berakhir (7 hari) sebesar <span class="font-bold text-coral-600">Rp2.000 per hari</span>. Pembayaran dapat dilakukan langsung secara tunai melalui Pustakawan.
                </p>
            </div>
        </div>
    </div>

    <!-- Alpine.js Tabs Wrapper -->
    <div x-data="{ activeTab: 'unpaid' }" class="space-y-6">
        <!-- Tab Headers -->
        <div class="border-b border-cream-300">
            <nav class="-mb-px flex space-x-8">
                <!-- Tab: Unpaid -->
                <button @click="activeTab = 'unpaid'"
                    :class="activeTab === 'unpaid' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700 hover:border-cream-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-serif text-sm font-bold flex items-center">
                    Denda Aktif
                    <span :class="activeTab === 'unpaid' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                        class="ml-2 py-0.5 px-2.5 rounded-full text-xxs font-bold transition-colors">
                        {{ $unpaidFines->count() }}
                    </span>
                </button>

                <!-- Tab: Resolved -->
                <button @click="activeTab = 'resolved'"
                    :class="activeTab === 'resolved' ? 'border-coral-500 text-coral-600' : 'border-transparent text-navy-500 hover:text-navy-700 hover:border-cream-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-serif text-sm font-bold flex items-center">
                    Riwayat Denda
                    <span :class="activeTab === 'resolved' ? 'bg-coral-100 text-coral-800' : 'bg-cream-200 text-navy-700'"
                        class="ml-2 py-0.5 px-2.5 rounded-full text-xxs font-bold transition-colors">
                        {{ $resolvedFines->count() }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- TAB CONTENT: UNPAID FINES -->
        <div x-show="activeTab === 'unpaid'" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Batas Waktu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Keterlambatan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Jumlah Denda</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Penyelesaian</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @forelse($unpaidFines as $fine)
                            <tr class="hover:bg-cream-100/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-xs font-semibold text-navy-900">{{ $fine->borrowing->book->title }}</div>
                                    <div class="text-xxs text-navy-400 mt-0.5">Karya {{ $fine->borrowing->book->author }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                    {{ $fine->borrowing->due_date ? $fine->borrowing->due_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                    {{ $fine->borrowing->return_date ? $fine->borrowing->return_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-800">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-coral-100 text-coral-800">
                                        {{ $fine->late_days }} hari
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-coral-600">
                                    Rp{{ number_format($fine->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-coral-100 text-coral-800">
                                        Belum Dibayar
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-navy-500 max-w-xs">
                                    Silakan temui pustakawan untuk membayar denda ini.
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-xs text-navy-400">
                                    Hebat! Anda tidak memiliki denda aktif saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($unpaidFines->hasPages())
                <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                    {{ $unpaidFines->links() }}
                </div>
            @endif
        </div>

        <!-- TAB CONTENT: RESOLVED FINES -->
        <div x-show="activeTab === 'resolved'" style="display: none;" class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Terlambat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Jumlah Denda</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Tanggal Selesai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @forelse($resolvedFines as $fine)
                            <tr class="hover:bg-cream-100/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-xs font-semibold text-navy-900">{{ $fine->borrowing->book->title }}</div>
                                    <div class="text-xxs text-navy-400 mt-0.5">Karya {{ $fine->borrowing->book->author }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                    {{ $fine->late_days }} hari
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-navy-950">
                                    Rp{{ number_format($fine->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($fine->status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-800">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-navy-100 text-navy-800">
                                            Dibebaskan (Waived)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                    {{ $fine->paid_at ? $fine->paid_at->translatedFormat('d M Y H:i') : $fine->updated_at->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-navy-500 max-w-xs truncate">
                                    {{ $fine->notes ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-xs text-navy-400">
                                    Belum ada riwayat penyelesaian denda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($resolvedFines->hasPages())
                <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                    {{ $resolvedFines->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
