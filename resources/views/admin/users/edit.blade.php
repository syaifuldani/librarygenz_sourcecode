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
                Edit Akun <span class="text-coral-500">{{ $user->name }}</span>
            </h2>
            <p class="mt-1 text-sm text-navy-500">Perbarui profil, role, status, atau reset kata sandi pengguna.</p>
        </div>
    </div>

    <x-flash-alerts />

    <div class="max-w-2xl space-y-5">

        <!-- Card 1: Profile & Role -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Informasi Profil & Peran</h4>
            </div>
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="px-6 py-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('name') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    @error('name')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('email') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    @error('email')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="role_id" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Peran (Role)</label>
                    <select id="role_id" name="role_id" required
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('role_id') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide mb-1.5">Status Akun</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                   {{ old('status', $user->status) === 'active' ? 'checked' : '' }}
                                   class="accent-coral-500">
                            <span class="text-xs font-semibold text-emerald-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                   {{ old('status', $user->status) === 'inactive' ? 'checked' : '' }}
                                   class="accent-coral-500">
                            <span class="text-xs font-semibold text-navy-600">Nonaktif</span>
                        </label>
                    </div>
                    @error('status')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-cream-300">
                    <button type="submit"
                            class="bg-coral-500 hover:bg-coral-600 text-white px-5 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Reset Password -->
        <div class="bg-cream-50 border border-cream-300 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Reset Kata Sandi</h4>
                <p class="text-xxs text-navy-500 mt-0.5">Tetapkan kata sandi baru untuk pengguna ini secara manual.</p>
            </div>
            <form method="POST" action="{{ route('admin.users.resetPassword', $user) }}" class="px-6 py-6 space-y-5">
                @csrf

                <div>
                    <label for="new_password" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Kata Sandi Baru</label>
                    <input id="new_password" name="new_password" type="password" required autocomplete="new-password"
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border {{ $errors->has('new_password') ? 'border-coral-400' : 'border-cream-300' }} rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    <p class="mt-1 text-xxs text-navy-400">Minimal 8 karakter, kombinasikan huruf dan angka.</p>
                    @error('new_password')<p class="mt-1 text-xxs text-coral-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Konfirmasi Kata Sandi Baru</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password" required
                           class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                </div>

                <div class="pt-3 border-t border-cream-300">
                    <button type="submit"
                            class="bg-navy-800 hover:bg-navy-700 text-cream-100 px-5 py-2 rounded-lg text-xs font-bold transition-colors">
                        Reset Kata Sandi
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 3: Toggle Status -->
        @if($user->id !== Auth::id())
        <div class="bg-cream-50 border border-cream-300 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30">
                <h4 class="font-serif text-base font-bold text-navy-950">Aksi Cepat Akun</h4>
            </div>
            <div class="px-6 py-5 flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold text-navy-800">
                        Status Saat Ini:
                        <span class="ml-1 {{ $user->status === 'active' ? 'text-emerald-600' : 'text-navy-500' }}">
                            {{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </p>
                    <p class="text-xxs text-navy-500 mt-0.5">
                        {{ $user->status === 'active' ? 'Menonaktifkan akun akan memblokir pengguna dari login.' : 'Mengaktifkan kembali akun akan memberikan akses login.' }}
                    </p>
                </div>
                <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="shrink-0"
                      onsubmit="event.preventDefault(); confirmAction(this, '{{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} Akun', '{{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($user->name) }}?', '{{ $user->status === 'active' ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}', {{ $user->status === 'active' ? 'true' : 'false' }})">
                    @csrf
                    <button type="submit"
                            class="text-xs font-bold px-4 py-2 rounded-lg border transition-colors
                            {{ $user->status === 'active'
                                ? 'text-amber-700 border-amber-300 bg-amber-50 hover:bg-amber-100'
                                : 'text-emerald-700 border-emerald-300 bg-emerald-50 hover:bg-emerald-100' }}">
                        {{ $user->status === 'active' ? 'Nonaktifkan Akun' : 'Aktifkan Kembali' }}
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
