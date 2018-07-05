<?php
session_start();
require_once('dao.php');
$dao = new dao();

if(isset($_POST['usermsg'])){


$newMessage = array(
  "comment_text" => htmlspecialchars($_POST['usermsg']),
  "room_id" => $_POST['room_id'],
  "posted_by" => $_SESSION['user_id']
);
$dao->post_chat($newMessage);
$new_messages= $dao->get_new_messages($_SESSION['last_received_chat'], $_SESSION['chat_id']);
foreach($new_messages as $message){
  $userList = $dao->find_user($message['posted_by']);
  $username = array_shift($userList);
  echo "<div>" . $message['message'] ."<span>" . $username . $message['time_posted'] . "</span></div>";

  $_SESSION['last_received_chat'] = $message['chat_id'];
}
}
else{
  $new_messages= $dao->get_new_messages($_SESSION['last_received_chat'], $_SESSION['chat_id']);
  foreach($new_messages as $message){
    $userList = $dao->find_user($message['posted_by']);
    $username = array_shift($userList);
    echo "<div class=\"chat_line\">" . $message['message'] ." <span style=\"color:silver; font-size:10px\">" ."Posted by ". $username ." ".  $message['time_posted'] . "</span></div>";

    $_SESSION['last_received_chat'] = $message['chat_id'];
  }
}
