<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['metode_pembayaran']) || empty($_POST['metode_pembayaran'])) {
        echo "<script>alert('Pilih metode pembayaran terlebih dahulu.');</script>";
        echo "<script>location='pembayaran.php'</script>";
        exit();
    }

    $_SESSION['metode_pembayaran'] = $_POST['metode_pembayaran'];

    // Redirect to the QRIS scan page
    header("location: scan_qris.php");
    exit();
}
?>
