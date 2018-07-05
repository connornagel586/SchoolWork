<?php
//header('Location: home_page.php');
session_start();
require_once('handlers/dao.php');
$_SESSION['current_page'] = "chat_room.php";
if(!isset($_SESSION['user_id'])){
	session_destroy();
	$_SESSION = array();
	header('Location: index.php');
	exit;
}
$_SESSION['last_received_chat'] = 0;
$dao = new dao();
include('template/header.php');
if(!isset($_SESSION['chat_id']))
$_SESSION['chat_id'] = $_GET['chat_id'];
$chat_info = $dao->get_room($_SESSION['chat_id']);
$room_id = $chat_info['room_id'];
$createdBy = $dao->find_user($chat_info['created_by']);

?>
<div class="main">
<div class="chat_page">
 <div id='this_chat'><h4><?php echo $chat_info['room_title']?></h4>
   <?php
   print "<div class=\"chat_desc\">" . $chat_info['room_desc'] . "</div>";
   print "<div class=\"chat_info\">" . "Created by " .
    $createdBy['username'] . " Time created: " . $chat_info['time_created']
   . "</div>";

   ?>
 </div>

    <div id="chat_panel">
        <div id="welcome bar">
            <p class="welcome">Welcome, <?php echo $_SESSION['username']?><b></b></p>

            <div style="clear:both"></div>
        </div>

        <div id="chatbox"></div>

        <form id ="msg" name="message" method="post" action="">
            <textarea name="usermsg" type="text" id="usermsg"></textarea>
            <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
            <input name="room_id" type="number" hidden value = "<?php echo $room_id ?>" />
        </form>
    </div>

</div>
</div>



<?php include('template/footer.php'); ?>
