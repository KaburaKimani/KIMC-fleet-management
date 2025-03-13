<?php
include 'connect.php';
session_start();
$conn = new mysqli('localhost', 'root', '', 'kimc_fleetmanagement');

if (!isset($_SESSION['driverid'])) {
    header("Location: dsignin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT fullName, email, profile_photo FROM drivers WHERE driverid = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle name update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_name'])) {
    $new_name = $_POST['fullName'];
    $stmt = $conn->prepare("UPDATE drivers SET fullName = ? WHERE driverid = ?");
    $stmt->bind_param("si", $new_name, $user_id);
    if ($stmt->execute()) {
        header("Location: dprofile.php");
        exit();
    } else {
        echo "Error updating name.";
    }
    $stmt->close();
}

// Handle profile photo update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_photo'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
    }

    $file_name = basename($_FILES["profile_photo"]["name"]);
    $target_file = $target_dir . $file_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type and size
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($image_file_type, $allowed_types) && $_FILES["profile_photo"]["size"] <= 5000000) { // 5MB max size
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE drivers SET profile_photo = ? WHERE driverid = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            if ($stmt->execute()) {
                header("Location: dprofile.php");
                exit();
            } else {
                echo "Error updating profile photo.";
            }
            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type or size. Allowed types: JPG, JPEG, PNG, GIF. Max size: 5MB.";
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
