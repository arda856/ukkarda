<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$total_buku = $conn->query("SELECT COUNT(*) AS total FROM buku")->fetch_assoc()['total'];
$total_peminjam = $conn->query("SELECT COUNT(*) AS total FROM user WHERE role = 'peminjam'")->fetch_assoc()['total'];
$total_peminjaman = $conn->query("SELECT COUNT(*) AS total FROM peminjam")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Style body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        /* Judul */
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        /* Info Box */
        .info-box {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            text-align: center;
        }
        .info-box p {
            font-size: 18px;
            margin: 10px 0;
        }
        /* Navigation */
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav ul li {
            margin: 0;
        }
        nav ul li a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        nav ul li a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['email']); ?>!</h2>
    <h3>Dashboard Perpustakaan Digital</h3>

    <div class="info-box">
        <p>Total Buku: <?= $total_buku; ?></p>
        <p>Total Peminjam: <?= $total_peminjam; ?></p>
        <p>Total Peminjaman: <?= $total_peminjaman; ?></p>
    </div>

    <nav>
        <ul>
            <?php if ($role == 'admin' || $role == 'petugas'): ?>
                <li><a href="laporan/laporan.php">Laporan Peminjaman</a></li>
            <?php endif; ?>
            <li><a href="auth/logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
