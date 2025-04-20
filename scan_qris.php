<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}

if (!isset($_SESSION['id_pemesanan']) || !isset($_SESSION['metode_pembayaran'])) {
    echo "<script>alert('Tidak ada data pembayaran yang ditemukan.');</script>";
    echo "<script>location='menu_pembeli.php'</script>";
    exit();
}

$id_pemesanan = $_SESSION['id_pemesanan'];
$metode_pembayaran = $_SESSION['metode_pembayaran'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Scan QRIS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Scan QRIS untuk Pembayaran</h3>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <img src="images/qris_dana.png" alt="QRIS Dana" class="img-fluid mb-4" style="max-width: 300px;">
                <form action="konfirmasi_pembayaran.php" method="POST">
                    <input type="hidden" name="id_pemesanan" value="<?php echo $id_pemesanan; ?>">
                    <input type="hidden" name="metode_pembayaran" value="<?php echo $metode_pembayaran; ?>">
                    <button type="submit" class="btn btn-primary btn-block">Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
