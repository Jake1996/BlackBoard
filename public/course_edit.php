<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	$courseCode = mysql_prep($_POST['courseCode']);
	$courseName = mysql_prep($_POST['courseName']);
	$branch = mysql_prep($_POST['branch']);
	$sem = mysql_prep($_POST['sem']);
	$author = mysql_prep($_POST[author']);
	$description = mysql_prep($_POST['description']);
	$file = mysql_prep($_POST['file']);
	$dateCreated = mysql_prep($_POST['dateCreated']);

	$query  = "INSERT INTO course (";
	$query .= " courseCode, courseName, branch, sem, author,";
	$query .=" description, file, dateCreated )";
	$query .= " VALUES (";
	$query .= " '{$courseCode}', '{$CourseName}', '{$branch}', {$sem}, '{$author}',"
	$query .= " '{$description}', '{$file}', '{$dateCreated}'";
	$query .= " )";
	$result = mysqli_query($connection, $query);
	if ($result) {
		// Success
		redirect_to("login.php");
	} else {
		// Failure
		redirect_to("signup.php");
	}
}

?>
<html>
<head></head>
<body>
	<form action="course_edit.php" method="post">
		<p>CourseCode : <input type="text" name="courseCode" value="" /></p>
		<p>CourseName : <input type="text" name="courseName" value="" /></p>
		<p>Branch : <input type="text" name="branch" value="" /></p>
		<p>Sem :<select name="sem">
			<option name="1">1</option>
			<option name="2">2</option>
			<option name="3">3</option>
			<option name="4">4</option>
			<option name="5">5</option>
			<option name="6">6</option>
			<option name="7">7</option>
			<option name="8">8</option>
			</select></p>
		<p>Author : <input type="text" name="author" value="" /></p>
		<p>Description : <textarea name="description"></textarea></p>
		<p>File : <input type="file" name="email" value="" /></p>
		<p>Date : <input type="text" name="email" value="" /></p> <!--might have to change to get the current date -->
		<p> <input type="submit" name="submit" value="submit" /></p>
	</form>
</body>
</html>
