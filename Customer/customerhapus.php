<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['kode_pelanggan'])) {
    $kode_pelanggan=$_GET['kode_pelanggan'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($koneksi, "DELETE FROM customer WHERE kode_pelanggan ='$kode_pelanggan'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:customerlihat.php");
?>