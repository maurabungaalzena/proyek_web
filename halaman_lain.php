<?php
include 'koneksi.php';
session_start();

$foto_id = $_GET['id'] ?? null;

if ($foto_id) {
    $query = "SELECT f.*, u.Username FROM foto f
              JOIN user u ON f.UserID = u.UserID
              WHERE f.FotoID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $foto_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $judul = htmlspecialchars($row['JudulFoto']);
        $deskripsi = htmlspecialchars($row['DeskripsiFoto']);
        $tanggal = htmlspecialchars($row['TanggalUnggah']);
        $lokasi = htmlspecialchars($row['LokasiFoto']);
        $username = htmlspecialchars($row['Username']);
    } else {
        echo "Foto tidak ditemukan!";
        exit;
    }

    $query_likes = "SELECT COUNT(*) AS TotalLikes FROM likefoto WHERE FotoID = ?";
    $stmt_likes = mysqli_prepare($con, $query_likes);
    mysqli_stmt_bind_param($stmt_likes, "i", $foto_id);
    mysqli_stmt_execute($stmt_likes);
    $result_likes = mysqli_stmt_get_result($stmt_likes);
    $row_likes = mysqli_fetch_assoc($result_likes);
    $total_likes = $row_likes['TotalLikes'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['komentar'])) {
        $komentar = $_POST['komentar'];
        if (!empty($komentar)) {
            $user_id = $_SESSION['UserID'];
            $query_komentar = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) VALUES (?, ?, ?, NOW())";
            $stmt_komentar = mysqli_prepare($con, $query_komentar);
            mysqli_stmt_bind_param($stmt_komentar, "iis", $foto_id, $user_id, $komentar);
            mysqli_stmt_execute($stmt_komentar);
        }
    }

    $query_komentar = "SELECT IsiKomentar, TanggalKomentar FROM komentarfoto WHERE FotoID = ? ORDER BY TanggalKomentar DESC";
    $stmt_komentar = mysqli_prepare($con, $query_komentar);
    mysqli_stmt_bind_param($stmt_komentar, "i", $foto_id);
    mysqli_stmt_execute($stmt_komentar);
    $result_komentar = mysqli_stmt_get_result($stmt_komentar);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="halaman_lain.css">
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
      <ul class="dropdown-menu">
            <?php
            include 'koneksi.php';
            $query = "SELECT AlbumID, NamaAlbum FROM album";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $album_id = htmlspecialchars($row['AlbumID']);
                    $nama_album = htmlspecialchars($row['NamaAlbum']);
                    echo "<li><a class='dropdown-item' href='album_detail.php?id=$album_id'>$nama_album</a></li>";
                }
            } else {
                echo "<li><a class='dropdown-item' href='#'>Tidak ada album</a></li>";
            }
            mysqli_close($con);
            ?>
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
        <p><strong><?= $username; ?></strong>&nbsp;&nbsp;&nbsp;<?= $deskripsi; ?></p>
        <p><?= $tanggal; ?></p>
        <div class="actions">
            <button class="like-button" onclick="window.location.href='like_photo.php?id=<?= $foto_id; ?>'">
                👍 Like (<?= $total_likes; ?>)
            </button>
        </div>\
        <div class="comment-form">
            <form method="POST">
                <textarea name="komentar" rows="4" placeholder="Tulis komentar..."></textarea>
                <button type="submit">Kirim Komentar</button>
            </form>
        </div>
        <div class="comments">
            <?php while ($comment = mysqli_fetch_assoc($result_komentar)): ?>
                <div class="comment">
                    <p><?= htmlspecialchars($comment['IsiKomentar']); ?></p>
                    <span><?= date("d M Y H:i", strtotime($comment['TanggalKomentar'])); ?></span>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
