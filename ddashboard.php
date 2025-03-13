<?php
include "connect.php"; // Ensure this file contains the database connection logic
session_start();

// Check if the driver is logged in
if (!isset($_SESSION['driverid'])) {
    header("Location: dsignin.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch driver details
$driverid = $_SESSION['driverid'];
$sql = "SELECT * FROM drivers WHERE driverid = $driverid";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching driver details: " . mysqli_error($conn));
}

$driver = $result->fetch_assoc(); // Use a different variable to store the result

// Check if driver data was found
if (!$driver) {
    die("Driver not found in the database.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .driver-info, .trips-list {
            margin-bottom: 20px;
        }
        .driver-info h2, .trips-list h2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="driver-info">
            <h2>Driver Information</h2>
            <p><strong>Name:</strong> <?php echo $driver['fullName']; ?></p>
            <p><strong>License Number:</strong> <?php echo $driver['licenseno']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $driver['phoneno']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $driver['phoneno']; ?></p>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn); // Close the database connection
?>