<?php  
include('koneksi.php');
session_start();

if (!isset($_SESSION['id_pemesanan'])) {
    echo "<script>alert('Tidak ada pemesanan yang ditemukan.');</script>";
    echo "<script>location= 'menu_pembeli.php'</script>";
    exit();
}

$id_pemesanan = $_SESSION['id_pemesanan'];

// Ambil data pemesanan
$query = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id_pemesanan='$id_pemesanan'");
$pemesanan = mysqli_fetch_assoc($query);

// Default: bukan member
$is_member = false;

// Cek apakah ada id_user di pemesanan
if (!empty($pemesanan['id_user'])) {
    $id_user = $pemesanan['id_user'];
    $user_query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'");
    $user = mysqli_fetch_assoc($user_query);

    // Cek status member
    $is_member = isset($user['status']) && $user['status'] === 'member';
}

// Hitung total & diskon
$total_belanja = $pemesanan['total_belanja'];
$diskon = 0;
$total_setelah_diskon = $total_belanja;

if ($is_member) {
  if ($total_belanja >= 50000) {
      $diskon = $total_belanja * 0.10;
  } else {
      $diskon = $total_belanja * 0.04;
  }

  // Pembulatan diskon custom
  $puluhan = $diskon % 100;
  if ($puluhan <= 40) {
      $diskon = $diskon - $puluhan;
  } else {
      $diskon = $diskon + (100 - $puluhan);
  }

  $total_setelah_diskon = $total_belanja - $diskon;
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
    <div class="container mt-5">
      <h3 class="text-center">Pembayaran</h3>
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <table class="table table-bordered">
            <tr>
              <th>ID Pemesanan</th> 
              <td><?php echo $pemesanan['id_pemesanan']; ?></td>
            </tr>
            <?php if ($is_member): ?>
              <tr>
                <th>Pesanan Atas Nama</th>
                <td><?php echo ($user['nama_lengkap']); ?></td>
              </tr>
            <?php endif; ?>
            <tr>
              <th>Tanggal Pemesanan</th>
              <td><?php echo $pemesanan['tanggal_pemesanan']; ?></td>
            </tr>
            <tr>
              <th>Total Belanja</th>
              <td>Rp. <?php echo number_format($total_belanja); ?></td>
            </tr>
            <?php if ($is_member): ?>
              <tr>
                <th>Diskon Member</th>
                <td>Rp. <?php echo number_format($diskon); ?></td>
              </tr>
              <tr>
                <th>Total Setelah Diskon</th>
                <td><strong>Rp. <?php echo number_format($total_setelah_diskon); ?></strong></td>
              </tr>
            <?php endif; ?>
            <tr>
              <th>Status Bungkus</th>
              <td><?php echo $pemesanan['status_bungkus']; ?></td>
            </tr>
            <tr>
              <th>Status Pembayaran</th>
              <td><?php echo $pemesanan['status_pembayaran']; ?></td>
            </tr>
          </table>

          <?php
            $_SESSION['total_setelah_diskon'] = $total_setelah_diskon;
          ?>
          <form action="proses_pembayaran.php" method="POST">
            <div class="form-group">
              <label for="metode_pembayaran">Pilih Metode Pembayaran:</label>
              <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="Dana">Dana</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success btn-block">Bayar</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
