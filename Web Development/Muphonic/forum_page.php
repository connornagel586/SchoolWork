<?php

session_start();
require_once('handlers/dao.php');
$_SESSION['current_page'] = "forum_page.php";
if(!isset($_SESSION['user_id'])){
	session_destroy();
	header('Location: index.php');
	exit;
}
$dao = new dao();
include('template/header.php');
$topic = $dao->get_topic($_GET['topic_id']);
$createdBy = $dao->find_user($topic['created_by']);
 ?>

 	<div class="main">
 <div class="topic_page">
   <div id='this_topic'><h4><?php echo $topic['topic_title']?></h4>
     <?php
		 print "<div class=\"topic_desc\">" . $topic['topic_text'] . "</div>";
     print "<div class=\"topic_info\">" . "Created by " .
      $createdBy['username']. " # comments: " . $topic['num_comments'] . " Time created: " . $topic['time_created']
     . "</div";

     ?>
   </div>
   <div id='comment_panel'><h5>Comments</h5>
		 	<?php
				$comments = $dao->get_topic_comments($_GET['topic_id'], 10);

				foreach($comments as $comment){
					 $user = $dao->find_user($comment['posted_by']);
						print "<div class=\"comment\">" .
			       $comment["comment_text"] . "<span> Posted by ". $user['username'] . " at " . $comment['time_posted']
			      . "</span></div>";
				}
			?>

	 <div class="new_comment">
	 <button type="button" id="add_comment">New Comment</button>
	 <form action="handlers/post_handler.php" method="post" class="this_comment" hidden>
	 <textarea placeholder="comment"  name="comment_text"></textarea><br>
	 <input type="text" name="user_id" value="<?php echo $_SESSION['user_id'];?>" hidden>
	 <input type="text" name="topic_id" value=<?php echo $_GET['topic_id'];?> hidden>
	 <input type="submit" value="Create">
 </form>
 </div>
 </div>
</div>
</div>

<?php include('template/footer.php'); ?>
