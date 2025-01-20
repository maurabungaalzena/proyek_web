<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="beranda2.css">
    <link rel="stylesheet" href="dashboard.css">
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
          <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="account2.php">Account</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- TABEL FOTO -->
<h1>Daftar Foto</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Judul Foto</th>
            <th>Deskripsi Foto</th>
            <th>Tanggal</th>
            <th>Album</th>
            <th>User Upload</th>
            <th>Jumlah Komentar</th>
            <th>Jumlah Likes</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'koneksi.php';

        $query = "SELECT foto.FotoID, foto.JudulFoto, foto.DeskripsiFoto, foto.TanggalUnggah, foto.LokasiFoto, album.NamaAlbum, user.Username,
                         (SELECT COUNT(*) FROM komentarfoto WHERE FotoID = foto.FotoID) AS jumlah_komentar,
                         (SELECT COUNT(*) FROM likefoto WHERE FotoID = foto.FotoID) AS jumlah_likes
                  FROM foto 
                  INNER JOIN album ON foto.AlbumID = album.AlbumID 
                  INNER JOIN user ON foto.UserID = user.UserID";
        $result = mysqli_query($con, $query);

        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td><img src='berkas/" . htmlspecialchars($row['LokasiFoto']) . "' width='80'></td>
                    <td>{$row['JudulFoto']}</td>
                    <td>{$row['DeskripsiFoto']}</td>
                    <td>{$row['TanggalUnggah']}</td>
                    <td>{$row['NamaAlbum']}</td>
                    <td>{$row['Username']}</td>
                    <td>{$row['jumlah_komentar']}</td>
                    <td>{$row['jumlah_likes']}</td>
                    <td>
                        <button class='btn-delete' onclick='confirmDelete({$row['FotoID']})'>Delete</button>
                    </td>
                  </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>

<script>
function confirmDelete(FotoID) {
    if (confirm("Apakah Anda yakin ingin menghapus foto ini?")) {
        // Mengarahkan ke file delete.php dengan FotoID sebagai parameter
        window.location.href = "delete.php?FotoID=" + FotoID;
    }
}
</script>

<hr>

<!-- TABEL PENGGUNA -->
<h1>Daftar Pengguna</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT UserID, Username, Email, Role FROM user";
        $result = mysqli_query($con, $query);

        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = htmlspecialchars($row['UserID']);
            $username = htmlspecialchars($row['Username']);
            $email = htmlspecialchars($row['Email']);
            $role = htmlspecialchars($row['Role']);

            echo "<tr>
                    <td>{$no}</td>
                    <td>{$username}</td>
                    <td>{$email}</td>
                    <td>
                        <form action='update_role.php' method='POST' style='margin: 0;'>
                            <input type='hidden' name='UserID' value='{$user_id}'>
                            <select name='Role' onchange='this.form.submit()'>
                                <option value='admin'" . ($role == 'admin' ? ' selected' : '') . ">Admin</option>
                                <option value='user'" . ($role == 'user' ? ' selected' : '') . ">User</option>
                            </select>
                        </form>
                    </td>
                  </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>

</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>


</html>
