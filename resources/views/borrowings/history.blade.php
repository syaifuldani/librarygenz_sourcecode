<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Riwayat <span class="text-coral-500">Peminjaman Anda</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Pantau permohonan aktif, batas waktu pengembalian, dan riwayat buku yang telah Anda baca.
            </p>
        </div>
        <a href="{{ route('books.index') }}"
           class="shrink-0 bg-coral-500 hover:bg-coral-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
            Cari & Pinjam Buku
        </a>
    </div>

    <x-flash-alerts />

    <!-- Filter Bar -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('borrowings.history') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Status</label>
                <select name="status"
                        class="px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    <option value="">Semua Status</option>
                    <option value="requested" {{ request('status') === 'requested' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="approved"  {{ request('status') === 'approved'  ? 'selected' : '' }}>Disetujui</option>
                    <option value="borrowed"  {{ request('status') === 'borrowed'  ? 'selected' : '' }}>Sedang Dibaca</option>
                    <option value="overdue"   {{ request('status') === 'overdue'   ? 'selected' : '' }}>Terlambat</option>
                    <option value="returned"  {{ request('status') === 'returned'  ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit"
                    class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-4 py-2 rounded-lg text-xs font-bold transition-colors">
                Filter
            </button>
            @if(request()->filled('status'))
                <a href="{{ route('borrowings.history') }}"
                   class="border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-4 py-2 rounded-lg text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
            <div>
                <h4 class="font-serif text-base font-bold text-navy-950">Aktivitas Peminjaman Buku</h4>
                <p class="text-xs text-navy-500 mt-0.5">Daftar lengkap permohonan dan riwayat transaksi peminjaman Anda.</p>
            </div>
            <span class="text-xxs font-semibold bg-cream-200 text-navy-700 py-1 px-3 rounded-lg border border-cream-300">
                {{ $borrowings->total() }} catatan
            </span>
        </div>

        @if($borrowings->isEmpty())
            <x-empty-state
                type="{{ request()->filled('status') ? 'search' : 'borrowings' }}"
                title="{{ request()->filled('status') ? 'Tidak Ada Hasil' : 'Belum Ada Peminjaman' }}"
                message="{{ request()->filled('status') ? 'Tidak ada peminjaman dengan status yang dipilih.' : 'Anda belum pernah melakukan peminjaman buku. Mulai jelajahi katalog kami.' }}"
                :action="['label' => 'Jelajahi Katalog', 'href' => route('books.index')]"
            />
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider w-12">Sampul</th>
                            <th class="px-4 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Buku</th>
                            <th class="px-4 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden md:table-cell">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden md:table-cell">Batas Kembali</th>
                            <th class="px-4 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @foreach($borrowings as $borrowing)
                            <tr class="hover:bg-cream-100/20 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="w-9 h-12 bg-cream-200 border border-cream-300 rounded overflow-hidden shadow-sm flex items-center justify-center">
                                        @if($borrowing->book->cover_image)
                                            <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" alt="" class="object-cover w-full h-full">
                                        @else
                                            <div class="w-full h-full bg-navy-800 text-[5px] text-cream-200 p-1 flex items-center justify-center font-bold font-serif text-center leading-none">BOOK</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-xs font-bold text-navy-900">{{ $borrowing->book->title }}</div>
                                    <div class="text-xxs text-navy-400 mt-0.5">{{ $borrowing->book->author }} &bull; <span class="text-coral-500">{{ $borrowing->book->category->name }}</span></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-xs text-navy-600 hidden md:table-cell">
                                    {{ $borrowing->borrow_date ? $borrowing->borrow_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-xs hidden md:table-cell">
                                    @if($borrowing->due_date)
                                        @if($borrowing->status === 'overdue')
                                            <span class="text-coral-600 font-bold">{{ $borrowing->due_date->translatedFormat('d M Y') }}</span>
                                        @else
                                            <span class="text-navy-600">{{ $borrowing->due_date->translatedFormat('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span class="text-navy-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @switch($borrowing->status)
                                        @case('requested')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-amber-100 text-amber-800">Menunggu</span>
                                            @break
                                        @case('approved')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-blue-100 text-blue-800">Disetujui</span>
                                            @break
                                        @case('borrowed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-800">Dipinjam</span>
                                            @break
                                        @case('returned')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-cream-300 text-navy-700">Dikembalikan</span>
                                            @break
                                        @case('rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-coral-100 text-coral-800">Ditolak</span>
                                            @break
                                        @case('overdue')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-coral-200 text-coral-900 border border-coral-400 animate-pulse">Terlambat</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                    @if($borrowing->status === 'requested')
                                        <form action="{{ route('borrowings.cancel', $borrowing) }}" method="POST" class="inline"
                                              onsubmit="event.preventDefault(); confirmAction(this, 'Batalkan Permintaan', 'Batalkan permohonan peminjaman buku &quot;{{ addslashes($borrowing->book->title) }}&quot;?', 'Ya, Batalkan')">
                                            @csrf
                                            <button type="submit" class="text-coral-500 hover:text-coral-700 transition-colors">Batalkan</button>
                                        </form>
                                    @else
                                        <span class="text-navy-300">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex flex-col sm:flex-row items-center justify-between gap-3">
                <span class="text-xs text-navy-500">
                    Menampilkan {{ $borrowings->firstItem() }}–{{ $borrowings->lastItem() }} dari {{ $borrowings->total() }} catatan
                </span>
                @if($borrowings->hasPages())
                    {{ $borrowings->links() }}
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
