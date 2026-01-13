<?php
session_start(); // mulai sesi untuk bisa mengakses data sesi saat ini
$_SESSION = []; // ngosongin semua variabel sesi
session_unset(); // ini ngehapus variabel sesi
session_destroy(); // ini hancurin sesi sepenuhnya

// redirect ke halaman login
header("Location: login.php");
exit;
?>