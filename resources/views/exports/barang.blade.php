<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Barang Masuk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Kuantitas</th>
                <th>Harga/Satuan</th>
                <th>Total</th>
                <th>Jenis Pembayaran</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $i => $barang)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->nama_toko_suplier }}</td>
                    <td>{{ $barang->kuantitas }}</td>
                    <td>{{ number_format($barang->harga_per_satu) }}</td>
                    <td>{{ number_format($barang->harga_per_satu * $barang->kuantitas) }}</td>
                    <td>{{ ucfirst($barang->jenis_pembayaran) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $barang->status_pembayaran)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
