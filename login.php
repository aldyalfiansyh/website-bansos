<?php
session_start(); // ini harus ada buat inget sesi login browser

// ini logika kalo udah login, langsung pindah ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: admin.php");
    exit;
}

include 'koneksi.php';

// ini kalo tombol login ditekan, dia bakal menjalankan query sql untuk mencari username dan password yang diinputkan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // nah yang ini nih
    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    
    // ini logika buat cek username apakah username tsb ada di database
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // ini juga logika kalo misal dia password dari username tsb bener, bakal langsung redirect ke dashboard admin
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            header("Location: admin.php");
            exit;
        }
        // if ($password == $row['password'])
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7324/7324832.png" type="image/x-icon">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-black">
    <div class="card p-4 shadow-lg" style="width: 400px; background: #111; border: 1px solid #333;">
        <h3 class="text-center text-white mb-4">Login</h3>
        
        <?php if(isset($error)) : ?>
            <div class="alert alert-danger">Username atau Password salah!</div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control bg-dark text-white" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control bg-dark text-white" placeholder="Password" required>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary w-100 fw-bold">Login</button>
            
            <p class="text-secondary text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
        </form>
    </div>
</body>
</html>