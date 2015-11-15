<html>
<head>
	<title>ECHO TITLE</title>
	<link rel="stylesheet" type="text/css" href="stylesheets/course.css">
</head>

<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
require_once("../includes/layouts/header.php"); 
if(!isset($_GET['courseId'])) {
	echo "please select a course";
} 
else {
	$course = getCourseByCode($_GET['courseId']);
	?>
	<h1>Course Details</h1>
		<table>
			<tr>
				<td>Course Name : </td>
				<td><?php echo $course['courseName']; ?></td>
			</tr>
			<tr>
				<td>Course Code : </td>
				<td><?php echo $course['courseCode']; ?></td>
			</tr>
			<tr>
				<td>Branch : </td>
				<td><?php echo $course['branch']; ?></td>
			</tr>
			<tr>
				<td>Semester : </td>
				<td><?php echo $course['sem']; ?></td>
			</tr>
			<tr>
				<td>Author : </td>
				<td><?php echo $course['author']; ?></td>
			</tr>
			<tr>
				<td>Date Created : </td>
				<td><?php echo $course['dateCreated']; ?></td>
			</tr>
			<tr>
				<td>Description : </td>
				<td><?php echo $course['description']; ?></td>
			</tr>
			<tr>
				<td>Download : </td>
				<td><?php echo $course['file']; ?></td>
			</tr>
		</table>
		<br />
		<a href="edit_course.php">Edit Course</a>
		<a href="delete_course.php">Delete Course</a>
		<?php } ?>
<?php require_once("../includes/layouts/footer.php"); ?>
