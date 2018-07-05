<?php

session_start();
require_once('handlers/dao.php');
$_SESSION['current_page'] = "home_page.php";
if(!isset($_SESSION['user_id'])){
	session_destroy();
	header('Location: index.php');
	exit;
}
include('template/header.php');
?>
	<div class="main">
			<div class="user_body">
				<div class="comments">
					<p>User Comments</p>
				</div>
				<div class="favorites">
					<p>User Favorites</p>
				</div>
			</div>


<?php include('template/footer.php'); ?>
