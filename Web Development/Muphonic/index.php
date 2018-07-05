<?php
session_start();
$_SESSION['current_page'] = "index.php";
include('template/header.php');
if(isset($_SESSION['user_id'])){
	header('Location: home_page.php');
	exit;
}
?>
<?php
$messages = array();
if (isset($_SESSION['messages'])) {
	$messages = array_shift($_SESSION['messages']);
}
?>
<?php
$presets = array();
if (isset($_SESSION['presets'])) {
	$presets = array_shift($_SESSION['presets']);
}
unset($_SESSION['presets']);
unset($_SESSION['messages']);
?>

			<div class="main">
			<div id="login">
			<form action="handlers/loginHandler.php" method="post">
				<label>Login:</label><br>
				<input type="text" placeholder="Username" name="username" value="<?php echo isset($presets['username']) ? $presets['username'] : ''?>"><br>

				<input type="password" placeholder="Password" name="password" value="<?php echo isset($presets['password']) ? $presets['password'] : ''?>">

				<input type="submit" value="Submit">
			</form>
				<?php
				if(isset($messages)){
					if(count($messages) == 1){
						$messages = array($messages);
					}

				foreach($messages as $message){
								echo "<div class=\"message\">$message</div>";
						}
					}

					?>
			  <a class="create_account" href="create_user.php">Create an Account</a>
		</div>


<?php include('template/footer.php'); ?>
