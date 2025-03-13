<?php
include 'connect.php';
$error = "";
$success = "";
if (isset($_POST['updateid']) || isset($_GET['updateid'])) {
    $updateid = isset($_POST['updateid']) ? intval($_POST['updateid']) : intval($_GET['updateid']);
    $mysql = "SELECT * FROM drivers WHERE driverid=$updateid";
    $result = mysqli_query($conn, $mysql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fullName = $row['fullName'];
        $email = $row['email'];
        $phoneno = $row['phoneno'];
        $licenseno=$row['licenseno'];
    } else {
        die("Error fetching driver details: " . mysqli_error($conn));
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        if (empty($fullName) || empty($email)) {
            $error = "All fields are required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format!";
        } else {
            $sql = "UPDATE drivers SET fullName='$fullName', email='$email' WHERE driverid=$updateid";

            echo "SQL Query: $sql";

            // Execute the query
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $success = "Driver details updated successfully!";
                header("Location: adashboard.php");
                exit();
            } else {
                $error = "Error updating driver details: " . mysqli_error($conn);
            }
        }
    }
} else {
    $error = "Driver ID not provided.";
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Driver</title>
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
        input {
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
    <h1>Update Driver Details</h1>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="updateid" value="<?php echo $updateid; ?>">
        <label>Full Name</label>
        <input type="text" name="fullName" placeholder="Enter full name" value="<?php echo $fullName; ?>" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter email" value="<?php echo $email; ?>" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" value="<?php echo $password; ?>" required>
        
        <label>Phone Number</label>
        <input type="number" name="phoneno" placeholder="Enter phone number" value="<?php echo isset($phoneno) ? $phoneno : ''; ?>" required>

        <label>Date of birth</label>
        <input type="date" name="date" value="<?php echo $dateofbirth; ?>" required>

        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>