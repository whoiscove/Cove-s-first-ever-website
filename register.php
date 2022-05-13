<?php
include_once("db_connect.php");
session_start();
if(isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
$error = false;
if (isset($_POST['signup'])) {
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);	
	if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
		$error = true;
		$uname_error = "Name must contain only alphabets and space";
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$email_error = "Please Enter Valid Email ID";
	}
	if(strlen($password) < 6) {
		$error = true;
		$password_error = "Password must be minimum of 6 characters";
	}
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Password and Confirm Password doesn't match";
	}
	if (!$error) {
		if(mysqli_query($conn, "INSERT INTO users(user, email, pass) VALUES('" . $name . "', '" . $email . "', '" . md5($password) . "')")) {
			$success_message = "Successfully Registered! <a href='login.php'>Click here to Login</a>";
		} else {
			$error_message = "Error in registering...Please try again later!";
		}
	}
}
?>