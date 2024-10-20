<?php
// Include database connection file
include '../koneksi.php';

// Get no_faktur and kode_barang from URL to delete the corresponding row
if (isset($_GET['no_faktur']) && isset($_GET['kode_barang'])) {
    $no_faktur = mysqli_real_escape_string($koneksi, $_GET['no_faktur']);
    $kode_barang = mysqli_real_escape_string($koneksi, $_GET['kode_barang']);

    // Delete the row from detail_barang table based on given no_faktur and kode_barang
    $result = mysqli_query($koneksi, "DELETE FROM detail_barang WHERE No_Faktur='$no_faktur' AND Kode_barang='$kode_barang'");

    // Check if the query was successful
    if ($result) {
        // After delete, redirect to detail page with success message
        header("Location: detaillihat.php?no_faktur=$no_faktur&message=deleted");
    } else {
        // If there's an error, redirect to detail page with error message
        header("Location: detaillihat.php?no_faktur=$no_faktur&message=error");
    }
} else {
    // If no_faktur or kode_barang is not set, redirect to detail page with invalid message
    header("Location: detail.php?no_faktur=$no_faktur&message=invalid");
}
?>
