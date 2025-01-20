<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="kelola_pengguna.css">
</head>
<body>
    <div class="container">
        <h1>Daftar Pengguna</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT UserID, Username, Email, Role FROM user";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $userID = htmlspecialchars($row['UserID']);
                        $username = htmlspecialchars($row['Username']);
                        $email = htmlspecialchars($row['Email']);
                        $role = htmlspecialchars($row['Role']);

                        echo "
                        <tr>
                            <td>{$no}</td>
                            <td>{$username}</td>
                            <td>{$email}</td>
                            <td>
                                <form action='update_role.php' method='POST' style='margin: 0;'>
                                    <input type='hidden' name='UserID' value='{$userID}'>
                                    <select name='Role' onchange='this.form.submit()'>
                                        <option value='admin'" . ($role == 'admin' ? ' selected' : '') . ">Admin</option>
                                        <option value='user'" . ($role == 'user' ? ' selected' : '') . ">User</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href='delete_user.php?id={$userID}' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Hapus</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada pengguna yang ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
