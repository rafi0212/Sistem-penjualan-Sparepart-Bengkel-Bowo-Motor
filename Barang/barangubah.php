<?php
            include '../koneksi.php';
            $query = mysqli_query($koneksi, "Select * from barang where kode_barang = '$_GET[kode_barang]'");
            $data = mysqli_fetch_array($query);
            
                ?>
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
                <option value="spanish">Indonesia</option>
            </select>
            <i class="fas fa-bell"></i> 
            <img src="user-logo.png" > 
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
                <li><a href="#">
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
                <h2>Ubah Barang</h2>
            </div>
       
            <div class="form-customer">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="kodePelanggan">Kode Barang:</label>
                        <input type="text" id="kodePelanggan" name="kode_barang"value="<?php echo $data['kode_barang'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="namaPelanggan">Nama Barang:</label>
                        <input type="text" id="namaPelanggan" name="nama_barang"value="<?php echo $data['nama_barang'];?>">
                    </div>
                    <div class="form-group">
                        <label for="namaPelanggan">Harga Barang:</label>
                        <input type="number" id="hargabarang" name="harga_barang"value="<?php echo $data['harga_barang'];?>">
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        <a href="./baranglihat.php" class="btn btn-back">Kembali</a>
                        <button type="submit" class="btn btn-save" name="proses" value="Simpan barang">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php

if (isset($_POST['proses'])){
    include '../koneksi.php';
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];

    
    
    mysqli_query($koneksi, "update barang set 
                            nama_barang ='$nama_barang',harga_barang ='$harga_barang' where kode_barang ='$kode_barang'");
    header("location:baranglihat.php");
}
?>
</body>
</html>
               