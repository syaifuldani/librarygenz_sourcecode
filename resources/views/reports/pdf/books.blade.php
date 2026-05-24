@extends('reports.pdf.layout')
@php $title = 'Katalog Buku Perpustakaan'; @endphp

@section('content')
<div class="section-title">Katalog Buku Perpustakaan</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="value">{{ $books->count() }}</div>
        <div class="label">Total Buku</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $books->where('stock', '>', 0)->count() }}</div>
        <div class="label">Tersedia</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $books->where('stock', 0)->count() }}</div>
        <div class="label">Stok Habis</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $books->sum('stock') }}</div>
        <div class="label">Total Unit Fisik</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Terdaftar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($books as $i => $book)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td class="font-bold">{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->category->name ?? '-' }}</td>
            <td class="text-center font-bold">{{ $book->stock }}</td>
            <td>
                @if($book->stock > 0)
                    <span class="badge badge-success">Tersedia</span>
                @else
                    <span class="badge badge-danger">Habis</span>
                @endif
            </td>
            <td>{{ $book->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Tidak ada data buku.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
