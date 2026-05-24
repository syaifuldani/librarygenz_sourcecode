<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laporan LibraryGenz' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1E2736;
            background: #FDFDFB;
            line-height: 1.5;
        }
        .page-header {
            background: #1E2736;
            color: #FDFDFB;
            padding: 18px 24px;
            margin-bottom: 20px;
        }
        .page-header .brand {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .page-header .brand span { color: #EB7057; }
        .page-header .report-title {
            font-size: 13px;
            margin-top: 4px;
            color: #A2B1C7;
        }
        .page-header .meta {
            font-size: 9px;
            color: #778CA7;
            margin-top: 6px;
        }
        .content { padding: 0 24px 24px; }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1E2736;
            border-bottom: 2px solid #EB7057;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        thead tr {
            background: #1E2736;
            color: #FDFDFB;
        }
        thead th {
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) { background: #FAF6EE; }
        tbody tr:nth-child(odd) { background: #FDFDFB; }
        tbody td {
            padding: 7px 10px;
            font-size: 9px;
            border-bottom: 1px solid #F4EEDC;
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-neutral { background: #F4EEDC; color: #1E2736; }
        .badge-coral { background: #FCEAE6; color: #C63720; }
        .stat-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 12px;
            background: #FAF6EE;
            border: 1px solid #F4EEDC;
            text-align: center;
        }
        .stat-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #EB7057;
        }
        .stat-card .label {
            font-size: 8px;
            color: #778CA7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 24px;
            background: #FAF6EE;
            border-top: 1px solid #F4EEDC;
            font-size: 8px;
            color: #778CA7;
            text-align: center;
        }
        .text-coral { color: #EB7057; }
        .text-navy { color: #1E2736; }
        .text-muted { color: #778CA7; }
        .font-bold { font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="brand">Library<span>Genz</span></div>
        <div class="report-title">{{ $title ?? 'Laporan Sistem' }}</div>
        <div class="meta">
            Digenerate: {{ $generatedAt->translatedFormat('d F Y, H:i') }} WIB &nbsp;&bull;&nbsp;
            Oleh: {{ $generatedBy }} &nbsp;&bull;&nbsp;
            LibraryGenz — Warm Editorial Library Management
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="page-footer">
        &copy; {{ date('Y') }} LibraryGenz &mdash; Dokumen ini digenerate secara otomatis oleh sistem. Halaman <span class="pagenum"></span>
    </div>
</body>
</html>
