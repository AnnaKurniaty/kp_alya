<?php
include('koneksi.php');
session_start();
if(!isset($_SESSION['login_user'])) {
    header("location: login.php");
} else {
    // Ambil ID pemesanan dari URL
    $id_pemesanan = $_GET['id_pemesanan'];

    // Ambil detail pemesanan
    $query = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'");
    $pemesanan = mysqli_fetch_assoc($query);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container">
        <a class="navbar-brand text-white" href="guest.php"><strong>Ikan Segar</strong> Jamila</a>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="text-center">Pembayaran Pesanan</h3>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form method="POST">
                <div class="form-group">
                    <label>Total Belanja</label>
                    <input type="text" class="form-control" value="Rp. <?php echo number_format($pemesanan['total_belanja']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select class="form-control" name="metode_pembayaran" required>
                        <option value="">Pilih Metode</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="COD">Cash on Delivery (COD)</option>
                        <option value="E-Wallet">E-Wallet (OVO, Gopay, DANA)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Pembayaran</label>
                    <input type="date" class="form-control" name="tanggal_pembayaran" required>
                </div>
                <button type="submit" class="btn btn-success btn-block" name="bayar">Konfirmasi Pembayaran</button>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['bayar'])) {
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];

    // Update status pembayaran
    $update = mysqli_query($koneksi, "UPDATE pemesanan SET 
        metode_pembayaran = '$metode_pembayaran',
        status_pembayaran = 'Sudah Dibayar',
        tanggal_pembayaran = '$tanggal_pembayaran' 
        WHERE id_pemesanan = '$id_pemesanan'");

    if($update) {
        echo "<script>alert('Pembayaran berhasil dikonfirmasi!');</script>";
        echo "<script>location='pesanan_dibungkus.php';</script>";
    } else {
        echo "<script>alert('Pembayaran gagal, silakan coba lagi.');</script>";
    }
}
?>
</body>
</html>
