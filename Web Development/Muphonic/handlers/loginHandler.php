<?php
session_start();
require_once('dao.php');


$_SESSION['presets'] = array($_POST);
if(isset($_POST["email"])){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$correct = true;
	if(empty($username)){
		$messages['username'] = "Please enter a name";
		$correct = false;
	}
	if(empty($password)){
		$messages['password'] = "Please enter a password";
		$correct = false;
	}
	if(empty($email)){
		$messages['email'] = "Please provide an email";
		$correct = false;
	}
	$regex = "/[a-zA-Z0-9_\-\.+]+@[a-zA-Z0-9\-]+.[a-zA-Z]+/";
	if(!preg_match($regex, $email)){
		$messages['email'] = "Invalid email format xxxxx@xxxxx.xxx $email";
		$correct = false;
	}
	if($correct == false){
		$_SESSION['messages'] = $messages;
		header("Location: ../create_user.php");
		exit;
	}
$newAccount = array(
	"username"=>htmlspecialchars($_POST["username"]),
	"password"=>password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT),
	"email"=>htmlspecialchars($_POST["email"])
);
$dao = new dao();

$dao->insert_User($newAccount);
header("Location: ../index.php");
exit;
}
else{
	$username = $_POST["username"];
	$password = $_POST["password"];
	$correct = true;
	if(empty($username)){
		$messages['username'] = "Please enter a Name";
		$correct = false;
	}
	if(empty($password)){
		$messages['password'] = "Please enter a Password";
		$correct = false;
	}

	$getAccount = array(
		"username"=>htmlspecialchars($username),
		"password"=>htmlspecialchars($password)
	);
	$dao = new dao();

	$userdata = $dao->get_User($getAccount);
	$user = array_shift($userdata);

	if(!password_verify($getAccount['password'], $user['password'])){
		$messages['password'] = "Incorrect Password";
		$correct = false;
	}else{


	if(!empty($user['user_id'])){
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['email'] = $user['email'];
	}else{
		$messages['notFound'] = "User not found";
		$correct = false;
	}
}
	if($correct == false){
		$_SESSION['messages'] = $messages;
		header("Location: ../index.php");
		exit;
	}

	header('Location: ../home_page.php');

}


?>
