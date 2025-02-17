<?php
   $fullName=$_POST['fullName'];
   $email=$_POST['email'];
   $password=$_POST['password'];
   $dateofbirth=$_POST['dateofbirth'];

$hashedpassword=password_hash($password, PASSWORD_DEFAULT);
$conn=new mysqli('localhost','root','','kimc_fleetmanagement');
 if($conn->connect_error){
	die('Connection failed: '.$conn->connect_error);
 }else{
	 $stmt=$conn->prepare("insert into drivers(fullName,email,password,dateofbirth) values(?,?,?,?)");
	 $stmt->bind_param("ssss",$fullName,$email,$hashedpassword,$dateofbirth);
	 $stmt->execute();
	 echo "Registration Successful";
	 $stmt->close();
 }
 $conn->close();
?>