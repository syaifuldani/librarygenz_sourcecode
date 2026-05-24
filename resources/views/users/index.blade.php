<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-900">
                Daftar <span class="text-coral-500">Pengguna Terdaftar</span>
            </h2>
            <p class="mt-1.5 text-sm text-navy-500">
                Lihat semua anggota, pustakawan, dan administrator yang terintegrasi di LibraryGenz.
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('reports.export.users') }}"
               class="inline-flex items-center gap-1.5 border border-cream-300 hover:bg-cream-200/50 text-navy-700 px-3 py-2 rounded-lg text-xs font-bold transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    <x-flash-alerts />

    <!-- Users Table Container -->
    <div class="bg-cream-50 border border-cream-300 rounded-xl overflow-hidden shadow-sm flex flex-col mb-8">
        <div class="px-6 py-5 border-b border-cream-300 bg-cream-100/30 flex items-center justify-between">
            <div>
                <h4 class="font-serif text-lg font-bold text-navy-950">Semua Akun Pengguna</h4>
                <p class="text-xs text-navy-500 mt-1">Pustakawan hanya dapat memantau data, sedangkan Administrator memiliki akses penuh pengelolaan.</p>
            </div>
            <span class="text-xs font-semibold bg-cream-200 text-navy-700 py-1.5 px-3 rounded-lg border border-cream-300">
                Total {{ number_format($users->total()) }} Akun terdaftar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-cream-300">
                <thead class="bg-cream-100/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Peran (Role)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xxs font-bold text-navy-500 uppercase tracking-wider">Bergabung</th>
                        @if(Auth::user()->isAdmin())
                            <th scope="col" class="px-6 py-3 text-xxs font-bold text-navy-500 uppercase tracking-wider text-right w-40">Tindakan</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-cream-50 divide-y divide-cream-200 text-navy-800">
                    @forelse($users as $u)
                        <tr class="hover:bg-cream-100/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-navy-800 text-cream-100 flex items-center justify-center font-bold text-xs uppercase mr-3">
                                        {{ substr($u->name, 0, 2) }}
                                    </div>
                                    <div class="text-xs font-semibold text-navy-900">{{ $u->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-600">
                                {{ $u->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->isAdmin())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-navy-800 text-cream-100">
                                        Admin
                                    </span>
                                @elseif($u->isLibrarian())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-coral-500/20 text-coral-700">
                                        Librarian
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold bg-cream-300 text-navy-800">
                                        Member
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-navy-500">
                                {{ $u->created_at->translatedFormat('d M Y H:i') }}
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                    @if($u->id !== Auth::id())
                                        <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline"
                                              onsubmit="event.preventDefault(); confirmAction(this, 'Hapus Pengguna', 'Hapus akun {{ addslashes($u->name) }} secara permanen dari sistem?', 'Ya, Hapus')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-coral-600 hover:text-coral-700 font-bold hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-navy-400 italic">Akun Anda</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isAdmin() ? 5 : 4 }}" class="px-6 py-12 text-center text-xs text-navy-400">
                                Tidak ada akun pengguna terdaftar.
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
