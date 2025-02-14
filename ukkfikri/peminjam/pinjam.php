<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $buku_id = $_POST['buku_id'];
    $tgl_peminjaman = date('Y-m-d');
    $tgl_pengembalian = date('Y-m-d', strtotime('+7 days'));

    $stmt = $conn->prepare("INSERT INTO peminjam (user_id, buku_id, tgl_peminjaman, tgl_pengembalian, status_peminjaman) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("iiss", $user_id, $buku_id, $tgl_peminjaman, $tgl_pengembalian);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil dipinjam.";
    } else {
        $_SESSION['error'] = "Gagal meminjam buku.";
    }

    header("Location: daftar.php");
    exit;
}


$buku_result = $conn->query("SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pinjam Buku</title>
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
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            margin: 30px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        p {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            width: 100%;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pinjam Buku</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="buku_id">Pilih Buku:</label>
            <select name="buku_id" id="buku_id" required>
                <?php while ($row = $buku_result->fetch_assoc()): ?>
                    <option value="<?= $row['buku_id']; ?>"><?= htmlspecialchars($row['judul']); ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Pinjam</button>
        </form>

        <a href="daftar.php">Lihat Peminjaman</a>
    </div>
</body>
</html>
