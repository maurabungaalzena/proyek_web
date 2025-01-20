<?php
include "koneksi.php";

$Username = trim($_POST['Username']);
$Password = trim($_POST['Password']);
$Email = trim($_POST['Email']);
$NamaLengkap = trim($_POST['NamaLengkap']);
$Alamat = trim($_POST['Alamat']);
$hashed_password = md5($Password);

$targetDir = "berkas/";
$uploadOk = 1;

if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
    $fileName = basename($_FILES["foto_profil"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["foto_profil"]["tmp_name"]);
    if ($check === false) {
        echo "File yang diunggah bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES["foto_profil"]["size"] > 2000000) {
        echo "Ukuran file terlalu besar (maksimal 2MB).";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    if ($uploadOk) {
        if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $targetFilePath)) {
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
            $uploadOk = 0;
        }
    }
} else {
    $uploadOk = 0;
    echo "Silakan unggah foto profil.";
}

$cek_query = "SELECT * FROM user WHERE Username = '$Username'";
$result = mysqli_query($con, $cek_query);

if (mysqli_num_rows($result) > 0) {
    echo "Username sudah digunakan. Silakan pilih username lain.";
} else {
    if ($uploadOk) {
        $query = "INSERT INTO user (Username, Password, Email, NamaLengkap, Alamat, img) 
                  VALUES ('$Username', '$hashed_password', '$Email', '$NamaLengkap', '$Alamat', '$fileName')";

        if (mysqli_query($con, $query)) {
            echo "Registrasi berhasil.";
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>
