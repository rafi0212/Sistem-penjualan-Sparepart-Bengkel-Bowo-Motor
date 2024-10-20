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
                <h2>Manage Kwitansi</h2>
                <a href="./kwitansitambah.php" class="add-btn" id="addKwitansiBtn">+Tambah</a>
            </div>

            <table class="table table-bordered" id="customer">
                <thead>
                    <tr>
                    <th>No_Faktur</th>
                        <th style="width: 300px;">tanggal</th>
                        <th>kasir</th>
                        <th>pelanggan</th>
                        <th class="Aksi" colspan="3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
            include '../koneksi.php';

            // Pagination
            $limit = 10; // Jumlah baris per halaman
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            $query = mysqli_query($koneksi, "SELECT kwitansi.no_faktur, kwitansi.tanggal, kwitansi.kasir, customer.kode_pelanggan
            FROM kwitansi INNER JOIN customer ON customer.kode_pelanggan = kwitansi.kode_pelanggan  LIMIT $start, $limit");
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                <td><?php echo $data['no_faktur']   ;?></td>
                <td><?php echo $data['tanggal']    ;?></td>
                <td><?php echo $data['kasir'] ;?></td>
                <td><?php echo $data['kode_pelanggan'] ;?></td>
               <!--<td><?php echo $jumlah_detail; ?></td> -->
                <td>
                    <a class="edit" href="kwitansiubah.php?no_faktur=<?php echo $data['no_faktur'];?>" ><i class="fas fa-edit"></i></a>   
                    <a class="hapus" href="kwitansihapus.php?no_faktur=<?php echo $data['no_faktur']; ?>" onclick="return confirm('hapus ga si?')"><i class="fas fa-trash"></i></a>   
                    <a class="detail" href="detaillihat.php?no_faktur=<?php echo $data['no_faktur']; ?>"><i class="fas fa-info-circle"></i></a>
                </td>
            </tr>
            
            <?php }
             ?>
                    </tr>
                    <!-- Data pelanggan lainnya -->
                </tbody>
            </table>
        </div>
      
    </div>


</div>
</body>
</html>
