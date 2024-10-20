<?php
ob_start(); // Memulai output buffering

include '../koneksi.php';

// Mengambil no_faktur dari parameter GET dan melakukan sanitasi
$no_faktur = isset($_GET['no_faktur']) ? mysqli_real_escape_string($koneksi, $_GET['no_faktur']) : '';

// Mengambil data kwitansi berdasarkan no_faktur
$query = mysqli_query($koneksi, "SELECT * FROM kwitansi WHERE no_faktur='$no_faktur'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                <a href="#"><img src="../img/logobbm.png" width="190px" height="90px" alt="Logo BBM"></a>
                <br>
                <br>
                <li><a href="../home.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Home</span>
                </a></li>
                <li><a href="Customer/customerlihat.php">
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
                <h2>Ubah Kwitansi</h2>
            </div>
       
            <div class="form-customer">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="no_faktur">No Faktur:</label>
                        <input type="text" id="no_faktur" name="no_faktur" value="<?php echo htmlspecialchars($data['no_faktur']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="kasir">Kasir:</label>
                        <input type="text" id="kasir" name="kasir" value="<?php echo htmlspecialchars($data['kasir']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="pelanggan">Pelanggan:</label>
                        <select id="pelanggan" name="kode_pelanggan" class="select-custom">
                            <?php
                            $ambilpelanggan = mysqli_query($koneksi, "SELECT * FROM customer");
                            while ($customer = mysqli_fetch_array($ambilpelanggan)) {
                                $selected = ($data['kode_pelanggan'] == $customer['kode_pelanggan']) ? 'selected' : '';
                                echo "<option value='".htmlspecialchars($customer['kode_pelanggan'])."' $selected>".htmlspecialchars($customer['nama_pelanggan'])."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        <a href="./kwitansilihat.php" class="btn btn-back">Kembali</a>
                        <button type="submit" class="btn btn-save" name="proses" value="kwitansi ubah">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
<?php

if (isset($_POST['proses'])){
    include '../koneksi.php';
  
    $tanggal = $_POST['tanggal'];
    $kasir = $_POST['kasir'];
    $kode_pelanggan = $_POST['kode_pelanggan'];
    
    mysqli_query($koneksi, "UPDATE kwitansi SET tanggal='$tanggal', kasir='$kasir' WHERE no_faktur='$no_faktur'");

    header("location:kwitansilihat.php?no_faktur=$no_faktur");
}