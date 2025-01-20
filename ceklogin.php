<?php
session_start();

include "koneksi.php";


$Username = $_POST['Username'];
$Password = md5($_POST['Password']); 

$query = mysqli_query($con, "SELECT * FROM user WHERE Username='$Username' AND Password='$Password'");

$hasilquery = mysqli_num_rows($query);

if ($hasilquery == 1) {
    while ($row = mysqli_fetch_assoc($query)) {
        $_SESSION['Username'] = $row['Username'];
        $_SESSION['NamaLengkap'] = $row['NamaLengkap'];
        $_SESSION['UserID'] = $row['UserID'];
        $_SESSION['role'] = $row['role'];
    }

   
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard.php"); 
    } else {
        header("Location: beranda2.php"); 
    }
    exit();
} else {
    $_SESSION['login_error'] = "Username atau Password salah.";
    header("Location: index.php");
    exit();
}
?>
