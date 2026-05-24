<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
            Profil <span class="text-coral-500">Saya</span>
        </h2>
        <p class="mt-2 text-sm text-navy-500">
            Perbarui informasi dasar profil akun Anda di LibraryGenz.
        </p>
    </div>

    <!-- Alert Notifications -->
    @if(session('status') === 'profile-updated')
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Profil berhasil diperbarui!
        </div>
    @endif

    <div class="max-w-4xl space-y-8">
        <!-- Card 1: Profile Information -->
        <div class="p-6 sm:p-8 bg-cream-50 border border-cream-300 rounded-xl shadow-sm">
            <div class="max-w-xl">
                <header class="mb-6">
                    <h3 class="font-serif text-lg font-bold text-navy-950">
                        Informasi Profil Saya
                    </h3>
                    <p class="mt-1 text-xs text-navy-500">
                        Perbarui nama profil dan alamat email terdaftar akun Anda.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                        <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                        <x-input-error class="mt-1.5" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Peran (Role)</label>
                        <input type="text" value="{{ $user->role ? $user->role->label : 'Member' }}" disabled
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-200 border border-cream-300 rounded-lg text-navy-500 cursor-not-allowed">
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-coral-500 hover:bg-coral-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors duration-150">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
