<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	$courseCode = mysql_prep($_POST['courseCode']);
	$courseName = mysql_prep($_POST['courseName']);
	$branch = mysql_prep($_POST['branch']);
	$sem = mysql_prep($_POST['sem']);
	$author = mysql_prep($_POST['author']);
	$description = mysql_prep($_POST['description']);
	$file = mysql_prep($_POST['file']);
	$datetime = date_create()->format('Y-m-d H:i:s');
	//query to be done to insert into course table
	$query  = "INSERT INTO course (";
	$query .= " courseCode, courseName, branch, sem, author,";
	$query .=" description, file, dateCreated )";
	$query .= " VALUES (";
	$query .= " '{$courseCode}', '{$courseName}', '{$branch}', {$sem}, '{$author}',";
	$query .= " '{$description}', '{$file}', '{$datetime}'";
	$query .= " )";
	$result = mysqli_query($connection, $query);
	if ($result) {
		mysqli_free_result($result);
		// Success
		$branchRef = getBranchByName($branch);
		$column = "courseSem{$sem}";
		$courseList = $branchRef[$column];
		$courseList .= "{$courseCode};";
		$safe_course = mysql_prep($courseList);
		$query = "UPDATE branch SET ";
		$query .= "courseSem{$sem} = '{$safe_course}' ";
		$query .= "WHERE branchName = '{$branch}' LIMIT 1";
		$result1 = mysqli_query($connection, $query);
		$variable = print_r($branchRef);
		if($result1)
		{
			mysqli_free_result($result1);
			redirect_to("login.php?{$variable}");
		} else {
		// Failure
			redirect_to("signup.php");
		}
	//code to insert the courseCode to the branch table //still error in code
	} else {
		// Failure
		redirect_to("signup.php");
	}
}

?>

<html>
<head>
	<title>course management</title>
	<link type="text/css" href = "stylesheets/reset.css" /> 
</head>
<?php require_once("../includes/layouts/header.php"); ?>
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
		<p> <input type="submit" name="submit" value="submit" /></p>
	</form>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
