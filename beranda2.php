<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="beranda2.css">
    
    <style>
      
  .card-img-top {
    max-height: 236px !important;}
    </style>
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
        <!-- Dropdown Items -->
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
      <!-- Search Form -->
      <form class="d-flex" role="search" method="get" action="beranda2.php">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
  <?php
  session_start();
  echo "<h4>Selamat datang, " . htmlspecialchars($_SESSION['NamaLengkap']) . "!</h4>";

  $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

  include 'koneksi.php';

  $sql = "SELECT LokasiFoto, JudulFoto, FotoID FROM foto WHERE JudulFoto LIKE ? OR DeskripsiFoto LIKE ?";
  $stmt = mysqli_prepare($con, $sql);
  $keyword_like = '%' . $keyword . '%';
  mysqli_stmt_bind_param($stmt, 'ss', $keyword_like, $keyword_like);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0): ?>
    <div class="row">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <a href="halaman_lain.php?id=<?= $row['FotoID']; ?>">
              <img src="berkas/<?= htmlspecialchars($row['LokasiFoto']); ?>" class="card-img-top" alt="Foto">
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>Tidak ada foto yang ditemukan berdasarkan pencarian Anda.</p>
  <?php endif;

  mysqli_close($con);
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
