<x-app-layout>
    <!-- Header -->
    <div class="mb-6">
        <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
            Kelola <span class="text-coral-500">Kategori Buku</span>
        </h2>
        <p class="mt-1.5 text-sm text-navy-500">
            Definisikan kategori pustaka untuk memudahkan pengelompokan dan pencarian koleksi buku.
        </p>
    </div>

    <x-flash-alerts />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Add Category Form -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm h-fit">
            <h4 class="font-serif text-base font-bold text-navy-950 mb-4">Tambah Kategori Baru</h4>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-bold text-navy-700 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                        <input type="text" name="name" id="name" required
                               placeholder="Contoh: Fiksi, Sejarah, Sains"
                               class="w-full px-3 py-2 text-xs bg-cream-100/60 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">
                        @error('name')
                            <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white py-2 px-4 rounded-lg text-xs font-bold shadow-sm transition-colors">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>

        <!-- Categories Table -->
        <div class="lg:col-span-2 bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
                <div>
                    <h4 class="font-serif text-base font-bold text-navy-950">Daftar Kategori</h4>
                    <p class="text-xs text-navy-500 mt-0.5">Semua kategori dan jumlah koleksi buku terkait.</p>
                </div>
                <span class="text-xxs font-semibold bg-cream-200 text-navy-700 py-1 px-3 rounded-lg border border-cream-300">
                    {{ $categories->count() }} kategori
                </span>
            </div>

            @if($categories->isEmpty())
                <x-empty-state type="books" title="Belum Ada Kategori"
                    message="Tambahkan kategori pertama untuk mulai mengelompokkan koleksi buku." />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream-300">
                        <thead class="bg-cream-100/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider w-12">No</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider w-28">Koleksi</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                            @foreach($categories as $index => $category)
                                <tr class="hover:bg-cream-100/20 transition-colors"
                                    x-data="{ editing: false, name: '{{ addslashes($category->name) }}' }">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div x-show="!editing" class="text-xs font-semibold text-navy-900">
                                            {{ $category->name }}
                                        </div>
                                        <div x-show="editing" style="display:none;">
                                            <form action="{{ route('categories.update', $category) }}" method="POST"
                                                  class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" x-model="name" required
                                                       class="px-2 py-1.5 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                                                <button type="submit"
                                                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-2.5 py-1 rounded-lg text-xxs font-bold transition-colors">
                                                    Simpan
                                                </button>
                                                <button type="button" @click="editing = false"
                                                        class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-2.5 py-1 rounded-lg text-xxs font-bold transition-colors">
                                                    Batal
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-navy-100 text-navy-800">
                                            {{ $category->books_count }} buku
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                        <template x-if="!editing">
                                            <div class="inline-flex items-center justify-end gap-3">
                                                <button @click="editing = true"
                                                        class="text-coral-500 hover:text-coral-700 font-bold transition-colors">
                                                    Ubah
                                                </button>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                                      onsubmit="event.preventDefault(); confirmAction(this, 'Hapus Kategori', 'Hapus kategori &quot;{{ addslashes($category->name) }}&quot;? Pastikan tidak ada buku yang terhubung.', 'Ya, Hapus')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-navy-400 hover:text-coral-700 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-cream-300 bg-cream-100/10 text-xs text-navy-500">
                    Total {{ $categories->count() }} kategori terdaftar
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
