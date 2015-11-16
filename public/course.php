<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php 

	if(!isset($_GET['courseId'])) {
		require_once("../includes/layouts/header.php");
		if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		$_SESSION['message']=null;
		echo "please select a course";
		}
	} 
	else {
		$course1 = getCourseByCode($_GET['courseId']);
?>
<html>
<head>
	<title><?php echo $course1['courseName']; ?></title>
	<link rel="stylesheet" type="text/css" href="stylesheets/course.css">
</head>
<?php require_once("../includes/layouts/header.php"); ?>
	<h1>Course Details</h1>
		<table>
			<tr>
				<td>Course Name : </td>
				<td><?php echo $course1['courseName']; ?></td>
			</tr>
			<tr>
				<td>Course Code : </td>
				<td><?php echo $course1['courseCode']; ?></td>
			</tr>
			<tr>
				<td>Branch : </td>
				<td><?php echo $course1['branch']; ?></td>
			</tr>
			<tr>
				<td>Semester : </td>
				<td><?php echo $course1['sem']; ?></td>
			</tr>
			<tr>
				<td>Author : </td>
				<td><?php echo $course1['author']; ?></td>
			</tr>
			<tr>
				<td>Date Created : </td>
				<td><?php echo $course1['dateCreated']; ?></td>
			</tr>
			<tr>
				<td>Description : </td>
				<td><?php echo $course1['description']; ?></td>
			</tr>
			<tr>
				<td>Download : </td>
				<td><a href="<?php echo $course1['file']; ?>">link</a></td>
			</tr>
		</table>
		<br />
<a href="course_edit.php?courseId=<?php echo $course1['courseCode']; ?>">Edit Course</a>
<a href="delete_course.php?courseId=<?php echo $course1['courseCode']; ?>">Delete Course</a>
<?php require_once("../includes/layouts/footer.php"); ?>
<?php } ?>
