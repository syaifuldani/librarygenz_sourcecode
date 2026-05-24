<x-guest-layout>
    <div class="mb-6">
        <h3 class="font-serif text-2xl font-bold text-navy-900">Selamat Datang</h3>
        <p class="text-xs text-navy-500 mt-1">Silakan masuk ke akun Anda untuk mengakses dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded border-cream-300 bg-cream-50/20 text-coral-500 focus:ring-coral-500 focus:ring-offset-0 shadow-sm" name="remember">
                <span class="ms-2 text-xs text-navy-600 font-medium">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-navy-500 hover:text-coral-500 transition-colors font-medium" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <x-primary-button class="w-full py-3" ::disabled="loading">
                <span x-show="!loading">{{ __('Masuk Sistem') }}</span>
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
        <a class="text-navy-600 hover:text-coral-500 transition-colors font-bold" href="{{ route('register') }}">
            Daftar Anggota Baru &rarr;
        </a>
    </div>
</x-guest-layout>
