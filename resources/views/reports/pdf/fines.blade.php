@extends('reports.pdf.layout')
@php $title = 'Laporan Denda & Keterlambatan'; @endphp

@section('content')
<div class="section-title">Laporan Denda & Keterlambatan</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="value">{{ $fines->count() }}</div>
        <div class="label">Total Denda</div>
    </div>
    <div class="stat-card">
        <div class="value">Rp{{ number_format($totalUnpaid, 0, ',', '.') }}</div>
        <div class="label">Belum Dibayar</div>
    </div>
    <div class="stat-card">
        <div class="value">Rp{{ number_format($totalPaid, 0, ',', '.') }}</div>
        <div class="label">Sudah Dibayar</div>
    </div>
    <div class="stat-card">
        <div class="value">Rp{{ number_format($totalWaived, 0, ',', '.') }}</div>
        <div class="label">Dibebaskan</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Keterlambatan</th>
            <th>Jumlah Denda</th>
            <th>Status</th>
            <th>Tgl Dibuat</th>
            <th>Tgl Selesai</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fines as $i => $fine)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                <span class="font-bold">{{ $fine->borrowing->user->name ?? '-' }}</span><br>
                <span class="text-muted">{{ $fine->borrowing->user->email ?? '' }}</span>
            </td>
            <td>
                <span class="font-bold">{{ $fine->borrowing->book->title ?? '-' }}</span>
            </td>
            <td class="text-center">{{ $fine->late_days }} hari</td>
            <td class="font-bold text-coral">Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
            <td>
                @switch($fine->status)
                    @case('unpaid') <span class="badge badge-danger">Belum Bayar</span> @break
                    @case('paid') <span class="badge badge-success">Lunas</span> @break
                    @case('waived') <span class="badge badge-neutral">Dibebaskan</span> @break
                @endswitch
            </td>
            <td>{{ $fine->created_at->format('d/m/Y') }}</td>
            <td>{{ $fine->paid_at ? $fine->paid_at->format('d/m/Y') : ($fine->status !== 'unpaid' ? $fine->updated_at->format('d/m/Y') : '-') }}</td>
            <td>{{ $fine->notes ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="9" class="text-center text-muted">Tidak ada data denda.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
