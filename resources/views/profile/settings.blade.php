<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
            Pengaturan <span class="text-coral-500">Akun</span>
        </h2>
        <p class="mt-2 text-sm text-navy-500">
            Ubah kata sandi Anda dan kelola status keamanan akun Anda.
        </p>
    </div>

    <!-- Alert Notifications -->
    @if(session('status') === 'password-updated')
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Kata sandi berhasil diperbarui!
        </div>
    @endif

    <div class="max-w-4xl space-y-8">
        <!-- Card 1: Update Password -->
        <div class="p-6 sm:p-8 bg-cream-50 border border-cream-300 rounded-xl shadow-sm">
            <div class="max-w-xl">
                <header class="mb-6">
                    <h3 class="font-serif text-lg font-bold text-navy-950">
                        Ganti Kata Sandi
                    </h3>
                    <p class="mt-1 text-xs text-navy-500">
                        Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="update_password_current_password" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Kata Sandi Saat Ini</label>
                        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                        <x-input-error class="mt-1.5" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <div>
                        <label for="update_password_password" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Kata Sandi Baru</label>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                        <x-input-error class="mt-1.5" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <div>
                        <label for="update_password_password_confirmation" class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Konfirmasi Kata Sandi Baru</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                        <x-input-error class="mt-1.5" :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-coral-500 hover:bg-coral-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors duration-150">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card 2: Delete Account -->
        <div class="p-6 sm:p-8 bg-cream-50 border border-cream-300 rounded-xl shadow-sm">
            <div class="max-w-xl">
                <header class="mb-6">
                    <h3 class="font-serif text-lg font-bold text-navy-950">
                        Hapus Akun
                    </h3>
                    <p class="mt-1 text-xs text-navy-500">
                        Setelah akun Anda dihapus, semua sumber daya dan data terkait akan dihapus secara permanen.
                    </p>
                </header>

                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                >Hapus Akun Saya</x-danger-button>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-cream-50">
                        @csrf
                        @method('delete')

                        <h2 class="font-serif text-lg font-bold text-navy-950">
                            Apakah Anda yakin ingin menghapus akun Anda?
                        </h2>

                        <p class="mt-2 text-xs text-navy-500 leading-relaxed">
                            Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                        </p>

                        <div class="mt-4">
                            <label for="password" class="sr-only">Kata Sandi</label>
                            <input id="password" name="password" type="password" placeholder="Kata Sandi Anda" required
                                class="block w-full px-3 py-2 text-xs bg-cream-50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
                            <x-input-error class="mt-1.5" :messages="$errors->userDeletion->get('password')" />
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                Batal
                            </x-secondary-button>

                            <x-danger-button type="submit">
                                Ya, Hapus Permanen
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </div>
</x-app-layout>
