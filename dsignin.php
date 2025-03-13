<?php
include 'connect.php';
$error="";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $error="Email and password are required!";
    }
    $stmt = $conn->prepare("SELECT driverid, email, password FROM drivers WHERE email = ?");
    if (!$stmt) {
        $error="'Prepare failed: ' . $conn->error";
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($driverid, $dbEmail, $dbPassword);
        $stmt->fetch();
        if (password_verify($password, $dbPassword)) {
            echo "Login Successful!";
            session_start();
            $_SESSION['driverid'] = $driverid;
            header("Location: ddashboard.php");
            exit();
        } else {
            $error="Invalid email or password";
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Driver Sign In</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <h1>Driver Sign In</h1>
    <form method="post" action="">
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter email" required>
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="submit" name="submit" value="Sign In">
        <p>Don't have an account?<a href="dsignup.php">Sign Up</a></p>
        <input type="hidden" id="errorMessage" value="<?php echo htmlspecialchars($error); ?>">
    </form>
    <div class="popup-overlay" id="popupOverlay"></div>
    <div class="popup" id="popup">
        <div class="popup-content">
            <p id="popupMessage"></p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>