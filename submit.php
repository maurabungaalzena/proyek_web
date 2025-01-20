<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['UserID'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

$UserID = $_SESSION['UserID'];

$JudulFoto = $_POST['JudulFoto'];
$DeskripsiFoto = $_POST['DeskripsiFoto'];
$TanggalUnggah = $_POST['TanggalUnggah'];
$AlbumID = $_POST['AlbumId'];

if (isset($_FILES['LokasiFoto']) && $_FILES['LokasiFoto']['error'] == 0) {
    $target_dir = "berkas/";
    $file_name = basename($_FILES["LokasiFoto"]["name"]);
    $target_file = $target_dir . $file_name;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
    } else {
        if (move_uploaded_file($_FILES["LokasiFoto"]["tmp_name"], $target_file)) {
            $LokasiFoto = $file_name;

            $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFoto, AlbumID, UserID) 
                      VALUES ('$JudulFoto', '$DeskripsiFoto', '$TanggalUnggah', '$LokasiFoto', '$AlbumID', '$UserID')";
            
            if (mysqli_query($con, $query)) {
                header("Location: beranda2.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($con);
            }
        } else {
            echo "Gagal mengupload file.";
        }
    }
} else {
    echo "Tidak ada file yang diupload atau terjadi kesalahan pada file.";
}
?>
