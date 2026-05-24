<x-app-layout>
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-navy-900">
                Manajemen <span class="text-coral-500">Pengguna</span>
            </h2>
            <p class="mt-2 text-sm text-navy-500">
                Kelola akun anggota, pustakawan, dan administrator di LibraryGenz.
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('reports.export.users', request()->only(['role', 'status', 'search', 'reg_from', 'reg_to'])) }}"
               class="inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center bg-coral-500 hover:bg-coral-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-coral-50 border border-coral-200 text-coral-800 text-sm rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2 text-coral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="mb-6 bg-cream-50 border border-cream-300 rounded-xl px-5 py-4 flex flex-wrap gap-3 items-end">

        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xxs font-bold text-navy-600 uppercase tracking-wide mb-1.5">Cari Pengguna</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama atau email..."
                       class="block w-full pl-9 pr-4 py-2 text-xs bg-white border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500">
            </div>
        </div>

        <!-- Role Filter -->
        <div>
            <label class="block text-xxs font-bold text-navy-600 uppercase tracking-wide mb-1.5">Filter Role</label>
            <select name="role" class="text-xs bg-white border border-cream-300 rounded-lg text-navy-800 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-coral-500">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                        {{ $role->label }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status Filter -->
        <div>
            <label class="block text-xxs font-bold text-navy-600 uppercase tracking-wide mb-1.5">Status</label>
            <select name="status" class="text-xs bg-white border border-cream-300 rounded-lg text-navy-800 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-coral-500">
                <option value="">Semua Status</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <!-- Date From -->
        <div>
            <label class="block text-xxs font-bold text-navy-600 uppercase tracking-wide mb-1.5">Dari Bergabung</label>
            <input type="date" name="reg_from" value="{{ request('reg_from') }}"
                   class="px-3 py-1.5 text-xs bg-white border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
        </div>

        <!-- Date To -->
        <div>
            <label class="block text-xxs font-bold text-navy-600 uppercase tracking-wide mb-1.5">Sampai Bergabung</label>
            <input type="date" name="reg_to" value="{{ request('reg_to') }}"
                   class="px-3 py-1.5 text-xs bg-white border border-cream-300 rounded-lg text-navy-800 focus:outline-none focus:ring-1 focus:ring-coral-500 transition-colors">
        </div>

        <button type="submit"
                class="bg-navy-800 hover:bg-navy-700 text-cream-100 px-4 py-2 rounded-lg text-xs font-bold transition-colors shrink-0">
            Cari & Filter
        </button>
        @if(request()->anyFilled(['search','role','status','reg_from','reg_to']))
            <a href="{{ route('admin.users.index') }}"
               class="border border-cream-300 hover:bg-cream-200/50 text-navy-600 px-4 py-2 rounded-lg text-xs font-bold transition-colors shrink-0">
                Reset
            </a>
        @endif
    </form>

    <!-- User Table -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
            <h4 class="font-serif text-base font-bold text-navy-950">Semua Akun Pengguna</h4>
            <span class="text-xxs font-semibold bg-cream-200 text-navy-700 py-1 px-3 rounded-lg border border-cream-300">
                {{ number_format($users->total()) }} Akun
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-cream-300">
                <thead class="bg-cream-100/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-right text-xxs font-bold text-navy-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                    @forelse($users as $u)
                        <tr class="hover:bg-cream-100/20 transition-colors {{ $u->status === 'inactive' ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full {{ $u->status === 'inactive' ? 'bg-navy-400' : 'bg-navy-800' }} text-cream-100 flex items-center justify-center font-bold text-xs uppercase mr-3 shrink-0">
                                        {{ substr($u->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-semibold text-navy-900">{{ $u->name }}</div>
                                        <div class="text-xxs text-navy-400">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->isAdmin())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-navy-800 text-cream-100">Admin</span>
                                @elseif($u->isLibrarian())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-coral-500/20 text-coral-700">Librarian</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-cream-300 text-navy-800">Member</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-cream-200 text-navy-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-navy-400 mr-1.5"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-500">
                                {{ $u->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.users.edit', $u) }}"
                                       class="text-xxs font-bold text-navy-600 hover:text-navy-900 border border-cream-300 hover:bg-cream-200/50 px-2.5 py-1 rounded transition-colors">
                                        Edit
                                    </a>

                                    @if($u->id !== Auth::id())
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.users.toggleStatus', $u) }}" method="POST" class="inline"
                                              onsubmit="event.preventDefault(); confirmAction(this, '{{ $u->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} Pengguna', '{{ $u->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($u->name) }}?', '{{ $u->status === 'active' ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}', {{ $u->status === 'active' ? 'true' : 'false' }})">
                                            @csrf
                                            <button type="submit"
                                                    class="text-xxs font-bold px-2.5 py-1 rounded border transition-colors
                                                    {{ $u->status === 'active'
                                                        ? 'text-amber-700 border-amber-200 hover:bg-amber-50'
                                                        : 'text-emerald-700 border-emerald-200 hover:bg-emerald-50' }}">
                                                {{ $u->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xxs text-navy-400 italic px-2.5 py-1">Akun Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-navy-400">
                                Tidak ada akun pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-cream-300 bg-cream-100/10">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
