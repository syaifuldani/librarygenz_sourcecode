@extends('reports.pdf.layout')
@php $title = 'Laporan Peminjaman Buku'; @endphp

@section('content')
<div class="section-title">Laporan Peminjaman Buku</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="value">{{ $borrowings->count() }}</div>
        <div class="label">Total Data</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $borrowings->where('status', 'borrowed')->count() + $borrowings->where('status', 'overdue')->count() }}</div>
        <div class="label">Aktif Dipinjam</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $borrowings->where('status', 'overdue')->count() }}</div>
        <div class="label">Terlambat</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $borrowings->where('status', 'returned')->count() }}</div>
        <div class="label">Dikembalikan</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Kategori</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Denda</th>
        </tr>
    </thead>
    <tbody>
        @forelse($borrowings as $i => $b)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                <span class="font-bold">{{ $b->user->name ?? '-' }}</span><br>
                <span class="text-muted">{{ $b->user->email ?? '' }}</span>
            </td>
            <td>
                <span class="font-bold">{{ $b->book->title ?? '-' }}</span><br>
                <span class="text-muted">{{ $b->book->author ?? '' }}</span>
            </td>
            <td>{{ $b->book->category->name ?? '-' }}</td>
            <td>{{ $b->borrow_date ? $b->borrow_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $b->due_date ? $b->due_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
            <td>
                @switch($b->status)
                    @case('requested') <span class="badge badge-warning">Menunggu</span> @break
                    @case('approved') <span class="badge badge-info">Disetujui</span> @break
                    @case('borrowed') <span class="badge badge-success">Dipinjam</span> @break
                    @case('returned') <span class="badge badge-neutral">Kembali</span> @break
                    @case('rejected') <span class="badge badge-danger">Ditolak</span> @break
                    @case('overdue') <span class="badge badge-danger">Terlambat</span> @break
                    @default <span class="badge badge-neutral">{{ $b->status }}</span>
                @endswitch
            </td>
            <td>
                @if($b->fine)
                    <span class="text-coral font-bold">Rp{{ number_format($b->fine->amount, 0, ',', '.') }}</span><br>
                    <span class="text-muted">{{ $b->fine->status }}</span>
                @else
                    -
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="9" class="text-center text-muted">Tidak ada data peminjaman.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
