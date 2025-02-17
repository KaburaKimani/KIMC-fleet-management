<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'kimc_fleetmanagement');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: dsignin.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$result = $conn->query("SELECT fullName, email, profile_photo FROM drivers WHERE id = $user_id");
$user = $result->fetch_assoc();

// Handle name update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_name'])) {
    $new_name = $_POST['fullName'];
    $conn->query("UPDATE users SET fullName = '$new_name' WHERE id = $user_id");
    header("Location: dprofile.php");
}

// Handle profile photo update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_photo'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    
    // Move uploaded file
    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        $conn->query("UPDATE users SET profile_photo = '$target_file' WHERE id = $user_id");
        header("Location: dprofile.php");
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Profile</h1>
        <img src="<?php echo $user['profile_photo']; ?>" alt="Profile Photo" width="150">
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>

        <h2>Update Name</h2>
        <form action="dprofile.php" method="POST">
            <input type="text" name="fullName" value="<?php echo $user['fullName']; ?>" required>
            <button type="submit" name="update_name">Update Name</button>
        </form>

        <h2>Update Profile Photo</h2>
        <form action="dprofile.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_photo" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
