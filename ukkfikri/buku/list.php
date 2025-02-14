<?php
session_start();
include '../config/database.php';

$result = $conn->query("SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn-tambah {
            background-color: #28a745;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        img {
            display: block;
            max-width: 80px;
            height: auto;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
        }
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-hapus {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h2>Daftar Buku</h2>
    <a href="tambah.php" class="btn-tambah">Tambah Buku</a>
    <table>
        <tr>
            <th>Sampul</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
        </tr>
        <?php while ($buku = $result->fetch_assoc()) : ?>
            <tr>
                <td>
                    <img src="<?= !empty($buku['sampul']) ? '../uploads/' . $buku['sampul'] : '../uploads/default.jpg' ?>" 
                         alt="Sampul Buku">
                </td>
                <td><?= $buku['judul'] ?></td>
                <td><?= $buku['penulis'] ?></td>
                <td><?= $buku['penerbit'] ?></td>
                <td><?= $buku['tahun_terbit'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $buku['buku_id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="hapus.php?id=<?= $buku['buku_id'] ?>" class="btn btn-hapus" onclick="return confirm('Hapus buku ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
