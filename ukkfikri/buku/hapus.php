<?php
include '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM buku WHERE buku_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: list.php");
        exit;
    }
}

header("Location: list.php");
exit;
?>
