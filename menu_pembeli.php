<?php session_start(); ?>

<!doctype html> 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Marinasi Ikan Nila Jamila</title>

    <!-- Bootstrap & CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
  </head>
  <body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container">
      <a class="navbar-brand text-white" href="guest.php"><strong>Marinasi</strong> Ikan Nila</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link mr-4" href="guest.php">HOME</a></li>
          <li class="nav-item"><a class="nav-link mr-4" href="menu_pembeli.php">DAFTAR MENU</a></li>
          <li class="nav-item"><a class="nav-link mr-4" href="pesanan_pembeli.php">PESANAN ANDA</a></li>
          <?php if (isset($_SESSION['login_member'])): ?>
            <li class="nav-item"><a class="nav-link mr-4" href="tabel_pemesanan.php">TABEL PEMESANAN</a></li>
            <li class="nav-item"><a class="nav-link mr-4" href="logout.php">LOGOUT</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link mr-4" href="login.php">LOGIN</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div> 
  </nav>

  <!-- Menu -->
  <div class="container">
    <div class="row mt-3">
      <?php
        include('koneksi.php');
        $query = mysqli_query($koneksi, 'SELECT * FROM produk');
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
      ?>

      <?php foreach($result as $item): 
        $jumlah = $_SESSION['pesanan'][$item['id_menu']] ?? 0;
      ?>
        <div class="col-md-3 mt-4">
          <div class="card border-dark">
            <img src="upload/<?php echo $item['gambar']; ?>" class="card-img-top" alt="<?php echo $item['nama_menu']; ?>">
            <div class="card-body text-center">
              <h5 class="card-title font-weight-bold"><?php echo $item['nama_menu']; ?></h5>
              <label class="card-text harga"><strong>Rp.</strong> <?php echo number_format($item['harga']); ?></label><br>

              <?php if ($jumlah > 0): ?>
                <div class="d-flex justify-content-center align-items-center">
                  <a href="beli.php?id_menu=<?php echo $item['id_menu']; ?>&action=min" class="btn btn-danger btn-sm mr-2">-</a>
                  <span class="mx-2"><?php echo $jumlah; ?>Kg</span>
                  <a href="beli.php?id_menu=<?php echo $item['id_menu']; ?>&action=plus" class="btn btn-success btn-sm ml-2">+</a>
                </div>
              <?php else: ?>
                <a href="beli.php?id_menu=<?php echo $item['id_menu']; ?>&action=add" class="btn btn-success btn-sm btn-block mt-2">BELI</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Footer -->
  <hr class="footer">
  <div class="container">
    <div class="row footer-body">
      <div class="col-md-6">
        <div class="copyright">
          <strong>Copyright</strong> <i class="far fa-copyright"></i> 2024 - Designed by AlyaNurOktapiani
        </div>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <div class="icon-contact">
          <label class="font-weight-bold">Follow Us </label>
          <a href="#"><img src="images/icon/fb.png" class="mr-3 ml-4" data-toggle="tooltip" title="Facebook"></a>
          <a href="#"><img src="images/icon/ig.png" class="mr-3" data-toggle="tooltip" title="Instagram"></a>
          <a href="#"><img src="images/icon/twitter.png" class="mr-3" data-toggle="tooltip" title="Twitter"></a>
          <a href="https://wa.me/6283863563355?text=Halo%20saya%20ingin%20bertanya%20tentang%20Marinasi%20Ikan%20Nila" target="_blank">
            <img src="images/icon/whatsapp.png" class="mr-3" data-toggle="tooltip" title="WhatsApp"></a>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  </body>
</html>
