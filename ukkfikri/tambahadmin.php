<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ukkfikri';


$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$username = "admin";
$email = "admin@email.com";
$nama_lengkap = "Admin Perpus";
$alamat = "Jl. Perpustakaan No. 1";
$role = "admin";
$password_plain = "admin"; 
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

$cek_admin = $conn->query("SELECT * FROM user WHERE role = 'admin'");
if ($cek_admin->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO user (username, password, email, nama_lengkap, alamat, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password_hashed, $email, $nama_lengkap, $alamat, $role);

    if ($stmt->execute()) {
        echo "Admin berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan admin: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Admin sudah ada di database.";
}

$conn->close();
?>
