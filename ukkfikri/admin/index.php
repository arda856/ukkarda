<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    
        .dashboard {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }
    
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        nav a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        nav a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Admin Dashboard</h2>
        <nav>
            <a href="../buku/list.php">Kelola Buku</a> |
            <a href="../peminjam/daftar.php">Peminjaman</a> |
            <a href="../auth/logout.php">Logout</a>
        </nav>
    </div>
</body>
</html>
