@extends('reports.pdf.layout')
@php $title = 'Daftar Pengguna Terdaftar'; @endphp

@section('content')
<div class="section-title">Daftar Pengguna Terdaftar</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="value">{{ $users->count() }}</div>
        <div class="label">Total Pengguna</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $users->filter(fn($u) => $u->role?->name === 'admin')->count() }}</div>
        <div class="label">Administrator</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $users->filter(fn($u) => $u->role?->name === 'librarian')->count() }}</div>
        <div class="label">Pustakawan</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $users->filter(fn($u) => $u->role?->name === 'member')->count() }}</div>
        <div class="label">Anggota</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Peran</th>
            <th>Status</th>
            <th>Bergabung</th>
            <th>Verifikasi Email</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $i => $user)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td class="font-bold">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @switch($user->role?->name)
                    @case('admin') <span class="badge badge-info">Admin</span> @break
                    @case('librarian') <span class="badge badge-coral">Pustakawan</span> @break
                    @case('member') <span class="badge badge-neutral">Anggota</span> @break
                    @default <span class="badge badge-neutral">-</span>
                @endswitch
            </td>
            <td>
                @if($user->status === 'active')
                    <span class="badge badge-success">Aktif</span>
                @else
                    <span class="badge badge-danger">Nonaktif</span>
                @endif
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y') : 'Belum Verifikasi' }}</td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Tidak ada data pengguna.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
