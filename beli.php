<?php 
session_start();

$id_menu = $_GET['id_menu'];
$action = $_GET['action'] ?? 'add';

if (!isset($_SESSION['pesanan'])) {
    $_SESSION['pesanan'] = [];
}

switch ($action) {
    case 'add':
        if (isset($_SESSION['pesanan'][$id_menu])) {
            $_SESSION['pesanan'][$id_menu]++;
        } else {
            $_SESSION['pesanan'][$id_menu] = 1;
        }
        break;

    case 'plus':
        $_SESSION['pesanan'][$id_menu]++;
        break;

    case 'min':
        $_SESSION['pesanan'][$id_menu]--;
        if ($_SESSION['pesanan'][$id_menu] <= 0) {
            unset($_SESSION['pesanan'][$id_menu]);
        }
        break;
}

header("Location: menu_pembeli.php");
exit;
?>
