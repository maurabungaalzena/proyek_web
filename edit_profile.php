<?php
session_start();
include "koneksi.php";  // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['UserID'];

// Fetch the current user data
$query = "SELECT * FROM user WHERE UserID = '$user_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User data not found.";
    exit();
}

// Handle form submission to update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form
    $new_name = mysqli_real_escape_string($con, $_POST['NamaLengkap']);
    $new_username = mysqli_real_escape_string($con, $_POST['Username']);
    $new_email = mysqli_real_escape_string($con, $_POST['Email']);
    $new_address = mysqli_real_escape_string($con, $_POST['Alamat']);
    
    // Handle image upload
    $new_img = $user['img'];  // Keep current image if no new image is uploaded

    if ($_FILES['img']['name'] != '') {
        $img_name = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_name_new = time() . '.' . $img_ext;
        $img_path = 'berkas/' . $img_name_new;

        // Move uploaded image to the server
        if (move_uploaded_file($img_tmp, $img_path)) {
            $new_img = $img_name_new;  // Update the profile image
        }
    }

    // Update the user's profile information in the database
    $update_query = "UPDATE user SET 
                        NamaLengkap = '$new_name', 
                        Username = '$new_username', 
                        Email = '$new_email', 
                        Alamat = '$new_address',
                        img = '$new_img'
                    WHERE UserID = '$user_id'";

    if (mysqli_query($con, $update_query)) {
        echo "Profile updated successfully!";
        // Optionally redirect to the dashboard after successful update
        header("Location: account.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css">
</head>
<body>

    <div class="container">
        <div class="edit-profile-form">
            <h2>Edit Your Profile</h2>
            <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
               
                <label for="NamaLengkap">Full Name</label>
                <input type="text" id="NamaLengkap" name="NamaLengkap" value="<?php echo htmlspecialchars($user['NamaLengkap']); ?>" required>

               
                <label for="Username">Username</label>
                <input type="text" id="Username" name="Username" value="<?php echo htmlspecialchars($user['Username']); ?>" required>

                
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

                
                <label for="Alamat">Address</label>
                <textarea id="Alamat" name="Alamat" required><?php echo htmlspecialchars($user['Alamat']); ?></textarea>

                
                <label for="img">Profile Image (Optional)</label>
                <input type="file" id="img" name="img">
                <small>Leave empty if you don't want to change the image</small>

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>

</body>
<footer class="bg-body-tertiary text-center py-3 mt-5">
    <div class="container">
        <p>&copy; 2025 Azure Lens. All rights reserved.</p>
    </div>
</footer>
</html>
