<?php

class DAO {


	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "grad_tracker";

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

	public function insert_classes($classArray){

		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `classes` (term_year, class_name, class_number, professor, course_credits, recordID, grade)
		VALUES (:term, :class, :classNum, :professor, :credits, :recordID, :classGrade)");
		echo print_r($classArray['class']);
		$query->bindParam(':term', $classArray['term/year']);
		$query->bindParam(':class',	$classArray["class"]);
		$query->bindParam(':classNum', $classArray["classNum"]);
		$query->bindParam(':professor', $classArray["professor"]);
		$query->bindParam(':credits', $classArray["credits"]);
		$query->bindParam(':recordID', $classArray["recordID"]);
		$query->bindParam(':classGrade', $classArray["classGrade"]);
		$query->execute();
	}

	public function insertSemester($semesterData){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `semester` (term_year, student_id, advisor, advisorResponse, progressReport, semester_goals, gpa)
		VALUES (:term, :studentID, :advisor, '', :progressReport, :semesterGoals, 1.00)");
		$query->bindParam(':term', $semesterData['term/year']);
		$query->bindParam(':studentID', $semesterData['studentID']);
		$query->bindParam(':advisor', $semesterData['advisor']);
		$query->bindParam(':progressReport', $semesterData['progressReport']);
		$query->bindParam(':semesterGoals', $semesterData['semester_goals']);
		$query->execute();
		return	$this->getRecordID($semesterData["studentID"], $semesterData["term/year"]);
	}


	public function send_email_to_advisor(){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT DISTINCT `advisor_email` FROM `advisor`");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		return $query->fetchAll();
	}

	public function getRecordID($studentID, $term_year){
		$conn = $this->getConnection();
		$getRecord = $conn->prepare("SELECT recordID From `semester` WHERE `student_id`= :studentID AND `term_year`= :term_year");
		$getRecord->bindParam(':studentID', $studentID);
		$getRecord->bindParam(':term_year', $term_year);
		$getRecord->execute();

		return	$getRecord->fetchAll();
	}
	public function getSemesters($studentID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `semester` WHERE `student_id`= :student ORDER BY `date` DESC");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':student', $studentID);
		$query->execute();
		return $query->fetchAll();
	}
	public function getSemesterClasses($semester){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `classes` WHERE `recordID`= :recordID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':recordID', $semester['recordID']);
		$query->execute();
		return $query->fetchAll();
	}
	public function getAdvisorName($advisorID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `advisor` WHERE `advisor_id`= :advisorID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':advisorID', $advisorID);
		$query->execute();
		return $query->fetch();
	}

	public function get_advisors(){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `advisor`");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		return $query->fetchAll();
	}

	public function getUserInfo($studentID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `student` WHERE `student_id`= :studentID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':studentID', $studentID);
		$query->execute();
		return $query->fetchAll();
	}
    public function getAdvisorInfo($advisorID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `advisor` WHERE `advisor_id`= :advisorID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':advisorID', $advisorID);
		$query->execute();
		return $query->fetchAll();
	}
    public function getMyStudents($advisorID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `semester` WHERE `advisor`= :advisorID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':advisorID', $advisorID);
		$query->execute();
		return $query->fetchAll();
	}


	public function calcGPA($recordID){
		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT `grade` From `classes` WHERE `recordID` = :recordID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':recordID', $recordID);
		$query->execute();
		$grades = $query->fetchAll();
		$gpa = 0.0;
		$i = 0;
		foreach($grades as $grade){
			$letter = substr($grade['grade'], 0, 1);
			$modifier = substr($grade['grade'], 1, 1);

			if($letter == 'A'){
				$gpa += 4.0;
				if($modifier == '-'){
				$gpa -= 0.25;
			}
			}
			if($letter == 'B'){
				$gpa += 3.0;
				if($modifier == '+'){
				$gpa += 0.25;
			}
				elseif($modifier == '-'){
				$gpa -= 0.25;
			}
			}
			if($letter == 'C'){
				$gpa += 2.0;
				if($modifier == '+'){
				$gpa += 0.25;
			}
				elseif($modifier == '-'){
				$gpa -= 0.25;
			}
			}
			if($letter == 'D'){
				$gpa += 1.0;
				if($modifier == '+'){
				$gpa += 0.25;
			}
				elseif($modifier == '-'){
					$gpa -= 0.25;
				}
			}
			if($letter == 'F'){
				$gpa += 0.0;
				if($modifier == '+'){
					$gpa += 0.25;
				}
			}
			$i++;
		}
		$gpa = $gpa / $i;
		$query = $conn->prepare("UPDATE `semester` SET `gpa` = :gpa WHERE `recordID` = :recordID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':recordID', $recordID);
		$query->bindParam(':gpa', $gpa);
		$query->execute();
	}

	public function calcGradGPA($studentID){

		$conn = $this->getConnection();
		$query = $conn->prepare("SELECT `gpa` From `semester` WHERE `student_id` = :studentID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':studentID', $studentID);
		$query->execute();
		$gpas = $query->fetchAll();

		$CGPA = 0.0;
		$i = 0;
		foreach($gpas as $gpa){
			$CGPA += $gpa['gpa'];
			$i++;
		}
		$CGPA = $CGPA / $i;

		$query = $conn->prepare("UPDATE `student` SET `grad_gpa` = :CGPA WHERE `student_id` = :studentID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':studentID', $studentID);
		$query->bindParam(':CGPA', $CGPA);
		$query->execute();
	}

public function demo($values){
		$conn = $this->getConnection();
		$query = $conn->prepare("INSERT INTO `student` (student_id, first_name, middle_initial, last_name, student_email, grad_gpa, advisor_id)
		VALUES (:student_id, :first_name, :middle_initial, :last_name, :student_email, :grad_gpa, 1)");
		$query->bindParam(':student_id', $values['student_id']);
		$query->bindParam(':first_name', $values['first_name']);
		$query->bindParam(':middle_initial', $values['middle_initial']);
		$query->bindParam(':last_name', $values['last_name']);
		$query->bindParam(':student_email', $values['student_email']);
		$query->bindParam(':grad_gpa', $values['grad_gpa']);
		$query->execute();

	}
public function demoReturn($values){
	    $conn = $this->getConnection();
		$query = $conn->prepare("SELECT * From `student` WHERE `student_email` = :email AND `student_id` = :student_id");
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->bindParam(':email', $values['email']);
		$query->bindParam(':student_id', $values['student_id']);

		$query->execute();
		return $query->fetch();


      }
}
