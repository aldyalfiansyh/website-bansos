<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// ini variabel untuk menampung status notifikasi
$status_pesan = ""; 

// ini kondisi kalo tombol submit udah diteken, dia bakal jalanin query sql buat masukin data ke database
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $jenis = $_POST['jenis_bantuan'];
    $status = $_POST['status_penyaluran'];

    // nah ini dia query yang dimaksud
    $query = "INSERT INTO penerima (nama, nik, alamat, jenis_bantuan, status_penyaluran) VALUES ('$nama', '$nik', '$alamat', '$jenis', '$status')";
    
    // ini kondisi kalo yg diatas ini berhasil, maka bakal muncul status berhasil atau nggak nya, yang mana ini terhubung sama sweet alert di bawah ini
    if (mysqli_query($koneksi, $query)) {
        $status_pesan = "sukses";
    } else {
        $status_pesan = "gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7324/7324832.png" type="image/x-icon">
</head>
<body class="bg-black p-5">
    <div class="container">
        <div class="card bg-dark border-secondary col-md-8 mx-auto">
            <div class="card-header text-white"><h4>Tambah Data Penerima</h4></div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama" class="form-control bg-black text-white" required></div>
                    <div class="mb-3"><label>NIK</label><input type="number" name="nik" class="form-control bg-black text-white" required></div>
                    <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control bg-black text-white" required></textarea></div>
                    <div class="mb-3"><label>Jenis Bantuan</label>
                        <select name="jenis_bantuan" class="form-select bg-black text-white">
                            <option value="Tunai">Tunai</option>
                            <option value="Sembako">Sembako</option>
                            <option value="PKH">PKH</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Status Penyaluran</label>
                        <select name="status_penyaluran" class="form-select bg-black text-white">
                            <option value="Belum Disalurkan">Belum Disalurkan</option>
                            <option value="Proses Verifikasi">Proses Verifikasi</option>
                            <option value="Sudah Disalurkan">Sudah Disalurkan</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="admin.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // nah yang ini nih yang dimaksud di line 20
        <?php if ($status_pesan == 'sukses'): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data penerima berhasil ditambahkan.',
                icon: 'success',
                background: '#111',
                confirmButtonColor: '#0d6efd'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'admin.php'; // ini dia bakal redirect ke admin kalo klik ok di alert nya
                }
            });
        <?php elseif ($status_pesan == 'gagal'): ?>
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan data.',
                icon: 'error',
                background: '#111'
            });
        <?php endif; ?>
    </script>
</body>
</html>