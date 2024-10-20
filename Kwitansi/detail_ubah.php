<?php
ob_start(); // Memulai output buffering

include '../koneksi.php';

// Handle POST request untuk ubah detail barang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses'])) {
    $no_faktur = $_POST['no_faktur'];
    $kode_barang = $_POST['kode_barang'];
    $qty = $_POST['qty'];

    // Mengambil harga barang dari database
    $query_harga = mysqli_query($koneksi, "SELECT harga_barang FROM barang WHERE kode_barang='$kode_barang'");
    $data_harga = mysqli_fetch_array($query_harga);
    $harga_barang = $data_harga['harga_barang'];

    // Hitung subtotal
    $subtotal = $qty * $harga_barang;

    // Periksa apakah semua field sudah diisi
    if (!empty($no_faktur) && !empty($kode_barang) && !empty($qty) && !empty($subtotal)) {
        // Escape variabel untuk mencegah SQL injection
        $no_faktur = mysqli_real_escape_string($koneksi, $no_faktur);
        $kode_barang = mysqli_real_escape_string($koneksi, $kode_barang);
        $qty = mysqli_real_escape_string($koneksi, $qty);
        $subtotal = mysqli_real_escape_string($koneksi, $subtotal);

        // Query untuk memperbarui data di tabel detail_barang
        $query_update = "UPDATE detail_barang SET QTY='$qty', Subtotal='$subtotal' WHERE No_Faktur='$no_faktur' AND Kode_barang='$kode_barang'";
        
        if ($koneksi->query($query_update) === TRUE) {
            // Redirect kembali ke halaman detaillihat.php dengan parameter no_faktur
            header("Location: detaillihat.php?no_faktur=$no_faktur");
            exit();
        } else {
            echo "Error: " . $query_update . "<br>" . $koneksi->error;
        }
    } else {
        echo "Semua field harus diisi.";
    }
}

// Ambil data detail barang dan kwitansi untuk ditampilkan
$no_faktur = isset($_GET['no_faktur']) ? mysqli_real_escape_string($koneksi, $_GET['no_faktur']) : '';
$kode_barang = isset($_GET['kode_barang']) ? mysqli_real_escape_string($koneksi, $_GET['kode_barang']) : '';
$query_kwitansi = mysqli_query($koneksi, "SELECT * FROM kwitansi WHERE no_faktur='$no_faktur'");
$data_detail = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM detail_barang WHERE No_Faktur='$no_faktur' AND Kode_barang='$kode_barang'"));

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
    <title>Ubah Detail Kwitansi</title>
    <link rel="stylesheet" href="../style/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kode_barang').change(function() {
                var kode_barang = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'detail_ubah.php',
                    data: {kode_barang: kode_barang, ajax: true},
                    dataType: 'json',
                    success: function(response) {
                        $('#harga_barang').val(response.harga_barang);
                        hitungSubtotal();
                    }
                });
            });

            $('#qty').on('input', function() {
                hitungSubtotal();
            });

            function hitungSubtotal() {
                var qty = $('#qty').val();
                var harga_barang = $('#harga_barang').val();
                var subtotal = qty * harga_barang;
                $('#subtotal').val(subtotal);
            }
        });
    </script>
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
                <h2> Ubah Detail Kwitansi</h2>
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
                <div class="card-header">Ubah Detail Barang</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <input type="hidden" name="no_faktur" value="<?php echo htmlspecialchars($no_faktur); ?>">
                        <div class="form-group">
                            <label for="kode_barang">Nama Barang</label>
                            <select name="kode_barang" id="kode_barang" class="form-control" readonly>
                                <?php while ($row_barang = $result_barang->fetch_assoc()) : ?>
                                    <option value="<?php echo htmlspecialchars($row_barang['kode_barang']); ?>" <?php if ($row_barang['kode_barang'] == $data_detail['Kode_barang']) echo 'selected'; ?> readonly>
                                        <?php echo htmlspecialchars($row_barang['nama_barang']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select readonly>
                        </div>
                        <input type="hidden" id="harga_barang" value="">
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" id="qty" name="qty" class="form-control" value="<?php echo htmlspecialchars($data_detail['QTY']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" id="subtotal" name="subtotal" class="form-control" value="<?php echo htmlspecialchars($data_detail['Subtotal']); ?>" readonly>
                        </div>
                        <button type="submit" name="proses" class="btn btn-primary">Simpan Perubahan</button>
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

if (isset($_POST['ajax']) && $_POST['ajax'] == true) {
    $kode_barang = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
    $query = mysqli_query($koneksi, "SELECT harga_barang FROM barang WHERE kode_barang='$kode_barang'");
    $data = mysqli_fetch_assoc($query);

    echo json_encode($data);
    exit();
}
?>
