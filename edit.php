<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

include "koneksi.php";

if (isset($_GET['id'])) {
    $fotoID = intval($_GET['id']);
    $query = "SELECT * FROM foto WHERE FotoID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $fotoID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $foto = mysqli_fetch_assoc($result);

    if (!$foto) {
        $_SESSION['message'] = "Foto tidak ditemukan.";
        header("Location: dashboard.php");
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['message'] = "ID foto tidak ditemukan.";
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $album = intval($_POST['album']);
    $lokasiFotoBaru = $foto['LokasiFoto'];

    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "berkas/";
        $fileName = basename($_FILES['foto']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
                $lokasiFotoBaru = $fileName;
            } else {
                $_SESSION['message'] = "Gagal mengunggah foto baru.";
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Format file tidak valid. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            header("Location: dashboard.php");
            exit();
        }
    }

    $query = "UPDATE foto SET JudulFoto = ?, DeskripsiFoto = ?, TanggalUnggah = ?, AlbumID = ?, LokasiFoto = ? WHERE FotoID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssisi", $judul, $deskripsi, $tanggal, $album, $lokasiFotoBaru, $fotoID);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Foto berhasil diperbarui.";
    } else {
        $_SESSION['message'] = "Gagal memperbarui data foto.";
    }
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
</head>
<body>
    <h3>Edit Foto</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="judul">Judul Foto:</label>
        <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($foto['JudulFoto']); ?>" required><br><br>
        
        <label for="deskripsi">Deskripsi Foto:</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($foto['DeskripsiFoto']); ?></textarea><br><br>
        
        <label for="tanggal">Tanggal Unggah:</label>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($foto['TanggalUnggah']); ?>" required><br><br>
        
        <label for="album">Album:</label>
        <select name="album" id="album" required>
            <?php
            $query = "SELECT * FROM album";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $selected = ($row['AlbumID'] == $foto['AlbumID']) ? "selected" : "";
                echo "<option value='{$row['AlbumID']}' $selected>{$row['NamaAlbum']}</option>";
            }
            ?>
        </select><br><br>
        
        <label for="foto">Unggah Foto Baru (Opsional):</label>
        <input type="file" id="foto" name="foto"><br><br>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="dashboard.php">Batal</a>
    </form>
</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
