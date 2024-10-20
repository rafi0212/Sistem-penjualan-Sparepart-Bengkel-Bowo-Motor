<?php
ob_start(); // Memulai output buffering

include '../koneksi.php';

if (isset($_POST['proses'])) {
    $no_faktur = $_POST['no_faktur'];
    $tanggal = $_POST['tanggal'];
    $kasir = $_POST['kasir'];
    $kode_pelanggan = $_POST['kode_pelanggan'];

    // Validasi atau proses penyimpanan ke database
    $query_insert = "INSERT INTO kwitansi (no_faktur, tanggal, kasir, kode_pelanggan) VALUES ('$no_faktur', '$tanggal', '$kasir', '$kode_pelanggan')";
    
    if (mysqli_query($koneksi, $query_insert)) {
        // Jika berhasil disimpan, arahkan ke halaman tambahdetail.php dengan no_faktur yang baru saja dimasukkan
        header("Location: tambahdetail.php?no_faktur=" . urlencode($no_faktur));
        exit();
    } else {
        echo "Error: " . $query_insert . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kwitansi</title>
    <link rel="stylesheet" href="../style/tambah.css">
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
                <li><a href="../Kwitansi/kwitansilihat.php">
                    <i class="fas fa-receipt"></i>
                    <span class="nav-item">Kwitansi</span>
                </a></li>
                <li><a href="../chat/massage.php">
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
                <h2>Tambah Kwitansi</h2>
            </div>
       
            <div class="form-customer">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nofaktur">No Faktur:</label>
                        <input type="text" id="kodePelanggan" name="no_faktur">
                    </div>
                    <div class="form-group">
                        <label for="namaPelanggan">Tanggal:</label>
                        <input type="date" id="namaPelanggan" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="kasir">Kasir:</label>
                        <input type="text" id="kodePelanggan" name="kasir">
                    </div>
                    <div class="form-group">
                        <label for="pelanggan">Pelanggan:</label>
                        <select id="pelanggan" name="kode_pelanggan" class="select-custom">
                            <?php
                            include '../koneksi.php';
                            $query=mysqli_query($koneksi, "SELECT * FROM customer");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?php echo $data['kode_pelanggan']; ?>">
                                <?php echo $data['nama_pelanggan']; ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <br>
                    <br>
                    <div class="form-actions">
                        <a href="../Kwitansi/kwitansilihat.php" class="btn btn-back">Kembali</a>
                        <button type="submit" class="btn btn-save" name="proses" value="Simpan barang">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
