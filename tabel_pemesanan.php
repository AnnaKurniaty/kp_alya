<?php session_start(); ?>

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
  <div class="container mt-5">
    <div class="judul-pesanan mt-5">
      <h3 class="text-center font-weight-bold">TABEL PEMESANAN</h3>
    </div>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>ID Pemesanan</th>
          <th>Tanggal Pemesanan</th>
          <th>Total Belanja</th>
          <th>Metode Pembayaran</th>
          <th>Status Bungkus</th>
          <th>Status pembayaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "koneksi.php";

        $user_id = null;
        if (isset($_SESSION['login_member']))
          $user_id = $_SESSION['login_member'];

        $query = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id_user='$user_id'");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td><?php echo $row['id_pemesanan']; ?></td>
            <td><?php echo $row['tanggal_pemesanan']; ?></td>
            <td>Rp. <?php echo number_format($row['total_belanja']); ?></td>
            <td><?php echo $row['metode_pembayaran']; ?></td>
            <td><?php echo $row['status_bungkus']; ?></td>
            <td><?php echo $row['status_pembayaran']; ?></td>
            <td>
              <a href="hapus_registrasi.php?id_pemesanan=<?php echo $row['id_pemesanan']; ?>" class="btn btn-danger btn-sm">Hapus</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
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