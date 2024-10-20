<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/lihat.css">
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
                <h2>Manage Customer</h2>
                <a href="./customertambah.php" class="add-btn" id="addCustomerBtn">+Tambah</a>
            </div>

            <table class="table table-bordered" id="customer">
                <thead>
                    <tr>
                        <th>ID pelanggan</th>
                        <th>Nama pelanggan</th>
                        <th class="Aksi" colspan="2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $limit = 10; // Jumlah baris per halaman
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;
                
                    $query = mysqli_query($koneksi, "SELECT * FROM customer LIMIT $start, $limit");
                    while ($data=mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?php echo $data['kode_pelanggan']   ;?></td>
                        <td><?php echo $data['nama_pelanggan'] ;?></td>
                        <td>
                            <a class="edit" href="customerubah.php?kode_pelanggan=<?php echo $data['kode_pelanggan'];?>" ><i class="fas fa-edit"></i></a> |
                            <a class="hapus" href="customerhapus.php?kode_pelanggan=<?php echo $data['kode_pelanggan']; ?>" onclick="return confirm('yakin hapus?')"><i class="fas fa-trash"></i></a>				
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
