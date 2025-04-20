<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('koneksi.php');

    $id_pemesanan = $_POST['id_pemesanan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Update status pembayaran di database
    $query = "UPDATE pemesanan SET status_pembayaran='Validasi', metode_pembayaran='$metode_pembayaran' WHERE id_pemesanan='$id_pemesanan'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Pembayaran berhasil dikonfirmasi.');</script>";
        echo "<script>location='menu_pembeli.php'</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengkonfirmasi pembayaran.');</script>";
        echo "<script>location='menu_pembeli.php'</script>";
    }
}
?>


