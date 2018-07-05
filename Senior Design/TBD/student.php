<?php
require_once 'dao.php';
session_start();

if(!isset($_SESSION['studentID']))
	$_SESSION['studentID'] = '113138282'
?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Page</title>
	<link rel="stylesheet" type="text/css" href="student.css">
	<link rel="icon" href="boiseStateLogo.png" type="image/x-icon" />
	<script type="text/javascript" src="jquery-3.3.1.js"></script>
	<script type="text/javascript" src="student.js"></script>
	<script type="text/javascript" src="js/validation/dist/jquery.validate.js"></script>
</head>

<body>
	<div id="container">
		<header>
			<div id="headerImage">
				<img src="https://my.Boisestate.edu/assets/nav-logo.png">
			</div>
			<div id="nav"><ul>
				<li><a href="http://coen.boisestate.edu/cs/" target="_blank">Home</a></li>
				<li><a href="https://registrar.boisestate.edu/undergraduate/course-catalog/" target="_blank">Catalog</a></li>
				<li><a href="https://registrar.boisestate.edu/" target="_blank">myBoisestate</a></li>
			</ul>
		</div>
	</header>
	<div id="banner">
		<h4>Student Page</h4>
		<p class="studentInfo">
			<?php

			$dao = new dao();
			$userInfo = $dao->getUserInfo($_SESSION['studentID']);
			$userData = array_shift($userInfo);
			echo
			'Student: ' . $userData['first_name'] . ' ' .
			$userData['middle_initial'] .' '. $userData['last_name'] .
			' GPA: ' . $userData['grad_gpa'];  ?>

		</p>
	</div>
	<div id="main">
		<div class="semesterList">
			<h3>Graduate Degree Tracker</h3>
			<div class="semesterForm">	<!--Gui for the progress report and semester form -->
				<h1>Add Semester</h1>
				<form action="/handler.php" method="post" id="semesterEntries">
					<fieldset>
						<legend> Please enter your semester information below.
					<div class="form">
						<input type="text" placeholder="Term/Year" name="term/year" required>
						<select placeholder="Advisor" name="advisor" required>
							<option value=NULL>Advisor</option>
							<?php
							$dao = new dao();
							$advisors = $dao->get_advisors();
							foreach ($advisors as $advisor) {
								$advisorFN = $advisor['first_name'];
								$advisorLN = $advisor['last_name'];
								$advisorID = $advisor['advisor_id'];
								echo "<option value=\"$advisorID\">$advisorFN $advisorLN</option>";
							}

							?>
						</select><br>
						<div class="class">

							<input type="text" placeholder="Class Name" class="className" name="class1" required>
							<input type="text" placeholder="Class Number" class="classNum"name="classNum1"><br>
							<input type="text" placeholder="Professor" class="professor"name="professor1" required>
							<input type="text" placeholder="Credits" class="credits" name="credits1" maxlength="1" required><br>
							<input type="text" placeholder="Grade" class="grade" name="grade1" maxlength="2" required><br>
						</div>
					</div>
					<div class="report">
						<textarea placeholder="Progress Report" class="progressReport" name="progressReport"></textarea>
						<textarea placeholder="Semester Goals" class="semesterGoals" name="semester_goals"></textarea>
					</div>
					<input type="Button" id="add_class" name="Add_Class" value="Add Class">
					<input type="Button" id="remove_class" name="Remove_Class" value="Remove Class">
					<input type="submit" value="Submit">
				</fieldset>
					<?php
					if(isset($_POST['submission'])){
						$dao = new dao();
						$advisor = $dao->send_email_to_advisor();
						$subject = 'Test Email';
						$to = 'monicarobison@u.boisestate.edu';
						$message = 'Let\'s see if this works';
						$headers = 'MIME-Version: 1.0' . "\r\n"; $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; $headers .= 'From: Homeless' . "\r\n";
						mail($to, $subject, $message, $headers);
					}
					?>
				</form>
				<script>
					$("#semsterEntries").validate();
				</script>
			</div>
			<br>
			<div class="studentClassList">
				<?php
				$dao = new dao();
				$semesters = $dao->getSemesters($_SESSION['studentID']);

				foreach ($semesters as $semester) {
					$classes = $dao->getSemesterClasses($semester);
					$advisorName = $dao->getAdvisorName($semester['advisor']);

					print "<div class='semesterWidget'><h1 class='semesterInfo'>Semester: " . ucfirst($semester['term_year']) . " Advisor: ".
					$advisorName['first_name'] . " ". $advisorName['last_name'] . " GPA: " . $semester['gpa'] . "</h1>";
					print "<table>
					<tr>
					<th>Class</th>
					<th>Class #</th>
					<th>Instructor</th>
					<th>Grade</th>
					<th>Credit</th>
					</tr>";

					foreach($classes as $class){
						print	"<tr>
						<td>" . $class['class_name'] . "</td>
						<td>" . $class['class_number'] . "</td>
						<td>" . $class['professor'] . "</td>
						<td>" . $class['grade'] . "</td>
						<td>" . $class['course_credits'] . "</td>
						</tr>";

					}
					print "</table>" . "<p class=\"displayText\">" . $semester['progressReport'] . "</p><p class=\"displayText\">" .
					$semester['semester_goals'] . "</p></div>";
				}
				$dao->calcGradGPA($_SESSION['studentID']);
				?>
			</div>
		</div>
	</div>
	<footer>
		<p>Boise State University 2018 Team TBD</p>
	</footer>
</div>
</body>

</html>
