<?php
include('koneksi.php');

if (isset($_GET['id_pemesanan'])) {
    $id_pemesanan = $_GET['id_pemesanan'];
    mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id_pemesanan='$id_pemesanan'");
    mysqli_query($koneksi, "DELETE FROM pemesanan_produk WHERE id_pemesanan='$id_pemesanan'");
    echo "<script>alert('Registrasi berhasil dihapus!');</script>";
    echo "<script>location='tabel_pemesanan.php';</script>";
}
?>
