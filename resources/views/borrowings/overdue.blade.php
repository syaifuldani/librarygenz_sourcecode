<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Peminjaman <span class="text-coral-500">Overdue (Terlambat)</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Daftar buku yang dipinjam dan telah melewati batas waktu pengembalian.
            </p>
        </div>
        <a href="{{ route('borrowings.manage') }}"
           class="shrink-0 inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-4 py-2 rounded-lg text-xs font-bold transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Kelola Peminjaman
        </a>
    </div>

    <x-flash-alerts />

    <!-- Overdue Table -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
            <h4 class="font-serif text-base font-bold text-navy-950">Daftar Keterlambatan Aktif</h4>
            <p class="text-xs text-navy-500 mt-0.5">Hubungi anggota terkait agar segera mengembalikan buku dan menyelesaikan denda.</p>
        </div>

        @if($overdueBorrowings->isEmpty())
            <x-empty-state type="borrowings" title="Tidak Ada Keterlambatan"
                message="Bersih! Tidak ada peminjaman yang terlambat saat ini. Semua buku dikembalikan tepat waktu." />
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Anggota</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Batas Waktu</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Terlambat</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden sm:table-cell">Est. Denda</th>
                            <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @foreach($overdueBorrowings as $borrowing)
                            @php
                                $daysLate = (int) today()->diffInDays($borrowing->due_date);
                                $estimatedFine = $daysLate * 2000;
                            @endphp
                            <tr class="hover:bg-cream-100/20 transition-colors">
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
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-coral-600 font-semibold hidden sm:table-cell">
                                    {{ $borrowing->due_date ? $borrowing->due_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-coral-100 text-coral-800 border border-coral-200">
                                        {{ $daysLate }} hari
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-navy-900 hidden sm:table-cell">
                                    Rp{{ number_format($estimatedFine, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline"
                                          onsubmit="event.preventDefault(); confirmAction(this, 'Proses Pengembalian', 'Konfirmasi buku &quot;{{ addslashes($borrowing->book->title) }}&quot; sudah diterima? Denda Rp{{ number_format($estimatedFine, 0, ',', '.') }} akan dibuat otomatis.', 'Ya, Proses Kembali')">
                                        @csrf
                                        <button type="submit"
                                                class="bg-coral-500 hover:bg-coral-600 text-white px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors">
                                            Proses Kembali
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-cream-300 bg-cream-100/10 text-xs text-navy-500">
                {{ $overdueBorrowings->count() }} peminjaman terlambat
            </div>
        @endif
    </div>
</x-app-layout>
