<?php
ob_start(); // Memulai output buffering

include '../koneksi.php';

// Mengambil no_faktur dari parameter GET dan melakukan sanitasi
$no_faktur = isset($_GET['no_faktur']) ? mysqli_real_escape_string($koneksi, $_GET['no_faktur']) : '';

// Mengambil data kwitansi berdasarkan no_faktur
$query = mysqli_query($koneksi, "SELECT * FROM kwitansi WHERE no_faktur='$no_faktur'");
$data = mysqli_fetch_array($query);

// Mengambil nama pelanggan berdasarkan kode_pelanggan
$kode_pelanggan = $data['kode_pelanggan'];
$query_pelanggan = mysqli_query($koneksi, "SELECT nama_pelanggan FROM customer WHERE kode_pelanggan='$kode_pelanggan'");
$pelanggan = mysqli_fetch_array($query_pelanggan);
$nama_pelanggan = isset($pelanggan['nama_pelanggan']) ? $pelanggan['nama_pelanggan'] : 'Pelanggan tidak ditemukan';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            <li><a href="./kwitansilihat.php">
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
                <h2>Detail Kwitansi</h2>
               
            </div>

            <div class="card mt-3">
                <div class="card-header">Informasi Detail Barang</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">No Faktur</th>
                                <td><?php echo htmlspecialchars($data['no_faktur']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal</th>
                                <td><?php echo htmlspecialchars($data['tanggal']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kasir</th>
                                <td><?php echo htmlspecialchars($data['kasir']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kode Pelanggan</th>
                                <td><?php echo htmlspecialchars($nama_pelanggan); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            

            <div class="card" style="margin-top: 50px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Informasi Detail Barang</span>
        <div>
                <a href="tambahdetail.php?no_faktur=<?php echo $data['no_faktur']; ?>" class="btn btn-success tambah">Tambah</a>
                <a href="cetak.php?no_faktur=<?php echo htmlspecialchars($data['no_faktur']); ?>" class="btn btn-secondary cetak">Cetak</a>

        </div>

    </div>

                    <table class="table table-bordered" id="customer">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>QTY</th>
                                <th>Harga Barang</th>
                                <th>Subtotal</th>
                                <th class="Aksi" colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Pagination
                        $limit = 10; // Jumlah baris per halaman
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $limit;

                        $query = "SELECT detail_barang.Kode_barang, barang.nama_barang, detail_barang.QTY, barang.harga_barang, detail_barang.Subtotal
                            FROM detail_barang
                            INNER JOIN barang ON detail_barang.Kode_barang = barang.kode_barang
                            WHERE detail_barang.No_Faktur='$no_faktur'
                            LIMIT $start, $limit";

                        $result = $koneksi->query($query);

                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['Kode_barang']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['QTY']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['harga_barang']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Subtotal']) . "</td>";
                               echo "<td><a class='edit' href='detail_ubah.php?no_faktur=" . htmlspecialchars($data['no_faktur']) . "&kode_barang=" . htmlspecialchars($row['Kode_barang']) . "'><i class='fas fa-edit'></i></a> |
                                       <a class='hapus' href='detailhapus.php?no_faktur=" . htmlspecialchars($data['no_faktur']) . "&kode_barang=" . htmlspecialchars($row['Kode_barang']) . "' onclick='return confirm(\"hapus ga si?\")'><i class='fas fa-trash'></i></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Error: " . $koneksi->error;
                        }
                        ?>
                         
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
