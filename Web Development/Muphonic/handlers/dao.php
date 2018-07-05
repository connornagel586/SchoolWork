<?php

class DAO {

	private $servername = "tyduzbv3ggpf15sx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
	private $username = "lnvexydhh92ltgjy";
	private $password = "b7j4hazh3x178cdq";
	private $database = "cdrifsz9vwbwmo0y";

	// private $servername = "localhost";
	// private $username = "root";
	// private $password = "";
	// private $database = "Muphonic";


	private function getConnection(){

		try {
			$conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//echo "Connected successfully";
			return $conn;
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		throw new Exception("user not found");

	}

	public function insert_user($user_data){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `user_info` (username, password, email)
		VALUES (:username, :password, :email)");
		$query->bindParam(':username',	$user_data['username']);
		$query->bindParam(':password', $user_data['password']);
		$query->bindParam(':email', $user_data['email']);

		$query->execute();
	}
	public function get_user($user_login){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `user_info` where `username`=:username");
		$query->bindParam(':username', $user_login['username']);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();

		return $query->fetchAll();
	}
	public function find_user($user_id){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT `username` FROM `user_info` where `user_id`=:user_id");
		$query->bindParam(':user_id', $user_id);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		return $query->fetch();
	}
	public function delete_user($user_id){
		$conn = $this->getConnection();
		$query = $conn->prepare("DELETE FROM `user_info` where `user_id` = :user_id");
		$query->bindParam(':user_id', $user_id);

		$query->execute();
	}
	public function post_topic($topicInfo){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `topics` (`topic_id`,`topic_title`, `topic_text`, `created_by`, `num_comments`, `time_created`)
		VALUES (null,:topictitle, :topictext, :created_by, 0, CURRENT_TIMESTAMP);");
		echo print_r($topicInfo);

		$query->bindParam(':topictitle', $topicInfo['topic_title']);
		$query->bindParam(':topictext', $topicInfo['topic_text']);
		$query->bindParam(':created_by',$topicInfo['created_by']);
		$query->execute();
	}
	public function get_topics($limit){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `topics`  ORDER BY `time_created` DESC LIMIT $limit");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		//$query->bindParam(':limit', $limit);
		$query->execute();

		return $query->fetchAll();
	}
	public function get_topic($topic_id){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `topics`  where `topic_id` = :topic_id");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':topic_id', $topic_id);
		$query->execute();

		return $query->fetch();
	}
	public function get_topic_comments($topic_id, $limit){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `comments` where `topic_id` =:topic_id ORDER BY `time_posted` DESC LIMIT $limit");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':topic_id', $topic_id);
		$query->execute();
		return $query->fetchAll();
	}
	public function get_my_topics($user_id, $limit){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `topics` where `created_by` =:user_id ORDER BY `time_created` DESC LIMIT $limit");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':user_id', $user_id);
		$query->execute();

		return $query->fetchAll();
	}
	public function post_comment($postInfo){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `comments` (comment_id, topic_id, posted_by, comment_text, time_posted)
		VALUES (null, :topic_id, :posted_by, :comment_text, CURRENT_TIMESTAMP)");
		$query->bindParam(':topic_id', $postInfo['topic_id']);
		$query->bindParam(':posted_by', $postInfo['posted_by']);
		$query->bindParam(':comment_text', $postInfo['comment_text']);

		$query->execute();
	}

	public function modify_post($newPostValues){
		$conn = $this->getConnection();
		$query = $conn->prepare("UPDATE `comments` SET `comment_text`=:comment_text where `comment_id` = :comment_id");
		$query->bindParam(':comment_id', $newPostValues['comment_id']);
		$query->bindParam(':comment_text', $newPostValues['comment_text']);

		$query->execute();
	}

	public function modify_topic($newTopicValues){
		$conn = $this->getConnection();
		$query = $conn->prepare("UPDATE `topics` SET `topic_text`=:topic_text, `topic_title` = :topic_title where `topic_id` = :topic_id");
		$query->bindParam(':topic_id', $newPostValues['topic_id']);
		$query->bindParam(':topic_text', $newPostValues['topic_text']);

		$query->execute();
	}

	public function delete_topic($topicID){
		$conn = $this->getConnection();
		$query = $conn->prepare("DELETE FROM `topics` where `topic_id` = :topic_id");
		$query->bindParam(':topic_id', $topicID);

		$query->execute();
	}

	public function delete_post($postID){
		$conn = $this->getConnection();
		$query = $conn->prepare("DELETE FROM `comments` where `comment_id` = :comment_id");
		$query->bindParam(':comment_id', $postID);

		$query->execute();
	}

	public function get_rooms($limit){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `rooms`  ORDER BY `time_created` DESC LIMIT $limit");
		$query->setFetchMode(PDO::FETCH_ASSOC);

		$query->execute();

		return $query->fetchAll();
	}

	public function get_room($room_ID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * FROM `rooms`  where `room_id` = :room_id");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':room_id', $room_ID);
		$query->execute();

		return $query->fetch();
	}

	public function get_new_messages($id = 0 ,$room_ID){
		$conn = $this->getConnection();

		if($id > 0){

		$query = $conn->prepare("SELECT * FROM `chat` WHERE `chat_id` > :id AND `room_id` = :room_id ORDER BY `time_posted` ASC");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':room_id', $room_ID);
		$query->bindParam(':id', $id);
		$query->execute();

		return $query->fetchAll();
	}
	else{
		$query = $conn->prepare("SELECT * FROM (SELECT * FROM `chat` WHERE `room_id` = :room_id ORDER BY `time_posted` DESC LIMIT 20) AS Last50 ORDER BY `time_posted` ASC");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':room_id', $room_ID);
		$query->execute();
		return $query->fetchAll();
	}
	}
	public function create_room($room_info){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `rooms` (`room_id`, `room_title`,`room_desc`, `created_by`,`time_created`)
		VALUES (NULL, :roomtitle,:roomdesc, :created_by, CURRENT_TIMESTAMP);");
		$query->bindParam(':roomtitle', $room_info['room_title']);
		$query->bindParam(':roomdesc', $room_info['room_desc']);
		$query->bindParam(':created_by', $room_info['created_by']);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
	}
	public function post_chat($postInfo){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `chat` (chat_id, room_id, posted_by, time_posted, message)
		VALUES (null, :room_id, :posted_by, CURRENT_TIMESTAMP, :comment_text)");
		$query->bindParam(':room_id', $postInfo['room_id']);
		$query->bindParam(':posted_by', $postInfo['posted_by']);
		$query->bindParam(':comment_text', $postInfo['comment_text']);

		$query->execute();
	}




						}
