<?php
session_start();
require_once('dao.php');

$conn = new dao();
echo print_r($_SESSION);
$semesterArray = array(
	"term/year"=>htmlspecialchars($_POST["term/year"]),
	"studentID"=>$_SESSION['studentID'],
	"advisor"=>htmlspecialchars($_POST["advisor"]),
	"progressReport"=>htmlspecialchars($_POST["progressReport"]),
	"semester_goals"=>htmlspecialchars($_POST["semester_goals"])
);
$getrecord = $conn->insertSemester($semesterArray);
$record = array_shift($getrecord);
$i = 1;
while(isset($_POST["class$i"])){
	$classArray = array(
		"recordID" =>$record['recordID'],
		"class"=>htmlspecialchars($_POST["class$i"]),
		"classNum"=>htmlspecialchars($_POST["classNum$i"]),
		"professor"=>htmlspecialchars($_POST["professor$i"]),
		"term/year"=>htmlspecialchars($_POST["term/year"]),
		"classGrade"=>htmlspecialchars($_POST["grade$i"]),
		"credits"=>(int)htmlspecialchars($_POST["credits$i"])
	);


	$conn->insert_classes($classArray);
	$i++;
}
$conn->calcGPA($recordID);
$conn->calcGradGPA($studentID);
header("Location: student.php");
exit;
