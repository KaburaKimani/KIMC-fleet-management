<?php
include 'connect.php';
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize inputs
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $dateofbirth = mysqli_real_escape_string($conn, $_POST['dateofbirth']);
    $phoneno = isset($_POST['phoneno']) ? mysqli_real_escape_string($conn, $_POST['phoneno']) : ""; // Fix: Check if phoneno is set
    $licenseno = mysqli_real_escape_string($conn, $_POST['licenseno']);

    // Validate inputs
    if (empty($fullName) || empty($email) || empty($password) || empty($dateofbirth) || empty($phoneno) || empty($licenseno)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long!";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phoneno)) {
        $error = "Invalid phone number!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO drivers (fullName, email, password, dateofbirth, phoneno, licenseno) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullName, $email, $hashedPassword, $dateofbirth, $phoneno, $licenseno);

        if ($stmt->execute()) {
            $success = "Driver registered successfully!";
            header("Location: ddashboard.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Driver Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: darkblue;
            color: white;
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Driver Sign Up</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label>Full Name</label>
        <input type="text" name="fullName" placeholder="Enter full name" value="<?php echo isset($fullName) ? $fullName : ''; ?>" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter email" value="<?php echo isset($email) ? $email : ''; ?>" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password (min 8 characters)" value="" required>

        <label>Phone Number</label>
        <input type="number" name="phoneno" placeholder="Enter your phone number" value="<?php echo isset($phoneno) ? $phoneno : ''; ?>" required>

        <label>Date of Birth</label>
        <input type="date" name="dateofbirth" value="<?php echo isset($dateofbirth) ? $dateofbirth : ''; ?>" required>

        <label>License Number</label>
        <input type="text" name="licenseno" placeholder="Enter license number" value="<?php echo isset($licenseno) ? $licenseno : ''; ?>" required>

        <input type="submit" name="submit" value="Sign Up">
        <p>Already have an account? <a href="dsignin.php">Sign In</a></p>
    </form>
</body>
</html>