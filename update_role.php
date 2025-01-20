<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['UserID']);
    $role = htmlspecialchars($_POST['Role']);

    $query = "UPDATE user SET Role = ? WHERE UserID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "si", $role, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Role pengguna berhasil diperbarui.";
    } else {
        echo "Terjadi kesalahan saat memperbarui role.";
    }

    header('Location: dashboard.php'); 
    exit();
}
?>
