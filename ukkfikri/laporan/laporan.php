<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("Location: ../index.php");
    exit;
}

$query = "SELECT p.peminjaman_id, u.nama_lengkap, b.judul, p.tgl_peminjaman, p.tgl_pengembalian, p.status_peminjaman
          FROM peminjam p 
          JOIN user u ON p.user_id = u.user_id 
          JOIN buku b ON p.buku_id = b.buku_id 
          ORDER BY p.tgl_peminjaman DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
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
        /* Judul halaman */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        /* Style tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f8f8;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        /* Style link */
        a {
            display: inline-block;
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
            margin-top: 10px;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Laporan Peminjaman</h2>

    <table>
        <tr>
            <th>ID Peminjaman</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['peminjaman_id']; ?></td>
            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
            <td><?= htmlspecialchars($row['judul']); ?></td>
            <td><?= $row['tgl_peminjaman']; ?></td>
            <td><?= $row['tgl_pengembalian']; ?></td>
            <td><?= ($row['status_peminjaman'] == 1) ? "Dipinjam" : "Dikembalikan"; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="../index.php">Kembali ke Dashboard</a>
</body>
</html>
