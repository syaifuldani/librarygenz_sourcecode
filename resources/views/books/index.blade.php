<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Katalog <span class="text-coral-500">Pustaka</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                @if(Auth::user()->isAdmin() || Auth::user()->isLibrarian())
                    Kelola stok, data katalog, dan informasi koleksi buku perpustakaan LibraryGenz.
                @else
                    Jelajahi koleksi buku perpustakaan LibraryGenz yang dapat dipinjam.
                @endif
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            @if(Auth::user()->isAdmin() || Auth::user()->isLibrarian())
                <a href="{{ route('reports.export.books', request()->only(['search', 'category_id', 'availability', 'stock_min'])) }}"
                   class="inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>
                <a href="{{ route('books.create') }}"
                   class="inline-flex items-center gap-1.5 bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Buku
                </a>
            @endif
        </div>
    </div>

    <x-flash-alerts />

    <!-- Search & Filter Controls -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-4 sm:p-5 mb-6 shadow-sm">
        <form action="{{ route('books.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3 items-end flex-wrap">
                <!-- Search -->
                <div class="flex-1 min-w-0">
                    <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Pencarian</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Judul atau penulis..."
                               class="w-full pl-9 pr-4 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">
                    </div>
                </div>

                <!-- Category -->
                <div class="w-full sm:w-44">
                    <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Kategori</label>
                    <select name="category_id"
                            class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Availability -->
                <div class="w-full sm:w-40">
                    <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Ketersediaan</label>
                    <select name="availability"
                            class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                        <option value="">Semua</option>
                        <option value="available"   {{ request('availability') === 'available'   ? 'selected' : '' }}>Tersedia</option>
                        <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-5 py-2 rounded-lg text-xs font-bold transition-colors">
                        Cari
                    </button>
                    @if(request()->anyFilled(['search','category_id','availability']))
                        <a href="{{ route('books.index') }}"
                           class="border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-4 py-2 rounded-lg text-xs font-semibold transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Results summary -->
    @if(request()->anyFilled(['search','category_id','availability']))
        <p class="text-xs text-navy-500 mb-4">
            Menampilkan <span class="font-bold text-navy-800">{{ $books->total() }}</span> hasil
            @if(request('search')) untuk "<span class="font-bold text-coral-600">{{ request('search') }}</span>"@endif
        </p>
    @endif

    <!-- ============================================================
         MEMBER: Card Grid View
    ============================================================ -->
    @if(Auth::user()->isMember())
        @if($books->isEmpty())
            <div class="bg-cream-50 border border-cream-300 rounded-xl shadow-sm">
                <x-empty-state
                    type="{{ request()->anyFilled(['search','category_id','availability']) ? 'search' : 'books' }}"
                    title="{{ request()->anyFilled(['search','category_id','availability']) ? 'Tidak Ada Hasil Pencarian' : 'Katalog Masih Kosong' }}"
                    message="{{ request()->anyFilled(['search','category_id','availability']) ? 'Coba ubah kata kunci atau filter pencarian Anda.' : 'Belum ada buku yang terdaftar dalam katalog perpustakaan.' }}"
                />
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($books as $book)
                    <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <!-- Cover -->
                        <div class="aspect-[3/4] w-full bg-cream-200 flex items-center justify-center overflow-hidden border-b border-cream-200 relative">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                     alt="Sampul {{ $book->title }}"
                                     class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full p-5 flex flex-col justify-between text-center bg-navy-800 text-cream-100">
                                    <div class="border border-cream-400/20 p-3 h-full flex flex-col justify-between">
                                        <span class="text-xxs font-semibold uppercase tracking-wider text-coral-400">{{ $book->category->name }}</span>
                                        <h4 class="font-serif text-sm font-bold tracking-tight leading-tight line-clamp-3 text-cream-50">{{ $book->title }}</h4>
                                        <span class="text-xxs italic text-navy-300">{{ $book->author }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute top-2.5 right-2.5">
                                @if($book->stock > 0)
                                    <span class="bg-emerald-100 text-emerald-800 text-xxs font-bold px-2 py-0.5 rounded-full shadow-sm">
                                        Tersedia ({{ $book->stock }})
                                    </span>
                                @else
                                    <span class="bg-coral-100 text-coral-800 text-xxs font-bold px-2 py-0.5 rounded-full shadow-sm">
                                        Kosong
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-xxs font-semibold text-coral-500 uppercase tracking-widest">{{ $book->category->name }}</span>
                                <h4 class="font-serif text-base font-bold text-navy-950 mt-1 line-clamp-1" title="{{ $book->title }}">{{ $book->title }}</h4>
                                <p class="text-xs text-navy-500 mt-0.5">Karya {{ $book->author }}</p>
                                @if($book->description)
                                    <p class="text-xxs text-navy-400 mt-2 line-clamp-2">{{ $book->description }}</p>
                                @endif
                            </div>
                            <div class="mt-4">
                                @if($book->stock > 0)
                                    <form action="{{ route('borrowings.request', $book) }}" method="POST"
                                          onsubmit="event.preventDefault(); confirmAction(this, 'Ajukan Peminjaman', 'Ajukan peminjaman buku &quot;{{ addslashes($book->title) }}&quot;?', 'Ya, Ajukan', false)">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-navy-800 hover:bg-navy-900 text-cream-100 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                            Ajukan Pinjam
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                            class="w-full bg-cream-200 text-navy-300 py-1.5 rounded-lg text-xs font-bold cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
                <div class="mt-6">{{ $books->links() }}</div>
            @endif
        @endif

    <!-- ============================================================
         ADMIN / LIBRARIAN: Table View
    ============================================================ -->
    @else
        <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
                <div>
                    <h4 class="font-serif text-base font-bold text-navy-950">Inventaris Katalog</h4>
                    <p class="text-xs text-navy-500 mt-0.5">Buku fisik perpustakaan beserta status stok.</p>
                </div>
                <span class="text-xxs font-semibold bg-cream-200 text-navy-700 py-1 px-3 rounded-lg border border-cream-300">
                    {{ number_format($books->total()) }} buku
                </span>
            </div>

            @if($books->isEmpty())
                <x-empty-state
                    type="{{ request()->anyFilled(['search','category_id','availability']) ? 'search' : 'books' }}"
                    title="{{ request()->anyFilled(['search','category_id','availability']) ? 'Tidak Ada Hasil' : 'Katalog Masih Kosong' }}"
                    message="{{ request()->anyFilled(['search','category_id','availability']) ? 'Tidak ada buku yang cocok dengan filter Anda.' : 'Mulai tambahkan buku ke katalog perpustakaan.' }}"
                    :action="Auth::user()->isAdmin() || Auth::user()->isLibrarian() ? ['label' => '+ Tambah Buku', 'href' => route('books.create')] : null"
                />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider w-14">Sampul</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Judul & Penulis</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider w-24">Stok</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($books as $book)
                                <tr class="hover:bg-cream-100/20 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="w-10 h-14 bg-cream-200 border border-cream-300 rounded overflow-hidden shadow-sm flex items-center justify-center">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="" class="object-cover w-full h-full">
                                            @else
                                                <div class="w-full h-full bg-navy-800 text-[6px] text-cream-200 p-1 flex items-center justify-center font-bold font-serif text-center leading-none">BOOK</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-navy-900">{{ $book->title }}</div>
                                        <div class="text-xxs text-navy-400 mt-0.5">Karya {{ $book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-navy-100 text-navy-800">
                                            {{ $book->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($book->stock > 0)
                                            <span class="text-xs font-bold text-navy-900">{{ $book->stock }} unit</span>
                                        @else
                                            <span class="text-xs font-bold text-coral-600">Habis (0)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold space-x-3">
                                        <a href="{{ route('books.edit', $book) }}" class="text-coral-500 hover:text-coral-700 transition-colors">Edit</a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline"
                                              onsubmit="event.preventDefault(); confirmAction(this, 'Hapus Buku', 'Hapus &quot;{{ addslashes($book->title) }}&quot; dari katalog? Tindakan ini tidak dapat dibatalkan.', 'Ya, Hapus')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-navy-400 hover:text-coral-700 transition-colors">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex items-center justify-between">
                    <span class="text-xs text-navy-500">
                        Menampilkan {{ $books->firstItem() }}–{{ $books->lastItem() }} dari {{ $books->total() }} buku
                    </span>
                    @if($books->hasPages())
                        {{ $books->links() }}
                    @endif
                </div>
            @endif
        </div>
    @endif
</x-app-layout>
