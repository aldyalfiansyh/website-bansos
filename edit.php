<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM penerima WHERE id = '$id'");
$row = mysqli_fetch_assoc($data);

// variabel untuk menampung status notifikasi
$status_pesan = "";

// ini sama kaya di page tambah sih konsepnya, cuman beda di query sql nya aja
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $jenis = $_POST['jenis_bantuan'];
    $status = $_POST['status_penyaluran'];

    // nah yang ini yang dimaksud di atas
    $query = "UPDATE penerima SET nama='$nama', nik='$nik', alamat='$alamat', jenis_bantuan='$jenis', status_penyaluran='$status' WHERE id='$id'";
    
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
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7324/7324832.png" type="image/x-icon">
</head>
<body class="bg-black p-5">
    <div class="container">
        <div class="card bg-dark border-secondary col-md-8 mx-auto">
            <div class="card-header text-white"><h4>Edit Data Penerima</h4></div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama" value="<?= $row['nama'] ?>" class="form-control bg-black text-white" required></div>
                    <div class="mb-3"><label>NIK</label><input type="number" name="nik" value="<?= $row['nik'] ?>" class="form-control bg-black text-white" required></div>
                    <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control bg-black text-white" required><?= $row['alamat'] ?></textarea></div>
                    
                    <div class="mb-3"><label>Jenis Bantuan</label>
                        <select name="jenis_bantuan" class="form-select bg-black text-white">
                            <option value="Tunai" <?= ($row['jenis_bantuan'] == 'Tunai') ? 'selected' : '' ?>>Tunai</option>
                            <option value="Sembako" <?= ($row['jenis_bantuan'] == 'Sembako') ? 'selected' : '' ?>>Sembako</option>
                            <option value="PKH" <?= ($row['jenis_bantuan'] == 'PKH') ? 'selected' : '' ?>>PKH</option>
                        </select>
                    </div>

                    <div class="mb-3"><label>Status Penyaluran</label>
                        <select name="status_penyaluran" class="form-select bg-black text-white">
                            <option value="Belum Disalurkan" <?= ($row['status_penyaluran'] == 'Belum Disalurkan') ? 'selected' : '' ?>>Belum Disalurkan</option>
                            <option value="Proses Verifikasi" <?= ($row['status_penyaluran'] == 'Proses Verifikasi') ? 'selected' : '' ?>>Proses Verifikasi</option>
                            <option value="Sudah Disalurkan" <?= ($row['status_penyaluran'] == 'Sudah Disalurkan') ? 'selected' : '' ?>>Sudah Disalurkan</option>
                        </select>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                    <a href="admin.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // nah yang ini nih yang dimaksud di line no 24
        <?php if ($status_pesan == 'sukses'): ?>
            Swal.fire({
                title: 'Berhasil Update!',
                text: 'Data penerima telah diperbarui.',
                icon: 'success',
                background: '#111',
                confirmButtonColor: '#0d6efd' 
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'admin.php'; 
                }
            });
        <?php elseif ($status_pesan == 'gagal'): ?>
            Swal.fire({
                title: 'Gagal Update!',
                text: 'Terjadi kesalahan sistem.',
                icon: 'error',
                background: '#111'
            });
        <?php endif; ?>
    </script>
</body>
</html>