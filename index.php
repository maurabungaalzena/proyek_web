<?php
session_start();

if (isset($_SESSION['login_error'])) {
    echo "<p style='color: red;'>" . $_SESSION['login_error'] . "</p>";
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="berkas/logoku.png" alt="Logo" class="logo">
            <h1 class="description">LOGIN</h1>
        </div>

        <form action="ceklogin.php" method="post">
            <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" id="Username" name="Username" required>
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" id="Password" name="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
