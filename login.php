<?php 
include 'koneksi.php';
?>

<!doctype html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->

    <title>Halaman Login</title>
    <style>
        body {
            background-image: url('images/Background/bg101.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95); /* Warna putih dengan transparansi 80% */
            padding: 20px;
            border-radius: 10px; /* Membuat tepi form menjadi melengkung */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan efek bayangan */
            max-width: 400px;
            margin: 100px ; /* Agar form berada di tengah layar */
        }
    </style>
  </head>
  <body>
  <!-- Form Login -->
   <div class="container">
   <div class="text-center">
    <!-- Logo -->
    <img src="images/Background/logo.png" alt="Logo" style="width: 300px; height: auto; margin-bottom: 15px;">
    <h4>Selamat Datang</h4>
</div>
  <hr>
  <form method="POST" action="" novalidate>
    <div class="form-group">
        <label for="username">Username</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-user"></i></div>
            </div>
            <input type="text" id="username" class="form-control" placeholder="Masukkan Username" name="username" required>
        </div>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
            </div>
            <input type="password" id="password" class="form-control" placeholder="Masukkan Password" name="password" required autocomplete="off">
        </div>
        <small class="form-text text-muted">Note : "Pelangan tidak perlu mengisi username dan password"</small>
    </div>
    <!-- Tombol untuk login sebagai admin -->
    <button type="submit" name="submit_admin" class="btn btn-primary w-100">LOGIN AS ADMIN</button>
    <!-- Tombol untuk login sebagai user -->
    <button type="submit" name="submit_user" class="btn btn-success w-100 mt-2">LOGIN AS PELANGAN</button>
</form>

</div>
  <!-- Akhir Form Login -->

  <!-- Eksekusi Form Login -->
  <?php 
include 'koneksi.php';

if (isset($_POST['submit_admin']) || isset($_POST['submit_user'])) {
    $user = $_POST['username'];
    $password = $_POST['password'];

    // Cek jika tombol login sebagai user
    if (isset($_POST['submit_user'])) {
        session_start();
        $_SESSION['login_user'] = "user"; // Simulasi login sebagai user
        header('location: user.php'); // Langsung ke halaman user
    }
    // Query untuk memilih tabel
    else {
        $cek_data = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$user' AND password = '$password'");
        $hasil = mysqli_fetch_array($cek_data);
        $status = $hasil['status'];
        $login_user = $hasil['username'];
        $row = mysqli_num_rows($cek_data);

        // Pengecekan Kondisi Login Berhasil/Tidak
        if ($row > 0) {
            session_start();   
            $_SESSION['login_user'] = $login_user;

            // Cek jika tombol login sebagai admin
            if (isset($_POST['submit_admin']) && $status == 'admin') {
                header('location: admin.php');
            } elseif (isset($_POST['submit_user']) && $status == 'user') {
                header('location: user.php');
            } else {
                // Jika status tidak cocok
                echo "<script>alert('Login gagal, periksa kembali status pengguna.');</script>";
            }
        } else {
            header("location: login.php");
        }
    }
}
?>
  <!-- Akhir Eksekusi Form Login -->

  <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
  </body>
</html>
