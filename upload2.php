<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Unggah Foto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="upload.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
      <!-- Formulir Pencarian -->
      <form class="d-flex" role="search" method="get" action="beranda2.php">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<div class="form-container">
    <h1>Form Unggah Foto</h1>
    <form action="submit.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="JudulFoto" class="form-label">Judul Foto</label>
            <input type="text" id="JudulFoto" name="JudulFoto" class="form-control" placeholder="Masukkan judul foto" required>
        </div>

        <div class="mb-3">
            <label for="DeskripsiFoto" class="form-label">Deskripsi Foto</label>
            <textarea id="DeskripsiFoto" name="DeskripsiFoto" class="form-control" rows="3" placeholder="Masukkan deskripsi foto" required></textarea>
        </div>

        <div class="mb-3">
            <label for="TanggalUnggah" class="form-label">Tanggal Unggah</label>
            <input type="date" id="TanggalUnggah" name="TanggalUnggah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="AlbumId" class="form-label">Pilih Album</label>
            <select id="AlbumId" name="AlbumId" class="form-select" required>
                <option value="">--Pilih Album--</option>
                <?php
                include 'koneksi.php';
                $query = "SELECT AlbumID, NamaAlbum FROM album";
                $result = mysqli_query($con, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . htmlspecialchars($row['AlbumID']) . "'>" . htmlspecialchars($row['NamaAlbum']) . "</option>";
                }
                mysqli_close($con);
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="LokasiFoto" class="form-label">Pilih Foto</label>
            <input type="file" id="LokasiFoto" name="LokasiFoto" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Unggah Foto</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
