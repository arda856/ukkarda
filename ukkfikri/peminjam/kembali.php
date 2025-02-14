<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['peminjaman_id'])) {
    $peminjaman_id = $_POST['peminjaman_id'];

    $stmt = $conn->prepare("UPDATE peminjam SET status_peminjaman = 0 WHERE peminjaman_id = ?");
    $stmt->bind_param("i", $peminjaman_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Buku berhasil dikembalikan!";
    } else {
        $_SESSION['error'] = "Gagal mengembalikan buku!";
    }

    $stmt->close();
    header("Location: kembali.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT p.peminjaman_id, b.judul, p.tgl_peminjaman, p.tgl_pengembalian 
          FROM peminjam p 
          JOIN buku b ON p.buku_id = b.buku_id 
          WHERE p.user_id = ? AND p.status_peminjaman = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengembalian Buku</title>
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
        /* Container utama */
        .container {
            background-color: #fff;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        /* Style tabel */
        table {
            width: 100%;
            border-collapse: collapse;
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
        /* Style tombol */
        button {
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        /* Style link */
        a {
            display: inline-block;
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
            margin-top: 10px;
        }
        a:hover {
            color: #0056b3;
        }
        /* Style pesan notifikasi */
        .message {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
        /* Hilangkan margin pada form di dalam tabel */
        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pengembalian Buku</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="message success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="message error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['judul']); ?></td>
                <td><?= $row['tgl_peminjaman']; ?></td>
                <td><?= $row['tgl_pengembalian']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="peminjaman_id" value="<?= $row['peminjaman_id']; ?>">
                        <button type="submit">Kembalikan</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <a href="../index.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
