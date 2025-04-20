<?php 
    include('koneksi.php');
    session_start();
      if(!isset($_SESSION['login_admin'])) {
        header("location: login.php");
      }else{
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

    <title>Ikan Segar Jamila </title>
  </head>
  <body>

  <!-- Navbar -->
      <nav class="navbar navbar-expand-lg  bg-dark">
        <div class="container">
        <a class="navbar-brand text-white" href="admin.php"><strong>Ikan Segar</strong> Jamila </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link mr-4" href="admin.php">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mr-4" href="daftar_member.php">KELOLA MEMBER</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mr-4" href="daftar_menu.php">DAFTAR MENU</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mr-4" href="pesanan.php">PESANAN</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mr-4" href="logout.php">LOGOUT</a>
            </li>
          </ul>
        </div>
       </div> 
      </nav>
  <!-- Akhir Navbar -->

  <!-- Menu -->
  <div class="container">
    <div class="judul-pesanan mt-5">
      <h3 class="text-center font-weight-bold">KELOLA DATA PELANGGAN</h3>
    </div>
    <table class="table table-bordered" id="kelola_member">
      <thead class="thead-light">
        <tr>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Username</th>
          <th>Jenis Kelamin</th>
          <th>Tanggal Lahir</th>
          <th>No Telepon</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $nomor = 1; 
          $totalbelanja = 0;
          $ambil = $koneksi->query("
            SELECT pemesanan_produk.*, produk.nama_menu, produk.harga, pemesanan.status_pembayaran, pemesanan.status_bungkus 
            FROM pemesanan_produk 
            JOIN produk ON pemesanan_produk.id_menu = produk.id_menu 
            JOIN pemesanan ON pemesanan_produk.id_pemesanan = pemesanan.id_pemesanan
            WHERE pemesanan_produk.id_pemesanan = '$_GET[id]'
          ");
          while ($pecah = $ambil->fetch_assoc()) { 
            $subharga = $pecah['harga'] * $pecah['jumlah'];
            $totalbelanja += $subharga;
        ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $pecah['id_pemesanan_produk']; ?></td>
          <td><?php echo $pecah['nama_menu']; ?></td>
          <td>Rp. <?php echo number_format($pecah['harga']); ?></td>
          <td><?php echo $pecah['jumlah']; ?></td>
          <td><?php echo $pecah['status_pembayaran']; ?></td>
          <td><?php echo $pecah['status_bungkus']; ?></td>
          <td>Rp. <?php echo number_format($subharga); ?></td>
        </tr>
        <?php $nomor++; } ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="7">Total Bayar</th>
          <th>Rp. <?php echo number_format($totalbelanja); ?></th>
        </tr>
      </tfoot>
    </table>
    <br>
    <form method="POST" action="">
      <a href="pesanan.php" class="btn btn-success btn-sm">Kembali</a>
      <button class="btn btn-primary btn-sm" name="bayar">Konfirmasi</button>
    </form>
    <?php 
if (isset($_POST["bayar"])) {
    $id_pemesanan = $_GET['id']; // Ambil ID pemesanan dari parameter URL
    $koneksi->query("
        UPDATE pemesanan 
        SET status_pembayaran = 'Lunas', status_bungkus = 'Sudah Dibungkus' 
        WHERE id_pemesanan = '$id_pemesanan'
    ");
    echo "<script>alert('Pesanan Telah Dibayar dan Sudah Dibungkus!');</script>";
    echo "<script>location= 'pesanan.php'</script>";
}
?>
    <?php 
      if (isset($_POST["bayar"])) {
        echo "<script>alert('Pesanan Telah Dibayar!');</script>";
        echo "<script>location= 'pesanan.php'</script>";
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
            <strong>Copyright</strong> <i class="far fa-copyright"></i> 2024 -  Designed by AlyaNurOktapiani</p>
          </div>
          </div>

          <div class="col-md-6 d-flex justify-content-end">
          <div class="icon-contact">
          <label class="font-weight-bold">Follow Us </label>
          <a href="#"><img src="images/icon/fb.png" class="mr-3 ml-4" data-toggle="tooltip" title="Facebook"></a>
          <a href="#"><img src="images/icon/ig.png" class="mr-3" data-toggle="tooltip" title="Instagram"></a>
          <a href="#"><img src="images/icon/twitter.png" class="" data-toggle="tooltip" title="Twitter"></a>
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
          $('#kelola_member').DataTable();
      } );
    </script>
  </body>
</html>
<?php } ?>