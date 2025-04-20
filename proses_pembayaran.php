<?php
session_start();
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['metode_pembayaran']) || empty($_POST['metode_pembayaran'])) {
        echo "<script>alert('Pilih metode pembayaran terlebih dahulu.');</script>";
        echo "<script>location='pembayaran.php'</script>";
        exit();
    }

    $_SESSION['metode_pembayaran'] = $_POST['metode_pembayaran'];

    if (!isset($_SESSION['id_pemesanan'])) {
        echo "<script>alert('Tidak ada pemesanan ditemukan.');</script>";
        echo "<script>location='menu_pembeli.php'</script>";
        exit();
    }

    $id_pemesanan = $_SESSION['id_pemesanan'];

    // Ambil total setelah diskon dari session
    if (isset($_SESSION['total_setelah_diskon'])) {
        $total_baru = $_SESSION['total_setelah_diskon'];

        // Update total_belanja di database
        $update = mysqli_query($koneksi, "UPDATE pemesanan SET total_belanja='$total_baru' WHERE id_pemesanan='$id_pemesanan'");
    }

    header("location: scan_qris.php");
    exit();
}
?>
