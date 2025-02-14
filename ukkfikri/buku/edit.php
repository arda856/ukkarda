<?php
include '../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM buku WHERE buku_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$buku = $result->fetch_assoc();

if (!$buku) {
    header("Location: list.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];

    $stmt = $conn->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=? WHERE buku_id=?");
    $stmt->bind_param("sssii", $judul, $penulis, $penerbit, $tahun, $id);
    
    if ($stmt->execute()) {
        header("Location: list.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Buku</title>
</head>
<body>
    <h2>Edit Buku</h2>
    <form method="POST">
        <input type="text" name="judul" value="<?= htmlspecialchars($buku['judul']) ?>" required>
        <input type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
        <input type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']) ?>" required>
        <input type="number" name="tahun" value="<?= $buku['tahun_terbit'] ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="list.php">Batal</a>
</body>
</html>
