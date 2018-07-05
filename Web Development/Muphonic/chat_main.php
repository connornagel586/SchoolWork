<?php
//header('Location: home_page.php');
session_start();
require_once('handlers/dao.php');
$_SESSION['current_page'] = "chat_main.php";
if(!isset($_SESSION['user_id'])){
	session_destroy();
	$_SESSION = array();
	header('Location: index.php');
	exit;
}
$dao = new dao();
include('template/header.php');
?>
	<div class="main">
<div class="user_chats">
	<div id='mypinned'><h4>Pinned Chats</h4></div>
</div>
<div class="chat_panel">
	<h4>Chat Rooms</h4>
		<div id='chats'>
			<?php
			$limit = 10;
			$rooms = $dao->get_rooms($limit);


			foreach($rooms as $room){
				$data = $dao->find_user($room['created_by']);
				$username = array_shift($data);
				print	"<div class=\"chat\" value=\"" . $room['room_id']. "\">"
				. $room['room_title'] . "<span>created by " .
				 $username . " " .
				$room['time_created'] . "</span>" .
				"</div>";

			}
			?>
			<div class="new_chat">
			<button type="button" id="add_chat">New Chat</button>
			<form action="handlers/post_handler.php" method="post" class="this_chat" hidden>
			<textarea placeholder="Topic"  name="topic"></textarea><br>
			<textarea placeholder="Chat Text" name="chat_text"></textarea>
			<input type="submit" value="Create">
		</form>
		</div>
		</div>
</div>

<?php include('template/footer.php'); ?>
