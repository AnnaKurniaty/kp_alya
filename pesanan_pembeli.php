<?php
include('koneksi.php');
session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="index.css">
  <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

  <title>Ikan Segar Jamila</title>
</head>

<body>
  <!-- Jumbotron -->

  <!-- Akhir Jumbotron -->

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg  bg-dark">
    <div class="container">
      <a class="navbar-brand text-white" href="guest.php"><strong>Ikan Segar</strong> Jamila</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link mr-4" href="guest.php">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-4" href="menu_pembeli.php">DAFTAR MENU</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-4" href="pesanan_pembeli.php">PESANAN ANDA</a>
          </li>
          <?php
          if (isset($_SESSION['login_member'])) { ?>
            <li class="nav-item">
              <a class="nav-link mr-4" href="tabel_pemesanan.php">TABEL PEMESANAN</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mr-4" href="logout.php">LOGOUT</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link mr-4" href="login.php">LOGIN</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Akhir Navbar -->

  <!-- Menu -->
  <div class="container">
    <div class="judul-pesanan mt-5">

      <h3 class="text-center font-weight-bold">PESANAN ANDA</h3>

    </div>
    <table class="table table-bordered" id="example">
      <thead class="thead-light">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Pesanan</th>
          <th scope="col">Harga</th>
          <th scope="col">Jumlah (Kg)</th>
          <th scope="col">Subharga</th>
          <th scope="col">Opsi</th>
        </tr>
      </thead>
      <tbody>
        <?php $nomor = 1; ?>
        <?php $totalbelanja = 0; ?>
        <?php
        if (isset($_SESSION['pesanan'])) {
          foreach ($_SESSION["pesanan"] as $id_menu => $jumlah) :
        ?>

            <?php
            include('koneksi.php');
            $ambil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_menu='$id_menu'");
            $pecah = $ambil->fetch_assoc();
            $subharga = $pecah["harga"] * $jumlah;
            ?>
            <tr>
              <td><?php echo $nomor; ?></td>
              <td><?php echo $pecah["nama_menu"]; ?></td>
              <td>Rp. <?php echo number_format($pecah["harga"]); ?></td>
              <td><?php echo $jumlah; ?></td>
              <td>Rp. <?php echo number_format($subharga); ?></td>
              <td>
                <a href="hapus_pesanan.php?id_menu=<?php echo $id_menu ?>" class="badge badge-danger">Hapus</a>
              </td>
            </tr>
            <?php $nomor++; ?>
            <?php $totalbelanja += $subharga; ?>
          <?php endforeach ?>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4">Total Belanja</th>
          <th colspan="2">Rp. <?php echo number_format($totalbelanja) ?></th>
        </tr>
      </tfoot>
    </table><br>
    <form method="POST" action="">
      <a href="menu_pembeli.php" class="btn btn-primary btn-sm">Lihat Menu</a>
      <a href="https://wa.me/6283863563355" class="btn btn-success btn-sm" target="_blank">Pesan Lewat WhatsApp</a>
      <button class="btn btn-success btn-sm" name="confirm">Konfirmasi Pesanan</button>
    </form>

    <?php
    if (isset($_POST['confirm'])) {
      $tanggal_pemesanan = date("Y-m-d");
      $user_id = isset($_SESSION['login_member']) ? $_SESSION['login_member'] : "NULL";

      if (empty($_SESSION["pesanan"])) {
        echo "<script>alert('Pesanan harus diisi sebelum melakukan konfirmasi!');</script>";
        echo "<script>location='menu_pembeli.php';</script>";
        exit();
      }

      // Menyimpan data ke tabel pemesanan
      $insert = mysqli_query($koneksi, "INSERT INTO pemesanan (tanggal_pemesanan, total_belanja, metode_pembayaran, id_user) VALUES ('$tanggal_pemesanan', '$totalbelanja', '', $user_id)");

      // Mendapatkan ID barusan
      $id_terbaru = $koneksi->insert_id;

      // Menyimpan data ke tabel pemesanan produk
      foreach ($_SESSION["pesanan"] as $id_menu => $jumlah) {
        $insert = mysqli_query($koneksi, "INSERT INTO pemesanan_produk (id_pemesanan, id_menu, jumlah) 
                VALUES ('$id_terbaru', '$id_menu', '$jumlah')");
      }

      // Mengosongkan pesanan
      unset($_SESSION["pesanan"]);

      // Menyimpan ID pemesanan ke sesi
      $_SESSION['id_pemesanan'] = $id_terbaru;

      // Dialihkan ke halaman pembayaran
      echo "<script>alert('Pemesanan Sukses! Silahkan lanjutkan ke pembayaran.');</script>";
      echo "<script>location= 'pembayaran.php'</script>";
    }
    ?>
  </div>
  <!-- Akhir Menu -->


  <!-- Awal Footer -->
  <hr class="footer">
  <div class="container">
    <div class="row footer-body">
      <div class="col-md-6">
        <div class="copyright">
          <strong>Copyright</strong> <i class="far fa-copyright"></i> 2024 - Designed by AlyaNurOktapiani</p>
        </div>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <div class="icon-contact">
          <label class="font-weight-bold">Follow Us </label>
          <a href="#"><img src="images/icon/fb.png" class="mr-3 ml-4" data-toggle="tooltip" title="Facebook"></a>
          <a href="#"><img src="images/icon/ig.png" class="mr-3" data-toggle="tooltip" title="Instagram"></a>
          <a href="#"><img src="images/icon/twitter.png" class="mr-3" data-toggle="tooltip" title="Twitter"></a>
          <a href="https://wa.me/6283863563355?text=Halo%20saya%20ingin%20bertanya%20tentang%20Ikan Segar%20Ikan%20Nila" target="_blank">
            <img src="images/icon/whatsapp.png" class="mr-3" data-toggle="tooltip" title="WhatsApp"></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Akhir Footer -->





  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>
</body>

</html>