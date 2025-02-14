<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT p.peminjaman_id, b.judul, p.tgl_peminjaman, p.tgl_pengembalian, p.status_peminjaman 
          FROM peminjam p 
          JOIN buku b ON p.buku_id = b.buku_id 
          WHERE p.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peminjaman</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f8f8f8;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #0056b3;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Daftar Peminjaman</h2>
    
    <table>
        <tr>
            <th>Judul Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['judul']); ?></td>
            <td><?= $row['tgl_peminjaman']; ?></td>
            <td><?= $row['tgl_pengembalian']; ?></td>
            <td><?= ($row['status_peminjaman'] == 1) ? "Dipinjam" : "Dikembalikan"; ?></td>
            <td>
                <?php if ($row['status_peminjaman'] == 1): ?>
                    <a href="kembali.php?id=<?= $row['peminjaman_id']; ?>">Kembalikan</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="pinjam.php" class="btn">Pinjam Buku</a>
</body>
</html>
