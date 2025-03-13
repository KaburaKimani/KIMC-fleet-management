<?php
    //delete operation
    include 'connect.php';
    $deleteid = $_GET['deleteid'];
    $sql = "DELETE FROM drivers WHERE driverid=$deleteid";
    //execute query
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Deleted successfully";
        header("location:adashboard.php");
    } else{
        die(mysqli_connect());
    }





?>