<?php
include 'koneksi.php';

$result = false; 
$keyword = "";

if (isset($_GET['cari'])) {
    $keyword = $_GET['keyword'];
    if (!empty($keyword)) {
        $query = "SELECT * FROM penerima WHERE nama LIKE '%$keyword%' OR alamat LIKE '%$keyword%'";
        $result = mysqli_query($koneksi, $query);
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Penerima Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/7324/7324832.png" type="image/x-icon">

    <style>
        body { 
            font-family: 'Montserrat', sans-serif; 
            background-color: #000000 !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://source.unsplash.com/1600x900/?community,help');
            background-size: cover;
            background-position: center;
            padding: 100px 0; 
            text-align: center;
            border-bottom: none; 
            min-height: 60vh; 
            display: flex;
            align-items: center;
        }

        .card-custom { 
            border: 1px solid #333;
            background-color: #111;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">PENERIMA BANSOS</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-outline-light btn-sm fw-bold px-3">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="btn btn-primary btn-sm fw-bold px-3">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="hero-section text-white">
        <div class="container">
            <h1 class="fw-bold mb-3" style="font-size: 3rem;">Cek Penerima Bantuan Sosial</h1>
            <p class="lead mb-5 text-secondary">Masukkan nama penerima untuk melihat status bantuan.</p>
            
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="" method="GET" class="d-flex gap-2 shadow-lg p-2 bg-dark rounded border border-secondary">
                        <input type="text" name="keyword" class="form-control form-control-lg border-0 bg-dark text-white" 
                               placeholder="Ketik Nama Penerima..." 
                               value="<?php echo htmlspecialchars($keyword); ?>" required autocomplete="off">
                        <button type="submit" name="cari" class="btn btn-primary btn-lg fw-bold px-4">CARI</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if ($result) : ?>
    <div class="container mt-5 mb-5" id="hasil-pencarian">
        <div class="card card-custom shadow-lg">
            
            <div class="card-header bg-primary text-white fw-bold border-0">
                Data Hasil Pencarian : "<?php echo htmlspecialchars($keyword); ?>"
            </div>

            <div class="card-body">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penerima</th>
                                    <th>NIK</th> 
                                    <th>Alamat</th>
                                    <th>Jenis Bantuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)): 
                                    
                                    $badge_color = 'bg-secondary';
                                    if($row['status_penyaluran'] == 'Sudah Disalurkan') $badge_color = 'bg-success';
                                    if($row['status_penyaluran'] == 'Belum Disalurkan') $badge_color = 'bg-danger';
                                    if($row['status_penyaluran'] == 'Proses Verifikasi') $badge_color = 'bg-warning text-dark';
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="fw-bold"><?php echo $row['nama']; ?></td>
                                    <td><?php echo $row['nik']; ?></td>
                                    <td><?php echo $row['alamat']; ?></td>
                                    <td><span class="badge bg-info text-dark"><?php echo $row['jenis_bantuan']; ?></span></td>
                                    <td><span class="badge <?php echo $badge_color; ?>"><?php echo $row['status_penyaluran']; ?></span></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger text-center py-5 mb-0" role="alert">
                        <h4 class="alert-heading">Data Tidak Ditemukan!</h4>
                        <p>Maaf, tidak ada data penerima bansos dengan nama <strong>"<?php echo htmlspecialchars($keyword); ?>"</strong>.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?> 

    <footer class="text-center text-secondary py-4 border-top border-dark mt-auto">
        <p class="mb-0 small">© 2025 Web Penerima Bansos.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>