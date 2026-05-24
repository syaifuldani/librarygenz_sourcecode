<x-guest-layout>
    <div class="mb-6">
        <h3 class="font-serif text-2xl font-bold text-navy-900">Mulai Peminjaman Buku Mandiri</h3>
        <p class="text-xs text-navy-500 mt-1">Daftarkan akun anggota Anda untuk menikmati layanan perpustakaan digital:</p>
        <ul class="mt-3 space-y-1.5 text-navy-600 text-xxs">
            <li class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-coral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Akses katalog buku lengkap 24/7</span>
            </li>
            <li class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-coral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Ajukan & batalkan peminjaman secara mandiri</span>
            </li>
            <li class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-coral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Pantau tagihan denda dengan rincian transparan</span>
            </li>
        </ul>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter (kombinasi huruf & angka)" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <x-primary-button class="w-full py-3" ::disabled="loading">
                <span x-show="!loading">{{ __('Daftar Sekarang') }}</span>
                <span x-show="loading" class="flex items-center justify-center" style="display: none;">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Memproses...') }}
                </span>
            </x-primary-button>
        </div>
    </form>

    <!-- Bottom Links -->
    <div class="mt-6 pt-6 border-t border-cream-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
        <a class="text-navy-500 hover:text-coral-500 transition-colors font-medium flex items-center gap-1.5" href="/">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Beranda
        </a>
        <a class="text-navy-600 hover:text-coral-500 transition-colors font-bold" href="{{ route('login') }}">
            Sudah punya akun? Masuk &rarr;
        </a>
    </div>
</x-guest-layout>
