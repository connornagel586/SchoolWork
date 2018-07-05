<?php
require_once 'dao.php';
session_start();
$_SESSION['advisorID'] = "11111";
?>
<!DOCTYPE html>

<html>
<head>   
	<title>Advisor Page</title>
	<link rel="stylesheet" type="text/css" href="AdvisorHomePage.css">
	<link rel="icon" href="boiseStateLogo.png" type="image/x-icon" />
<!--
	<script type="text/javascript" src="jquery-3.3.1.js"></script>
	<script type="text/javascript" src="student.js"></script>
-->
</head>
<body>
	<div id="container">
		<header>
			<div id="headerImage">
				<img src="https://my.Boisestate.edu/assets/nav-logo.png">
			<div id="nav"><ul>
                <div class="navbar">
                    <a href="https://registrar.boisestate.edu/" target="_blank">myBoisestate</a>
                    <a href="https://registrar.boisestate.edu/undergraduate/course-catalog/" target="_blank">Catalog</a>
                    <a href="http://coen.boisestate.edu/cs/" target="_blank">Home</a>    
                    <div class="dropdown">
                        <button class="dropbtn">Settings 
                        <i class="fa fa-caret-down"></i>
                        </button>
                    <div class="dropdown-content">
                         <a href="#" onClick="MyWindow=window.open('http://www.google.com',width=600,height=300);">Add Advisor</a>
                        <a href="#" onClick="MyWindow=window.open('http://www.google.com',width=600,height=300);">Remove Student</a>
                        <a href="#" onClick="MyWindow=window.open('http://www.google.com',width=600,height=300);">Add Student</a>
                    </div>
                    </div> 
                </div>
			</ul>
		  </div>
	   </header>     
	<div id="banner">
		<h4>Advisor Page</h4>
		<p class="advisorInfo">
			<?php
			$dao = new dao();
			$userInfo = $dao->getAdvisorInfo($_SESSION['advisorID']);
			$userData = array_shift($userInfo);
			echo
			'Advisor: ' . $userData['first_name'] . ' ' .
			$userData['middle_initial'] .' '. $userData['last_name'];  ?>
            
                <form>  
                <select name="users" onchange="myFunction(this.value);">
                    <option value="">Select a person:</option>
                    <option value="google">11111</option>
                    <option value="yahoo">Ramzi Korkor</option>
                    <option value="msn">Maria Stone</option>
                </select>
            </form>
<script>
function myFunction(val) {  
     $.get("test.php");
    return false;
//    alert("The input value has changed. The new value is: " + val);
}
</script>
        
        
		</p>
	</div>   
    <div id="main">
		<div class="studentList">
			<h3>My Students</h3>
			<div class="myStudents">     
                <?php
                $dao = new dao();
                $myStudents = $dao->getMyStudents($_SESSION['advisorID']);     
                print "<table>
					<tr>
					<th>Student ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					</tr>";
                
                 foreach ($myStudents as $value) {
                    print "<tr>
                    <td>" . $value['student_id'] .  "</th>
                    <td>" . $value['first_name'] . " " .  $value['middle_initial'] . " ".  $value['last_name'] ."</th>
                    <td>" . "<a href=\"mailto:" . $value['student_email'] . "\">" . $value['student_email'] . "</a>" . "</th>
                    </tr>";
				}        
                print "</table>";    
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