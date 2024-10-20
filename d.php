<?php
ob_start(); // Memulai output buffering

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses'])) {
    $no_faktur = $_POST['no_faktur'];
    $kode_barang = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
    $qty = mysqli_real_escape_string($koneksi, $_POST['qty']);
    $subtotal = mysqli_real_escape_string($koneksi, $_POST['subtotal']);

    // Periksa apakah semua field sudah diisi
    if (!empty($no_faktur) && !empty($kode_barang) && !empty($qty) && !empty($subtotal)) {
        // Query untuk menambahkan data ke tabel detail_barang
        $query_insert = "INSERT INTO detail_barang VALUES ('$no_faktur', '$kode_barang', '$qty', '$subtotal')";
        
        if ($koneksi->query($query_insert) === TRUE) {
            // Redirect kembali ke halaman detaillihat.php dengan parameter no_faktur
            header("Location: detaillihat.php?no_faktur=$no_faktur");
            exit();
        } else {
            echo "Error: " . $query_insert . "<br>" . $koneksi->error;
        }
    } else {
        echo "Semua field harus diisi.";
    }
}

// Ambil data detail barang dan kwitansi untuk ditampilkan
$no_faktur = isset($_GET['no_faktur']) ? mysqli_real_escape_string($koneksi, $_GET['no_faktur']) : '';
$query_kwitansi = mysqli_query($koneksi, "SELECT * FROM kwitansi WHERE no_faktur='$no_faktur'");
if (mysqli_num_rows($query_kwitansi) > 0) {
    $data_kwitansi = mysqli_fetch_array($query_kwitansi);

    $kode_pelanggan = $data_kwitansi['kode_pelanggan'];
    $query_pelanggan = mysqli_query($koneksi, "SELECT nama_pelanggan FROM customer WHERE kode_pelanggan='$kode_pelanggan'");
    $pelanggan = mysqli_fetch_array($query_pelanggan);
    $nama_pelanggan = isset($pelanggan['nama_pelanggan']) ? $pelanggan['nama_pelanggan'] : 'Pelanggan tidak ditemukan';

    $query_detail_barang = "SELECT detail_barang.Kode_barang, barang.nama_barang, detail_barang.QTY, barang.harga_barang, detail_barang.Subtotal
                            FROM detail_barang
                            INNER JOIN barang ON detail_barang.Kode_barang = barang.kode_barang
                            WHERE detail_barang.No_Faktur='$no_faktur'";
    $result_detail_barang = $koneksi->query($query_detail_barang);

    if (!$result_detail_barang) {
        die("Error: " . $koneksi->error);
    }

    $query_barang = "SELECT kode_barang, nama_barang FROM barang";
    $result_barang = $koneksi->query($query_barang);

    if (!$result_barang) {
        die("Error: " . $koneksi->error);
    }
} else {
    die("Data kwitansi tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kwitansi</title>
    <link rel="stylesheet" href="../style/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <h2>Dashboard</h2>
            <input type="text" placeholder="Search here">
            <select name="language-choice">
                <option value="english">English</option>
                <option value="indonesia">Indonesia</option>
            </select>
            <i class="fas fa-bell"></i> 
            <img src="user-logo.png" alt="User Logo"> 
            <div class="user-info">
                <p>Rafi</p> 
                <p>Admin</p> 
            </div>
        </div>

        <nav id="sidebar">
            <ul>
                <br>
                <a href="#"><img src="../img/logobbm.png" width="190px" height="90px"></a>
                <br>
                <br>
                <li><a href="../home.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Home</span>
                </a></li>
                <li><a href="../Customer/customerlihat.php">
                    <i class="fas fa-user"></i>
                    <span class="nav-item">Customer</span>
                </a></li>
                <li><a href="../Barang/baranglihat.php">
                    <i class="fas fa-box"></i>
                    <span class="nav-item">Barang</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-receipt"></i>
                    <span class="nav-item">Kwitansi</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-envelope"></i>
                    <span class="nav-item">Messages</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-cog"></i>
                    <span class="nav-item">Settings</span>
                </a></li>
                <li><a href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-item">Sign-Out</span>
                </a></li>
            </ul>
        </nav>

        <div class="kepala-table">
            <div class="kt">
                <h2> Tambah Detail Kwitansi</h2>
            </div>

            <div class="card mt-3">
                <div class="card-header">Informasi Detail Kwitansi</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">No Faktur</th>
                                <td><?php echo htmlspecialchars($data_kwitansi['no_faktur']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal</th>
                                <td><?php echo htmlspecialchars($data_kwitansi['tanggal']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kasir</th>
                                <td><?php echo htmlspecialchars($data_kwitansi['kasir']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kode Pelanggan</th>
                                <td><?php echo htmlspecialchars($nama_pelanggan); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Tambah Detail Barang</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <input type="hidden" name="no_faktur" value="<?php echo htmlspecialchars($no_faktur); ?>">
                        <div class="form-group">
                            <label for="kode_barang">Nama Barang</label>
                            <select name="kode_barang" id="kode_barang" class="form-control">
                            <?php while ($row_barang = $result_barang->fetch_assoc()) : ?>
                                    <option value="<?php echo htmlspecialchars($row_barang['kode_barang']); ?>">
                                        <?php echo htmlspecialchars($row_barang['nama_barang']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" id="qty" name="qty" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" id="subtotal" name="subtotal" class="form-control">
                        </div>
                        <button type="submit" name="proses" class="btn btn-primary">Tambah Detail</button>
                        <a href="detaillihat.php?no_faktur=<?php echo htmlspecialchars($no_faktur); ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>

<?php
// Akhir dari output buffering
ob_end_flush();
?>

