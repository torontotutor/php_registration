<?php

session_start();

//PREVENT ACCESS IF NOT LOGGED IN ALREADY

if(!isset($_POST['submit'])){
	die(header("Location: /new_user/"));

}

$_SESSION['formAttempt'] = true;

if(isset($_SESSION['error'])){
	unset($_SESSION['error']);
}

$_SESSION['error'] = array();

$required = array("username","password","c_pass","email","province","region");


//CHECK REQUIRED FIELDS

foreach($required as $requiredField){
	if(!isset($_POST[$requiredField]) || $_POST[$requiredField] == ""){
		$_SESSION['error'][] = $requiredField . " is required.";
	}
}

if(!preg_match('/^[\w .]+$/',$_POST['username'])){
	$_SESSION['error'][] = "Username can only be numbers or letters";
}
if($_POST['password'] != $_POST['c_pass']){
	$_SESSION['error'][] = "Passwords don`t match please retype";
}
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$_SESSION['error'][] = "Invalid email address";
}

//FINAL CHECKS

if(count($_SESSION['error']) > 0){
	die(header("Location: index.php"));
} else {
	if(registerUser($_POST)){
		unset($_SESSION['formAttempt']);
		die(header("Location: success.php"));
	} else {
		error_log("Problem registering user: {$_POST['email']}");
		$_SESSION['error'][] = "Problem registering account";
		die(header("Location: /new_user/"));
	}
}

function registerUser($userData){
	$mysqli = new mysqli(SERVER_NAME, DATABASE_USER, DATABASE_PASS,DATABASE_NAME);
	if($mysqli->connect_errno){
		error_log("Cannot connect to mySQL: " . $mysqli->connect_error);
		return false;
	}
	$email = $mysqli->real_escape_string($_POST['email']);

	//CHECK FOR EXISTING USER

	$findUser = "SELECT id FROM user_info WHERE email = '{$email}'";
	$findResult = $mysqli->query($findUser);
	$findRow = $findResult->fetch_assoc();
	if(isset($findRow['id']) && $findRow['id'] != ""){
		$_SESSION['error'][] = "A user with that email already exists";
		return false;
	}

$username = $mysqli->real_escape_string($_POST['username']);
$cryptedPassword = crypt($_POST['password']);
$password = $mysqli->real_escape_string($cryptedPassword);

if(isset($_POST['profile_pic'])){
	$profile_pic = $mysqli->real_escape_string($_POST['profile_pic']);
} else {
	$profile_pic = "";
}

if(isset($_POST['company'])){
	$company = $mysqli->real_escape_string($_POST['company']);
} else {
	$company = "";
}

if(isset($_POST['company_bio'])){
	$company_bio = $mysqli->real_escape_string($_POST['company_bio']);
} else {
	$company_bio = "";
}

if(isset($_POST['province'])){
	$province = $mysqli->real_escape_string($_POST['province']);
} else {
	$province = "";
}

if(isset($_POST['region'])){
	$region = $mysqli->real_escape_string($_POST['region']);
} else {
	$region = "";
}


$query = "INSERT INTO user_info (username,password,email,profile_pic,company,company_bio,province,region,reg_date) 
VALUES ('{$username}','{$password}','{$email}','{$profile_pic}','{$company}','{$company_bio}','{$province}','{$region}')";

if($mysqli->query($query)){
	$id = $mysqli->insert_id;
	error_log("Inserted {$email} as ID {$id}");
	return true;
} else {
	error_log("Problem inserting {$query}");
	return false;
}

} //END OF FUNCTION REGISTER USER

?>
