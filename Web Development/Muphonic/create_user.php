<?php
session_start();
$_SESSION['current_page'] = "index.php";
include('template/header.php');
?>

<?php
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
<div id="create_account">

  <form  class="create_account_form" action="handlers/loginHandler.php" method="post">

      <input type="text" placeholder="Email" name="email" value="<?php echo isset($presets['email']) ? $presets['email'] : ''; ?>"><br>

      <input type="text" placeholder="Username" name="username" value="<?php echo isset($presets['username']) ? $presets['username'] : '';?>"><br>

      <input type="password" placeholder="Password" name="password" value="<?php echo isset($presets['password']) ? $presets['password'] : '';?>">
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
  <a class="cancel_account" href="index.php">Cancel Account</a>
</div>

<?php include('template/footer.php'); ?>
