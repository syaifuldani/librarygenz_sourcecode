<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}"
           class="p-2 rounded-lg text-navy-500 hover:text-navy-800 hover:bg-cream-200/50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Tambah <span class="text-coral-500">Pengguna Baru</span>
            </h2>
            <p class="mt-1 text-sm text-navy-500">Buat akun Admin, Pustakawan, atau Anggota baru di LibraryGenz.</p>
        </div>
    </div>

    <x-flash-alerts />

    <div class="max-w-2xl">
        <div class="bg-cream-50 border border-cream-300 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Informasi Akun</h4>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="px-6 py-6 space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">
                        Nama Lengkap <span class="text-coral-500">*</span>
                    </label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('name') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    @error('name')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">
                        Alamat Email <span class="text-coral-500">*</span>
                    </label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('email') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    @error('email')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">
                        Kata Sandi <span class="text-coral-500">*</span>
                    </label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('password') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    <p class="mt-1 text-xxs text-navy-400">Minimal 8 karakter, kombinasikan huruf dan angka.</p>
                    @error('password')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role_id" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">
                        Peran (Role) <span class="text-coral-500">*</span>
                    </label>
                    <select id="role_id" name="role_id" required
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('role_id') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                        <option value="">— Pilih Peran —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide mb-1.5">
                        Status Akun <span class="text-coral-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                   {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                                   class="accent-coral-500">
                            <span class="text-xs font-semibold text-emerald-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                   {{ old('status') === 'inactive' ? 'checked' : '' }}
                                   class="accent-coral-500">
                            <span class="text-xs font-semibold text-navy-600">Nonaktif</span>
                        </label>
                    </div>
                    @error('status')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 pt-3 border-t border-cream-300">
                    <button type="submit"
                            class="bg-coral-500 hover:bg-coral-600 active:bg-coral-700 text-white px-5 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                        Buat Akun
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-5 py-2 rounded-lg text-xs font-bold transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
