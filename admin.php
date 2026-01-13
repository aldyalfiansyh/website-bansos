<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// ini ngambil semua data penerima bansos
$query = "SELECT * FROM penerima ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7324/7324832.png" type="image/x-icon">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #000; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold">DASHBOARD ADMIN</a>
            <div class="d-flex gap-2">
                <span class="navbar-text text-white me-3">Halo, <?php echo $_SESSION['username']; ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card bg-dark border-secondary shadow">
            <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">Data Penerima Bansos</h5>
                <a href="tambah.php" class="btn btn-primary fw-bold">+ Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-striped align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>Jenis Bantuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['nik']; ?></td>
                                <td><?= $row['alamat']; ?></td>
                                <td><?= $row['jenis_bantuan']; ?></td>
                                <td><?= $row['status_penyaluran']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-dark">Edit</a>
                                    
                                    <a href="#" onclick="konfirmasiHapus(<?= $row['id']; ?>)" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. Fungsi Konfirmasi Hapus
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#111'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, arahkan ke file hapus.php
                    window.location.href = 'hapus.php?id=' + id;
                }
            })
        }

        // 2. Cek Parameter URL untuk notifikasi Sukses Hapus
        // Kita pakai URLSearchParams untuk cek apakah ada ?pesan=hapus di URL
        const urlParams = new URLSearchParams(window.location.search);
        const pesan = urlParams.get('pesan');

        if (pesan === 'hapus') {
            Swal.fire({
                title: 'Terhapus!',
                text: 'Data berhasil dihapus.',
                icon: 'success',
                background: '#111',
                timer: 2000, // Otomatis tutup setelah 2 detik
                showConfirmButton: false
            });
            // Bersihkan URL agar kalau di-refresh popup tidak muncul lagi
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
</body>
</html>