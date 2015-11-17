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
	<link type="text/css" href = "stylesheets/course.css" />
	<style type="text/css">

		td,tr {
			padding: 10px !important;
		}

		.button {
  			display: block;
  			width: 20%;
  			height: 50%;
  			background: white;
  			padding: 10px;
  			text-align: center;
  			border-radius: 5px;
  			color: #cc0000;
  			border-radius: 20px;
  			font-weight: bold;
  			border: 2px solid #cc0000;
		}

	.button:hover {
		text-decoration: none;
		color: white;
		background-color: #cc0000;	
	}
	</style>
</head>
<?php require_once("../includes/layouts/header.php"); ?>
<p class="message">
<?php 
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		$_SESSION['message']=null;
	}
?>
<h1></h1>
<form action="new_course.php" method="post"  enctype="multipart/form-data">
<table align = center>
			<tr>
				<td width = "30%">Course Code : </td>
				<td width = "70%"><input type="text" name="courseCode" value="" /></td>
			</tr>
			<tr>
				<td>Course Name : </td>
				<td><input type="text" name="courseName" value="" /></td>
			</tr>
			<tr>
				<td>Branch : </td>
				<td>
					<select name="branch">
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
				</td>
			</tr>
			<tr>
				<td>Semester : </td>
				<td>
					<select name="sem">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
					</td>
			</tr>
			
			<tr>
				<td>Description : </td>
			</tr>
			<tr>
				<td colspan = 2><textarea name="description" rows="8" cols="60"></textarea></td>
			</tr>
			<tr>
				<td colspan = 2 style = "font-size: 12px">*Use html inside the textbox for your customization</td>
			</tr>
			<tr>
				<td>Upload Notes :</td>
				<td><input type="file" name="fileToUpload" id="fileToUpload"/></td>
			</tr>
			<tr>
				<td colspan = 2 align = center><input type="submit" name="submit" value="Submit" class = "button"/></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
