<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    

<div class="container">
    <div class="header">
        <img src="berkas/logoku.png" alt="Logo" class="logo">
        <h1 class="description">REGISTER</h1>
    </div>

    
    <form action="submit-register.php" method="post" enctype="multipart/form-data">
    <label for="Username">Username:</label>
    <input type="text" name="Username" required>
    <br><br>
    
    <label for="Password">Password:</label>
    <input type="password" name="Password" required>
    <br><br>
    
    <label for="Email">Email:</label>
    <input type="email" name="Email" required>
    <br><br>
    
    <label for="NamaLengkap">Nama Lengkap:</label>
    <input type="text" name="NamaLengkap" required>
    <br><br>
    
    <label for="Alamat">Alamat:</label>
    <textarea name="Alamat" required></textarea>
    <br><br>
    
    <label for="foto_profil">Foto Profil:</label>
    <input type="file" name="foto_profil" required>
    <br><br>
    
    <button type="submit">Daftar</button>
</form>
</body>
</html>
