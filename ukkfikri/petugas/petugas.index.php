<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Petugas Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Petugas Dashboard</h2>
    <a href="../buku/list.php">Kelola Buku</a> |
    <a href="../auth/logout.php">Logout</a>
</body>
</html>
