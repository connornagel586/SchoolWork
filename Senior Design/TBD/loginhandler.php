<?php
/* login handler to select student from the databse */
session_start();
require_once('dao.php');
$conn = new dao();
$student = array(

"email"=>htmlspecialchars($_POST["email"]),
"student_id"=>htmlspecialchars($_POST["student_id"])
	);

$result = $conn->demoReturn($student);

$_SESSION['studentID'] = $result['student_id'];
header("Location: student.php");
exit;