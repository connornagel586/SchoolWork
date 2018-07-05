<?php
//header('Location: home_page.php');
session_start();
if(isset($_SESSION['user_id'])){
	$_SESSION['current_page'] = "about_home";
}else{
	$_SESSION['current_page'] = "about_index";
}
include('template/header.php');
?>
	<div class="main">
				<div class="descriptBody">
					<p>The forum's pages have basic functionality. However, the chat still needs work and I need to figure out how to host an audio playlist.</p>
				</div>
<?php include('template/footer.php'); ?>
