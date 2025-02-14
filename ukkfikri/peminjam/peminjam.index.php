<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Peminjam Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Peminjam Dashboard</h2>
    <a href="../buku/list.php">Lihat Buku</a> |
    <a href="../auth/logout.php">Logout</a>
</body>
</html>
