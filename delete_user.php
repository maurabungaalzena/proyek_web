<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);

    try {
        mysqli_begin_transaction($con);

        $queryLikeFoto = "DELETE likefoto 
                          FROM likefoto 
                          INNER JOIN foto ON likefoto.FotoID = foto.FotoID 
                          INNER JOIN album ON foto.AlbumID = album.AlbumID 
                          WHERE album.UserID = ?";
        $stmtLikeFoto = $con->prepare($queryLikeFoto);
        $stmtLikeFoto->bind_param("i", $userID);
        $stmtLikeFoto->execute();

        $queryFoto = "DELETE foto 
                      FROM foto 
                      INNER JOIN album ON foto.AlbumID = album.AlbumID 
                      WHERE album.UserID = ?";
        $stmtFoto = $con->prepare($queryFoto);
        $stmtFoto->bind_param("i", $userID);
        $stmtFoto->execute();

        $queryAlbum = "DELETE FROM album WHERE UserID = ?";
        $stmtAlbum = $con->prepare($queryAlbum);
        $stmtAlbum->bind_param("i", $userID);
        $stmtAlbum->execute();

        $queryUser = "DELETE FROM user WHERE UserID = ?";
        $stmtUser = $con->prepare($queryUser);
        $stmtUser->bind_param("i", $userID);
        $stmtUser->execute();

        mysqli_commit($con);
        echo "Pengguna dan semua data terkait berhasil dihapus.";
    } catch (mysqli_sql_exception $e) {
        mysqli_rollback($con);
        echo "Gagal menghapus pengguna: " . $e->getMessage();
    }
} else {
    echo "ID pengguna tidak valid.";
}
?>
