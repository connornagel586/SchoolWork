<?php
session_start();
require_once('dao.php');
$dao = new dao();
if(isset($_POST['title'])){

$title = $_POST['title'];
$text = $_POST['topic_text'];

$newTopic = array(
  "created_by"=>(int)($_SESSION['user_id']),
  "topic_title"=>htmlspecialchars($title),
  "topic_text"=>htmlspecialchars($text)
);
$dao->post_topic($newTopic);
header("Location:../forum_main.php");
exit;

}
if(isset($_POST['topic'])){
  $newTopic = array(
    "created_by"=>(int)($_SESSION['user_id']),
    "room_title"=>htmlspecialchars($_POST['topic']),
    "room_desc"=>htmlspecialchars($_POST['chat_text'])
  );
  $dao->create_room($newTopic);
  header("Location:../chat_main.php");
  exit;
}

if(isset($_POST['comment_text'])){
$text = $_POST['comment_text'];

$newComment = array(
  "posted_by"=>(int)($_POST['user_id']),
  "topic_id"=>(int)($_POST['topic_id']),
  "comment_text"=>htmlspecialchars($text)
);
echo print_r($newComment);
$dao->post_comment($newComment);
header("Location:../forum_page.php?topic_id=" . $_POST['topic_id']);
exit;
}
