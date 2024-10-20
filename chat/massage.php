<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/wa.css">
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
            <li><a href="../Kwitansi/kwitansilihat.php">
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
    
      <?php include '../chat.php'; ?>

      
    </div>
</div>
</body>
</html>
