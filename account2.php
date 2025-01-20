<?php
session_start();
include "koneksi.php";


if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['UserID'];
$query = "SELECT * FROM user WHERE UserID = '$user_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['UserID'];
$query = "SELECT * FROM foto WHERE UserID = '$user_id'";
$photo_result = mysqli_query($con, $query);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="beranda2.css">
    <link rel="stylesheet" href="account2.css">
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
          <a class="nav-link" href="account.php">Account</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="profile-settings">
        <!-- Sidebar Section -->
        <div class="profile-sidebar">
            <img src="berkas/<?php echo htmlspecialchars($user['img']); ?>" alt="Profile Picture">
            <div class="edit-button">
        <button onclick="window.location.href='edit_profile.php'">Edit Profile</button>
    </div>
    <div class="logout-button">
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
        </div>

        <!-- Main Section -->
        <div class="profile-main">
            <h3>User Information</h3>
            <div class="info">
            <h2><?php echo htmlspecialchars($user['NamaLengkap']); ?></h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['Username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['Alamat']); ?></p>
            </div>
            <div class="button-container">
</div>




</body>
</html>
