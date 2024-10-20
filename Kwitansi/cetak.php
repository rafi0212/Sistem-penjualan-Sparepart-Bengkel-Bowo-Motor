<?php
include '../koneksi.php';

// Ambil no_faktur dari parameter GET
$no_faktur = isset($_GET['no_faktur']) ? mysqli_real_escape_string($koneksi, $_GET['no_faktur']) : '';

// Ambil data kwitansi berdasarkan no_faktur
$query_kwitansi = mysqli_query($koneksi, "SELECT * FROM kwitansi WHERE no_faktur='$no_faktur'");
$data_kwitansi = mysqli_fetch_array($query_kwitansi);

// Ambil nama pelanggan berdasarkan kode_pelanggan
$kode_pelanggan = $data_kwitansi['kode_pelanggan'];
$query_pelanggan = mysqli_query($koneksi, "SELECT nama_pelanggan FROM customer WHERE kode_pelanggan='$kode_pelanggan'");
$pelanggan = mysqli_fetch_array($query_pelanggan);
$nama_pelanggan = isset($pelanggan['nama_pelanggan']) ? $pelanggan['nama_pelanggan'] : 'Pelanggan tidak ditemukan';

// Ambil detail barang berdasarkan no_faktur
$query_detail_barang = "SELECT detail_barang.Kode_barang, barang.nama_barang, detail_barang.QTY, barang.harga_barang, detail_barang.Subtotal
                        FROM detail_barang
                        INNER JOIN barang ON detail_barang.Kode_barang = barang.kode_barang
                        WHERE detail_barang.No_Faktur='$no_faktur'";
$result_detail_barang = $koneksi->query($query_detail_barang);

if (!$result_detail_barang) {
    die("Error: " . $koneksi->error);
}

// Kalkulasi total, bayar, dan kembali (asumsi ini didapat dari tempat lain atau input pengguna)
$total = 0;
while ($row = $result_detail_barang->fetch_assoc()) {
    $total += $row['Subtotal'];
}

// Variabel bayar dan kembali
$bayar = 700000;
$kembali = $bayar - $total;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan Sparepart</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            max-width: 220mm;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #000;
            box-sizing: border-box;
            height: 180mm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
        }
        .header h2 {
            margin: 10px 0 5px 0;
            font-size: 20px;
        }
        .header .tanggal {
            float: right;
        }
        .content {
            margin-top: 20px;
        }
        .content p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .notice {
            margin-top: 10px;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            width: 50%; /* Misalnya mengatur lebar menjadi 50% dari container */
            max-width: 300px; /* Atur lebar maksimum jika ingin membatasi */
            height: auto; /* Mengatur ketinggian otomatis sesuai konten */
            float: left; /* Mengatur posisi ke kiri */
            margin-right: 250px; /* Jarak antara notice dan harga */
        }
        .harga {
            width: 20%; /* Misalnya mengatur lebar menjadi 30% dari container */
            float: left; /* Mengatur posisi ke kiri */
            margin-left: 10px; /* Jarak antara harga dan footer */
        }
        .footer {
            clear: both; /* Membersihkan floating */
            margin-top: 20px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
        }
        .terima {
            float: left;
            margin-right: 30px; /* Shift to the right by 30px */
        }

        .bbm {
            float: right;
            margin-left: 10px; /* Shift to the left by 32px */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BENGKEL BOWO MOTOR</h1>
            <p>Jl. Imam Bonjol 17 Beloran Sragen</p>
            <h2>Nota Penjualan Sparepart</h2><br>
            <p class="tanggal">Tanggal: <?php echo htmlspecialchars($data_kwitansi['tanggal']); ?></p>
        </div>
        <div class="content">
            <p>No. <?php echo htmlspecialchars($data_kwitansi['no_faktur']); ?></p>
            <p>Kode Pelanggan: <?php echo htmlspecialchars($kode_pelanggan); ?></p>
            <p>Nama Pelanggan: <?php echo htmlspecialchars($nama_pelanggan); ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jml</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Reset result_detail_barang pointer and loop again
                    $result_detail_barang->data_seek(0); 
                    while ($row = $result_detail_barang->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Kode_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['QTY']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['harga_barang'], 0, ',', '.')); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['Subtotal'], 0, ',', '.')); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="notice">
            <p>Perhatian !!!</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan</p>
        </div>
        <div class="harga">
            <p>Total :<?php echo htmlspecialchars(number_format($total, 0, ',', '.')); ?></p>
            <p>Bayar : <?php echo htmlspecialchars(number_format($bayar, 0, ',', '.')); ?></p>
            <p>Kembali: <?php echo htmlspecialchars(number_format($kembali, 0, ',', '.')); ?></p>
        </div>
        <div class="footer">
            <div class="terima">
                <p>Tanda terima</p>
                <br><br>
                <p>(________________)</p>
            </div>
            <div class="bbm">
                <p>Hormat kami,</p>
                <br><br>
                <p>Bengkel Bowo Motor</p>
            </div>
        </div>
    </div>
</body>
</html>
