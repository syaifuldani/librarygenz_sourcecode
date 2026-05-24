<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
            Pengaturan <span class="text-coral-500">Sistem LibraryGenz</span>
        </h2>
            <p class="mt-2 text-sm text-navy-500">
                Kelola parameter operasional perpustakaan, aturan denda, batas peminjaman, dan konfigurasi database.
            </p>
    </div>

    <!-- Settings Forms Grid -->
    <div class="max-w-4xl space-y-8">
        <!-- Section 1: Library Policy Rules -->
        <div class="p-6 sm:p-8 bg-cream-50 border border-cream-300 rounded-xl shadow-sm">
            <h3 class="font-serif text-lg font-bold text-navy-950 mb-2">Aturan Kebijakan Perpustakaan</h3>
            <p class="text-xs text-navy-500 mb-6">Parameter durasi pinjam dan perhitungan denda otomatis.</p>

            <form class="space-y-4" onsubmit="event.preventDefault(); alert('Pengaturan sistem berhasil disimpan! (Mock Mode)');">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Tarif Denda Flat (Rupiah)</label>
                        <div class="mt-1.5 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-navy-500 text-xs">Rp</span>
                            </div>
                            <input type="number" value="2000" readonly
                                class="pl-8 block w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-700 cursor-not-allowed">
                        </div>
                        <p class="mt-1.5 text-xxs text-navy-400">Tarif denda keterlambatan buku per hari (tetap Rp2.000).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Durasi Peminjaman Default (Hari)</label>
                        <div class="mt-1.5 relative rounded-md shadow-sm">
                            <input type="number" value="7" readonly
                                class="block w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-700 cursor-not-allowed">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-navy-500 text-xs">Hari</span>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xxs text-navy-400">Durasi awal peminjaman buku sebelum berstatus overdue.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Maksimal Buku Dipinjam Bersamaan</label>
                        <input type="number" value="3" readonly
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-700 cursor-not-allowed">
                        <p class="mt-1.5 text-xxs text-navy-400">Batas maksimal peminjaman aktif per anggota secara bersamaan.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-navy-800 uppercase tracking-wide">Nama Aplikasi Sistem</label>
                        <input type="text" value="LibraryGenz" readonly
                            class="mt-1.5 block w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-700 cursor-not-allowed">
                        <p class="mt-1.5 text-xxs text-navy-400">Identitas nama sistem perpustakaan digital.</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-cream-300 flex items-center justify-between">
                    <span class="text-xxs text-coral-600 font-semibold italic">* Konfigurasi operasional disinkronkan dengan librarygenz_ai_rules.md</span>
                    <button type="submit" class="bg-coral-500 hover:bg-coral-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors duration-150">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <!-- Section 2: Database Operations & Backups -->
        <div class="p-6 sm:p-8 bg-cream-50 border border-cream-300 rounded-xl shadow-sm">
            <h3 class="font-serif text-lg font-bold text-navy-950 mb-2">Pemeliharaan & Keamanan</h3>
            <p class="text-xs text-navy-500 mb-6">Operasi pemeliharaan database dan audit trails LibraryGenz.</p>

            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-cream-100/30 rounded-lg border border-cream-300 gap-4">
                    <div>
                        <h4 class="text-xs font-bold text-navy-900">Salin Cadangan Database (Backup)</h4>
                        <p class="text-xxs text-navy-500 mt-1">Unduh salinan data sistem lengkap dalam format .sql.</p>
                    </div>
                    <button onclick="alert('Database berhasil di-backup!');" class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors duration-150 shrink-0">
                        Jalankan Backup
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-cream-100/30 rounded-lg border border-cream-300 gap-4">
                    <div>
                        <h4 class="text-xs font-bold text-navy-900">Bersihkan Audit Trail Aktivitas</h4>
                        <p class="text-xxs text-navy-500 mt-1">Hapus log aktivitas lama yang berusia lebih dari 90 hari.</p>
                    </div>
                    <button onclick="alert('Log lama berhasil dibersihkan!');" class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-3 py-1.5 rounded-lg text-xxs font-bold shadow-sm transition-colors duration-150 shrink-0">
                        Bersihkan Log Lama
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
