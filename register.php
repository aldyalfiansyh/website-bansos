<?php
session_start(); // ini buat cek session 

// ini logika kalo udah login, langsung pindah ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: admin.php");
    exit;
}

include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];

    // ini ngeenkripsi password dari karakter biasa jadi acak
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ini ngejalanin query sql buat masukin data yang udah di isi ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    // ini kondisi kalo berhasil bakal muncul alert berhasil, kalo gak berhasil ya bakal muncul alert gak berhasil
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi Gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7324/7324832.png" type="image/x-icon">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-black">
    <div class="card p-4 shadow-lg" style="width: 400px; background: #111; border: 1px solid #333;">
        <h3 class="text-center text-white mb-4">Register</h3>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control bg-dark text-white" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control bg-dark text-white" placeholder="Password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
            <p class="text-secondary text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>