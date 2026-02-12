<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RAB {{ $rab->nomor_rab }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        .no-border td { border: none; }
        .right { text-align: right; }
    </style>
</head>
<body>

<h2>RAB (Rencana Anggaran Biaya)</h2>

<table class="no-border">
    <tr>
        <td><strong>Nomor</strong></td>
        <td>{{ $rab->nomor_rab }}</td>
        <td><strong>Tanggal</strong></td>
        <td>{{ \Carbon\Carbon::parse($rab->tanggal)->format('d M Y') }}</td>
    </tr>
    <tr>
        <td><strong>Project</strong></td>
        <td>{{ $rab->project->project_type ?? '-' }}</td>
        <td><strong>Expired</strong></td>
        <td>{{ $rab->expired_date ? \Carbon\Carbon::parse($rab->expired_date)->format('d M Y') : '-' }}</td>
    </tr>
</table>

<br>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Satuan</th>
            <th>Volume</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rab->items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->nama_item }}</td>
            <td>{{ $item->satuan }}</td>
            <td class="right">{{ $item->volume }}</td>
            <td class="right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
            <td class="right">{{ number_format($item->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<table>
    <tr>
        <td class="right"><strong>Subtotal</strong></td>
        <td class="right">{{ number_format($rab->subtotal, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="right"><strong>Diskon</strong></td>
        <td class="right">{{ number_format($rab->diskon, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="right"><strong>Pajak</strong></td>
        <td class="right">{{ number_format($rab->pajak, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td class="right"><strong>Grand Total</strong></td>
        <td class="right"><strong>Rp {{ number_format($rab->grand_total, 0, ',', '.') }}</strong></td>
    </tr>
</table>

<br><br>

<p><strong>Termin Pembayaran:</strong></p>
<ul>
    <li>50% Down Payment</li>
    <li>30% Sebelum Pengiriman</li>
    <li>20% Setelah Pemasangan</li>
</ul>

</body>
</html>
