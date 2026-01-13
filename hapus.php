<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = $_GET['id']; // ini dia ambil id yang mau dihapus, terus jalanin query yang ada di bawah ini
$query = "DELETE FROM penerima WHERE id = $id";

// ini kita kirim parameter ?pesan=hapus biar admin.php nya tau kalau ngehapus data sukses
if (mysqli_query($koneksi, $query)) {
    
    header("Location: admin.php?pesan=hapus");
} else {
    header("Location: admin.php?pesan=gagalhapus");
}
?>