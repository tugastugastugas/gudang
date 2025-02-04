<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 20px;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid black; 
            padding: 8px; 
            text-align: right;
        }
        th { 
            background-color: #f2f2f2; 
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #d9edf7;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2 class="title">LAPORAN KEUANGAN</h2>
    <p class="subtitle">Periode: {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</p>

    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Pembeli</th>
                <th>Satuan</th>
                <th>Total Harga Beli</th>
                <th>Total Harga Jual</th>
                <th>Keuntungan/Kerugian</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $total_beli = 0; 
                $total_jual = 0; 
                $total_keuntungan = 0;
            @endphp
            @foreach ($data as $row)
            @php 
                $total_beli += $row->total_harga_beli;
                $total_jual += $row->total_harga_jual;
                $total_keuntungan += $row->keuntungan_kerugian;
            @endphp
            <tr>
                <td style="text-align: center;">{{ $row->kode_barang }}</td>
                <td style="text-align: left;">{{ $row->nama_barang }}</td>
                <td style="text-align: left;">{{ $row->supplier }}</td>
                <td style="text-align: left;">{{ $row->pembeli }}</td>
                <td style="text-align: left;">{{ $row->satuan }}</td>
                <td>Rp{{ number_format($row->total_harga_beli, 2, ',', '.') }}</td>
                <td>Rp{{ number_format($row->total_harga_jual, 2, ',', '.') }}</td>
                <td>Rp{{ number_format($row->keuntungan_kerugian, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: center;">TOTAL</td>
                <td>Rp{{ number_format($total_beli, 2, ',', '.') }}</td>
                <td>Rp{{ number_format($total_jual, 2, ',', '.') }}</td>
                <td>Rp{{ number_format($total_keuntungan, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <p class="footer">
        Total Keuntungan/Kerugian: <strong>Rp{{ number_format($total_keuntungan, 2, ',', '.') }}</strong>
    </p>
</body>
</html>
