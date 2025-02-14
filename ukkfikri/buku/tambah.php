<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = (int) $_POST['tahun']; 
    $sampul = '';

    if (!empty($_FILES['sampul']['name'])) {
        $target_dir = __DIR__ . '/../uploads/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); 
        }

        $filename = 'sampul_' . uniqid() . '.' . pathinfo($_FILES['sampul']['name'], PATHINFO_EXTENSION);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES['sampul']['tmp_name'], $target_file)) {
            $sampul = $filename;
        } else {
            echo "Gagal mengunggah file.";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, sampul) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error dalam prepare statement: " . $conn->error);
    }

    $stmt->bind_param("sssis", $judul, $penulis, $penerbit, $tahun, $sampul);

    if ($stmt->execute()) {
        header("Location: list.php");
        exit;
    } else {
        echo "Gagal menambahkan buku: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
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
        /* Container form */
        .container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        /* Judul */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
        }
        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        form button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Buku</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="judul" placeholder="Judul" required>
            <input type="text" name="penulis" placeholder="Penulis" required>
            <input type="text" name="penerbit" placeholder="Penerbit" required>
            <input type="number" name="tahun" placeholder="Tahun Terbit" required>
            <input type="file" name="sampul" accept="image/*" required>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
