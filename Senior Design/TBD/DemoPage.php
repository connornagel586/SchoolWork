<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Records for demo</title>
</head>
<body>
<form action="DemoHandler.php" method="post">

	<p>
    	<label for="firstName">First Name:</label>
        <input type="text" name="first_name" id="firstName">
    </p>
    <p>
    	<label for="lastName">Last Name:</label>
        <input type="text" name="last_name" id="lastName">
    </p>
    <p>
        <label for="studentID">Student ID:</label>
        <input type="text" name="student_id" id="lastName">
    </p>
    <p>    
    	<label for="emailAddress">Email Address:</label>
        <input type="text" name="student_email" id="emailAddress">
    </p>
    <input type="submit" value="Add Records">

</form>
</body>
</html>