<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: auth/login.php");
    exit;
}

$role = $_SESSION['role'];
if ($role == 'admin') {
    header("Location: admin/index.php");
} elseif ($role == 'petugas') {
    header("Location: petugas/index.php");
} else {
    header("Location: peminjam/index.php");
}
exit;
?>
