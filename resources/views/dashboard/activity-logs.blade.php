<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Audit Trail <span class="text-coral-500">Log Aktivitas</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Rekaman lengkap aktivitas sistem: autentikasi, peminjaman, denda, dan administrasi.
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('admin.activity-logs') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Cari Pengguna</label>
                <input type="text" name="user" value="{{ request('user') }}"
                       placeholder="Nama pengguna..."
                       class="w-full px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 placeholder-navy-400 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
            </div>
            <div>
                <label class="block text-xxs font-bold text-navy-500 uppercase tracking-wider mb-1.5">Tipe Aktivitas</label>
                <select name="type"
                        class="px-3 py-2 text-xs bg-cream-100/50 border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
                    <option value="">Semua Tipe</option>
                    <option value="login"         {{ request('type') === 'login'         ? 'selected' : '' }}>Login</option>
                    <option value="logout"        {{ request('type') === 'logout'        ? 'selected' : '' }}>Logout</option>
                    <option value="register"      {{ request('type') === 'register'      ? 'selected' : '' }}>Register</option>
                    <option value="borrow_request"{{ request('type') === 'borrow_request'? 'selected' : '' }}>Borrow Request</option>
                    <option value="approval"      {{ request('type') === 'approval'      ? 'selected' : '' }}>Approval</option>
                    <option value="return"        {{ request('type') === 'return'        ? 'selected' : '' }}>Return</option>
                    <option value="fine_payment"  {{ request('type') === 'fine_payment'  ? 'selected' : '' }}>Fine Payment</option>
                    <option value="export"        {{ request('type') === 'export'        ? 'selected' : '' }}>Export</option>
                </select>
            </div>
            <button type="submit" class="bg-navy-800 hover:bg-navy-900 text-cream-100 px-4 py-2 rounded-lg text-xs font-bold transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['user','type']))
                <a href="{{ route('admin.activity-logs') }}"
                   class="border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-4 py-2 rounded-lg text-xs font-semibold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
            <div>
                <h4 class="font-serif text-base font-bold text-navy-950">Log Audit Keamanan</h4>
                <p class="text-xs text-navy-500 mt-0.5">Pantau aktivitas mencurigakan atau audit proses administrasi.</p>
            </div>
            <span class="text-xxs font-semibold bg-cream-200 text-navy-700 py-1 px-3 rounded-lg border border-cream-300">
                {{ number_format($logs->total()) }} log
            </span>
        </div>

        @if($logs->isEmpty())
            <x-empty-state type="logs" title="Tidak Ada Log"
                message="{{ request()->anyFilled(['user','type']) ? 'Tidak ada log yang cocok dengan filter.' : 'Belum ada aktivitas yang tercatat dalam sistem.' }}" />
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-cream-300">
                    <thead class="bg-cream-100/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider hidden lg:table-cell">IP / UA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                        @foreach($logs as $log)
                            @php
                                $badgeColor = match($log->activity_type) {
                                    'login'          => 'bg-blue-100 text-blue-800',
                                    'logout'         => 'bg-navy-100 text-navy-700',
                                    'register'       => 'bg-purple-100 text-purple-800',
                                    'borrow_request' => 'bg-amber-100 text-amber-800',
                                    'approval'       => 'bg-indigo-100 text-indigo-800',
                                    'return'         => 'bg-emerald-100 text-emerald-800',
                                    'fine_payment'   => 'bg-coral-100 text-coral-800',
                                    'export'         => 'bg-teal-100 text-teal-800',
                                    default          => 'bg-cream-200 text-navy-700',
                                };
                            @endphp
                            <tr class="hover:bg-cream-100/20 transition-colors text-xs">
                                <td class="px-6 py-4 whitespace-nowrap text-navy-500">
                                    {{ $log->created_at->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->user)
                                        <div class="font-semibold text-navy-900">{{ $log->user->name }}</div>
                                        <div class="text-xxs text-navy-400 capitalize">{{ $log->user->role->name ?? '-' }}</div>
                                    @else
                                        <span class="text-navy-400 italic">System</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xxs font-bold uppercase tracking-wide {{ $badgeColor }}">
                                        {{ str_replace('_', ' ', $log->activity_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-navy-700 max-w-sm">
                                    {{ $log->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xxs text-navy-400 hidden lg:table-cell">
                                    <div class="font-mono">{{ $log->ip_address ?? '-' }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10 flex flex-col sm:flex-row items-center justify-between gap-3">
                <span class="text-xs text-navy-500">
                    Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} log
                </span>
                @if($logs->hasPages())
                    {{ $logs->links() }}
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
