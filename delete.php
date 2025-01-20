<?php
include 'koneksi.php';

if (isset($_GET['FotoID'])) {
    $fotoID = $_GET['FotoID'];

    mysqli_begin_transaction($con);

    try {
        $queryDeleteLike = "DELETE FROM likefoto WHERE FotoID = ?";
        $stmt = $con->prepare($queryDeleteLike);
        $stmt->bind_param("i", $fotoID);
        $stmt->execute();

        $queryDeleteKomentar = "DELETE FROM komentarfoto WHERE FotoID = ?";
        $stmt = $con->prepare($queryDeleteKomentar);
        $stmt->bind_param("i", $fotoID);
        $stmt->execute();

        $queryDeleteFoto = "DELETE FROM foto WHERE FotoID = ?";
        $stmt = $con->prepare($queryDeleteFoto);
        $stmt->bind_param("i", $fotoID);
        $stmt->execute();

        mysqli_commit($con);
        header("Location: dashboard.php");
        echo "Foto berhasil dihapus beserta data terkait.";
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "Terjadi kesalahan saat menghapus foto: " . $e->getMessage();
    }

    $stmt->close();
}
?>
