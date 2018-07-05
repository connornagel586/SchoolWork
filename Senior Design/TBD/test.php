<?php
require_once 'dao.php';
session_start();
?>
<!DOCTYPE html>


<html>
    
    
<?php
    
    echo print "heklhaekhrq"
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
                    <td>" . $value['student_email'] . "</th>
                    </tr>";
				}        
                print "</table>";    
            ?> 
    
    
</html>