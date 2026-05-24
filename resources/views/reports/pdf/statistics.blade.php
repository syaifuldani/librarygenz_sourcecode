@extends('reports.pdf.layout')
@php $title = 'Statistik Dashboard LibraryGenz'; @endphp

@section('content')
<div class="section-title">Statistik Dashboard LibraryGenz</div>

<!-- Main Stats -->
<div class="stat-grid" style="margin-bottom: 8px;">
    <div class="stat-card">
        <div class="value">{{ $stats['total_books'] }}</div>
        <div class="label">Total Buku</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $stats['total_users'] }}</div>
        <div class="label">Total Pengguna</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $stats['total_borrowings'] }}</div>
        <div class="label">Total Peminjaman</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $stats['active_borrowings'] }}</div>
        <div class="label">Aktif Dipinjam</div>
    </div>
</div>
<div class="stat-grid" style="margin-bottom: 20px;">
    <div class="stat-card">
        <div class="value">{{ $stats['overdue_borrowings'] }}</div>
        <div class="label">Terlambat</div>
    </div>
    <div class="stat-card">
        <div class="value" style="font-size:14px;">Rp{{ number_format($stats['total_fines_unpaid'], 0, ',', '.') }}</div>
        <div class="label">Denda Belum Bayar</div>
    </div>
    <div class="stat-card">
        <div class="value" style="font-size:14px;">Rp{{ number_format($stats['total_fines_paid'], 0, ',', '.') }}</div>
        <div class="label">Denda Terkumpul</div>
    </div>
    <div class="stat-card">
        <div class="value" style="font-size:14px;">Rp{{ number_format($stats['total_fines_waived'], 0, ',', '.') }}</div>
        <div class="label">Denda Dibebaskan</div>
    </div>
</div>

<!-- Most Borrowed Books -->
<div class="section-title">10 Buku Paling Banyak Dipinjam</div>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th class="text-right">Jumlah Pinjam</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stats['most_borrowed'] as $i => $book)
        <tr>
            <td class="font-bold text-coral">{{ $i + 1 }}</td>
            <td class="font-bold">{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td class="text-right font-bold">{{ $book->borrowings_count }} kali</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Recent Borrowings -->
<div class="section-title">10 Peminjaman Terbaru</div>
<table>
    <thead>
        <tr>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stats['recent_borrowings'] as $b)
        <tr>
            <td>{{ $b->user->name ?? '-' }}</td>
            <td>{{ $b->book->title ?? '-' }}</td>
            <td>{{ $b->created_at->format('d/m/Y') }}</td>
            <td>
                @switch($b->status)
                    @case('borrowed') <span class="badge badge-success">Dipinjam</span> @break
                    @case('returned') <span class="badge badge-neutral">Kembali</span> @break
                    @case('overdue') <span class="badge badge-danger">Terlambat</span> @break
                    @case('requested') <span class="badge badge-warning">Menunggu</span> @break
                    @default <span class="badge badge-neutral">{{ $b->status }}</span>
                @endswitch
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
