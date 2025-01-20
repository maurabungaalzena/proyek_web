<?php
include 'koneksi.php';
session_start();

$foto_id = $_GET['id'] ?? null;

if ($foto_id) {
    $query = "SELECT * FROM foto WHERE FotoID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $foto_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $judul = htmlspecialchars($row['JudulFoto']);
        $deskripsi = htmlspecialchars($row['DeskripsiFoto']);
        $tanggal = htmlspecialchars($row['TanggalUnggah']);
        $lokasi = htmlspecialchars($row['LokasiFoto']);
    } else {
        echo "Foto tidak ditemukan!";
        exit;
    }

    if (isset($_POST['hapus_foto'])) {
        $file_path = "berkas/" . $lokasi;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $query_delete = "DELETE FROM foto WHERE FotoID = ?";
        $stmt_delete = mysqli_prepare($con, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $foto_id);
        mysqli_stmt_execute($stmt_delete);

        echo "Foto berhasil dihapus!";
        header("Location: account.php");
        exit();
    }

    if (isset($_POST['edit_foto'])) {
        $new_judul = trim($_POST['judul']);
        $new_deskripsi = trim($_POST['deskripsi']);
        $new_lokasi = trim($_POST['lokasi']);

        $query_update = "UPDATE foto SET JudulFoto = ?, DeskripsiFoto = ?, LokasiFoto = ? WHERE FotoID = ?";
        $stmt_update = mysqli_prepare($con, $query_update);
        mysqli_stmt_bind_param($stmt_update, "sssi", $new_judul, $new_deskripsi, $new_lokasi, $foto_id);
        mysqli_stmt_execute($stmt_update);

        echo "Informasi foto berhasil diperbarui!";
        header("Location: account.php?id=" . $foto_id);
        exit();
    }
} else {
    echo "ID foto tidak valid!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="beranda2.css">
    <link rel="stylesheet" href="halaman_lain2.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary navigasi">  
  <div class="container-fluid">
    <img src="berkas/logogue.png" alt="" class="navbar-logo">
    <p1>azure lens</p1>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="beranda2.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="upload2.php">Upload</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="account.php">Account</a>
        </li>
      </ul>
      <form class="d-flex" role="search" method="get" action="beranda2.php">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<div class="container">
    <h1><?= $judul; ?></h1>
    <img src="berkas/<?= $lokasi; ?>" alt="Foto">
    <p><strong>Deskripsi:</strong> <?= $deskripsi; ?></p>
    <p><strong>Tanggal Unggah:</strong> <?= $tanggal; ?></p>
    
    <form method="POST">
        <h3>Edit Informasi Foto</h3>
        <input type="text" name="judul" value="<?= $judul; ?>" placeholder="Judul Foto" required>
        <textarea name="deskripsi" rows="4" placeholder="Deskripsi Foto"><?= $deskripsi; ?></textarea>
        <input type="text" name="lokasi" value="<?= $lokasi; ?>" placeholder="Nama File Lokasi" required>
        <button type="submit" name="edit_foto" class="edit-button">Simpan Perubahan</button>
    </form>

    <form method="POST">
        <button type="submit" name="hapus_foto" class="delete-button">Hapus Foto</button>
    </form>
</div>
</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
