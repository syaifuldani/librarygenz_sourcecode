<x-app-layout>
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
                Dashboard <span class="text-coral-500">Administrator</span>
            </h2>
            <p class="mt-2 text-sm text-navy-500">
                Akses penuh sistem, manajemen pengguna, pengaturan denda, dan log audit LibraryGenz.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-cream-200 text-navy-700 border border-cream-300">
                <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-ping"></span>
                Admin Active Session
            </span>
        </div>
    </div>

    <!-- Admin Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Users counter -->
        <div class="bg-navy-800 text-cream-100 p-6 rounded-xl border border-navy-700 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-300 uppercase tracking-wider">Total Pengguna</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-cream-50">{{ $stats['total_users'] }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-400">
                <span class="text-coral-400 font-semibold mr-1">{{ $stats['total_librarians'] }}</span> Pustakawan &bull; <span class="text-coral-400 font-semibold ml-1">{{ $stats['total_members'] }}</span> Anggota
            </div>
        </div>

        <!-- Card 2: Log activity counter -->
        <div class="bg-cream-100/60 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Log Aktivitas Sistem</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-900">{{ number_format($stats['total_activity_logs']) }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                <span class="text-emerald-600 font-semibold mr-1">100%</span> Operasional Normal
            </div>
        </div>

        <!-- Card 3: Library Rules Flat rate -->
        <div class="bg-coral-50 border border-coral-200 p-6 rounded-xl shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-coral-800 uppercase tracking-wider">Aturan Denda Aktif</p>
            <h3 class="font-serif text-2xl font-bold mt-2 text-coral-700">Rp {{ number_format($stats['active_fine_rate'], 0, ',', '.') }}<span class="text-xs font-sans font-normal text-navy-600"> / hari</span></h3>
            <div class="mt-4 flex items-center text-xs text-coral-600">
                Flat denda keterlambatan buku
            </div>
        </div>

        <!-- Card 4: Reports generated -->
        <div class="bg-cream-50 p-6 rounded-xl border border-cream-300 shadow-sm relative overflow-hidden group">
            <p class="text-xs font-semibold text-navy-500 uppercase tracking-wider">Laporan Unduhan</p>
            <h3 class="font-serif text-3xl font-bold mt-2 text-navy-950">{{ $stats['total_reports_available'] }}</h3>
            <div class="mt-4 flex items-center text-xs text-navy-500">
                Laporan & grafik data dinamis
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Users management preview -->
        <div class="lg:col-span-2 bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-5 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
                <div>
                    <h4 class="font-serif text-lg font-bold text-navy-950">Pengguna Terdaftar Terbaru</h4>
                    <p class="text-xs text-navy-500 mt-1">Daftar pengguna terbaru yang bergabung di LibraryGenz.</p>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Bergabung</th>
                            <th scope="col" class="px-6 py-3 text-xxs font-bold text-navy-500 uppercase tracking-wider text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @forelse($stats['recent_users'] as $u)
                        <tr class="hover:bg-cream-100/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-navy-900">{{ $u->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">{{ $u->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->isAdmin())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-navy-800 text-cream-100">
                                        Admin
                                    </span>
                                @elseif($u->isLibrarian())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-coral-500/20 text-coral-700">
                                        Librarian
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-cream-300 text-navy-800">
                                        Member
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                {{ $u->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold text-emerald-600">
                                Aktif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-0">
                                <x-empty-state type="users" title="Belum Ada Pengguna"
                                    message="Belum ada pengguna yang terdaftar di sistem." />
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex items-center justify-between text-xs text-navy-500">
                <span>Total {{ $stats['total_users'] }} Pengguna terdaftar</span>
                <span class="font-bold text-coral-500">LibraryGenz System Security</span>
            </div>
        </div>

        <!-- Right Side Panel: System Control & Server Stats -->
        <div class="space-y-6">
            <!-- System Controls -->
            <div class="bg-cream-50 border border-cream-300 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-lg font-bold text-navy-950 mb-4">Kontrol Cepat Admin</h4>
                <div class="space-y-3">
                    <a href="{{ route('fines.index') }}" class="block w-full text-center bg-coral-500 hover:bg-coral-600 text-white py-2 px-4 rounded-lg text-xs font-bold transition duration-150">
                        Atur & Proses Denda
                    </a>
                    <a href="{{ route('reports.index') }}" class="block w-full text-center border border-cream-300 hover:bg-cream-100/80 text-navy-800 py-2 px-4 rounded-lg text-xs font-bold transition duration-150">
                        Lihat Analitik & Laporan
                    </a>
                    <a href="{{ route('admin.activity-logs') }}" class="block w-full text-center border border-cream-300 hover:bg-cream-100/80 text-navy-800 py-2 px-4 rounded-lg text-xs font-bold transition duration-150">
                        Lihat Audit Logs Aktivitas
                    </a>
                </div>
            </div>

            <!-- Server Stats Panel -->
            <div class="bg-navy-800 border border-navy-700 text-cream-100 rounded-xl p-6 shadow-sm">
                <h4 class="font-serif text-md font-bold text-cream-50 mb-3">Statistik Server</h4>
                <div class="space-y-2 text-xs text-navy-300">
                    <div class="flex justify-between border-b border-navy-700 pb-2">
                        <span>Laravel Version:</span>
                        <span class="text-cream-100 font-mono">{{ $stats['server_stats']['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-navy-700 pb-2">
                        <span>PHP Version:</span>
                        <span class="text-cream-100 font-mono">{{ $stats['server_stats']['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Database Driver:</span>
                        <span class="text-cream-100 font-mono">{{ $stats['server_stats']['db_engine'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
