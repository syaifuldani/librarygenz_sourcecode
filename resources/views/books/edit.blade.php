<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('books.index') }}" class="inline-flex items-center text-xs font-bold text-coral-500 hover:text-coral-600 mb-3 transition-colors">
            &larr; Kembali ke Katalog
        </a>
        <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
            Ubah <span class="text-coral-500">Informasi Buku</span>
        </h2>
        <p class="mt-2 text-sm text-navy-500">
            Perbarui data koleksi, detail sinopsis, atau ubah gambar sampul untuk buku: <span class="font-semibold text-navy-950">"{{ $book->title }}"</span>.
        </p>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 sm:p-8 max-w-3xl shadow-sm">
        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Two-Column Fields: Title & Author -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-semibold text-navy-700 uppercase tracking-wider mb-2">Judul Buku</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $book->title) }}"
                            class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">
                        @error('title')
                            <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div>
                        <label for="author" class="block text-xs font-semibold text-navy-700 uppercase tracking-wider mb-2">Penulis / Pengarang</label>
                        <input type="text" name="author" id="author" required value="{{ old('author', $book->author) }}"
                            class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">
                        @error('author')
                            <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Two-Column Fields: Category & Stock -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Category Selection -->
                    <div>
                        <label for="category_id" class="block text-xs font-semibold text-navy-700 uppercase tracking-wider mb-2">Kategori Buku</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Counter -->
                    <div>
                        <label for="stock" class="block text-xs font-semibold text-navy-700 uppercase tracking-wider mb-2">Stok Jumlah Buku</label>
                        <input type="number" name="stock" id="stock" required min="0" value="{{ old('stock', $book->stock) }}"
                            class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">
                        @error('stock')
                            <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description Textarea -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-navy-700 uppercase tracking-wider mb-2">Sinopsis / Deskripsi Buku</label>
                    <textarea name="description" id="description" rows="5"
                        class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 focus:border-coral-500 transition-colors">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image Section -->
                <div>
                    <label class="block text-xs font-semibold text-navy-700 uppercase tracking-wider mb-2">Gambar Sampul Saat Ini</label>
                    <div class="flex gap-4 items-start mb-4">
                        <div class="w-24 h-32 bg-cream-200 border border-cream-300 rounded-lg overflow-hidden shadow-sm flex items-center justify-center">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Sampul {{ $book->title }}" class="object-cover w-full h-full">
                            @else
                                <div class="text-[8px] text-navy-400 p-2 text-center font-bold">Tanpa Sampul</div>
                            @endif
                        </div>
                        <div class="flex-1 text-xs text-navy-500 pt-2">
                            <p class="font-semibold text-navy-800">Ubah Gambar Sampul</p>
                            <p class="mt-1">Pilih file baru di bawah jika ingin mengganti sampul saat ini. Jika dibiarkan kosong, sampul lama akan tetap digunakan.</p>
                        </div>
                    </div>

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border border-dashed border-cream-300 rounded-lg bg-cream-100/30">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-navy-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-xs text-navy-600">
                                <label for="cover_image" class="relative cursor-pointer rounded-md font-bold text-coral-500 hover:text-coral-600 focus-within:outline-none">
                                    <span>Unggah file sampul baru</span>
                                    <input id="cover_image" name="cover_image" type="file" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xxs text-navy-400">Format PNG, JPG, JPEG, atau WEBP hingga 2MB</p>
                        </div>
                    </div>
                    @error('cover_image')
                        <p class="text-xs text-coral-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Action Buttons -->
                <div class="pt-4 border-t border-cream-300 flex items-center justify-end space-x-3">
                    <a href="{{ route('books.index') }}" class="border border-cream-300 text-navy-500 hover:bg-cream-200/50 px-4 py-2 rounded-lg text-xs font-semibold transition duration-150">
                        Batal
                    </a>
                    <button type="submit" class="bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-5 py-2 rounded-lg text-xs font-bold shadow-sm transition duration-150">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
            
        </form>
    </div>
</x-app-layout>
