<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['no_faktur'])) {
    $no_faktur=$_GET['no_faktur'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($koneksi, "DELETE FROM kwitansi WHERE no_faktur ='$no_faktur'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:kwitansilihat.php");
?>