

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation</title>
    <style>
        @page {
            margin: 40px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .header {
            width: 100%;
        }
        .flex {
            width: 100%;
        }
        .left {
            float: left;
            width: 60%;
        }
        .logo {
            width: 120px;
            margin-bottom: 10px;
        }
        .right {
            float: right;
            width: 35%;
            text-align: right;
        }
        .box {
            background: #9bbb59;
            padding: 10px;
            color: #000;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            border-bottom: 2px solid #000;
            text-align: left;
            padding: 6px 4px;
        }
        td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .total-box {
            margin-top: 20px;
            width: 40%;
            float: right;
        }
        .total-line {
            border-top: 2px solid #000;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: bold;
        }
        .note {
            margin-top: 40px;
        }
        .payment-box {
            margin-top: 20px;
            background: #9bbb59;
            padding: 10px;
            border: 2px solid #000;
        }
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="flex">
        <div class="left">
            <img src="{{ public_path('images/Logo1.jpeg') }}" class="logo">
            <h2>INTRUST INTERIOR</h2>
            <strong>DESIGN & FURNITURE</strong><br><br>
            Phone : 082140006428<br>
            Email : hallo.intrust@gmail.com<br>
            Address : Pinus Regency Cluster Garden View 1 No 9
        </div>

        <div class="right">
            <h1>QUOTATION</h1>
            <div class="box">
                Date : {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') }}<br>
                Expires : {{ \Carbon\Carbon::parse($quotation->valid_until)->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <br>
    <strong>Prepared For :</strong> {{ $quotation->client->name ?? '-' }}

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Item Description</th>
                <th width="10%">SAT</th>
                <th width="10%">VOL</th>
                <th width="15%" class="text-right">Harga (Rp)</th>
                <th width="15%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ number_format($item->length ?? 0, 2, ',', '.') }}</td>
                    <td>{{ $item->unit }}</td>
                    <td class="text-right">
                        {{ number_format($item->unit_price ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div class="total-line">
            Total Due : Rp. {{ number_format($quotation->grand_total ?? 0, 0, ',', '.') }}
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="note">
        <strong>Note:</strong><br>
        Termin Pembayaran terbagi atas 3 tahap:
        <ul>
            <li>50% downpayment untuk pengerjaan</li>
            <li>30% pada saat pengiriman barang</li>
            <li>20% setelah selesai pemasangan</li>
        </ul>
        <span style="color:red;">
            Aksesoris (kompor, sink, cookerhood, dll belum termasuk di dalam RAB)
        </span>
    </div>

    <div class="payment-box">
        Pembayaran harap ditransfer ke : I Putu Gede Sanchia Janitra<br>
        No. Rek BCA 2831481058<br>
        Kredit via Tokopedia dan Shopee
    </div>

</body>
</html>