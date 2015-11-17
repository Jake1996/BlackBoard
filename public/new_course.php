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
	$author = $_SESSION["username"];
	$description = mysql_prep($_POST['description']);
	$file = mysql_prep(upload($_FILES["fileToUpload"]));
	//$file = mysql_prep($_POST['file']);
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
		if($result1)
		{
			mysqli_free_result($result1);
			redirect_to("browse.php");
		} else {
		// Failure
			$_SESSION['message']='Error writing course';
			redirect_to("new_course.php");
		}
	//code to insert the courseCode to the branch table //still error in code
	} else {
		// Failure
		$_SESSION['message']='Error writing course';
		redirect_to("new_course.php");
	}
}

?>

<html>
<head>
	<title>course management</title>
	<link type="text/css" href = "stylesheets/reset.css" /> 
</head>
<?php require_once("../includes/layouts/header.php"); ?>
<p class="message">
<?php 
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		$_SESSION['message']=null;
	}
?>
</p>
	<form action="new_course.php" method="post"  enctype="multipart/form-data">
		<p>CourseCode : <input type="text" name="courseCode" value="" /></p>
		<p>CourseName : <input type="text" name="courseName" value="" /></p>
		<p>Branch : <select name="branch">
		<?php
			$output = "";
			$branch_set = getAllBranches();
			while($branch = mysqli_fetch_assoc($branch_set)) {
				$output .= "<option value=\"{$branch['branchName']}\">{$branch['branchName']}</option>";
			}
			mysqli_free_result($branch_set);
			echo $output;
		?>
 		</select>
		<p>Semester :<select name="sem">
			<option name="1">1</option>
			<option name="2">2</option>
			<option name="3">3</option>
			<option name="4">4</option>
			<option name="5">5</option>
			<option name="6">6</option>
			<option name="7">7</option>
			<option name="8">8</option>
			</select></p>
		<p>Description :<br /> <textarea name="description"></textarea><br />
		*Enter description of the course can use html elements like table etc</p>
		<p>File : <input type="file" name="fileToUpload" id="fileToUpload" /></p>
		<p> <input type="submit" name="submit" value="Submit" /></p>
	</form>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
