<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
require_once("../includes/layouts/header.php"); 
if(!isset($_GET['courseId'])) {
	echo "please select a course";
} 
else {
	$course = getCourseByCode($_GET['courseId']);
	echo "Course Name : ".$course['courseName']."<br />";
	echo "Course Code : ".$course['courseCode']."<br />";
	echo "Branch : ".$course['branch']."<br />";
	echo "Sem : ".$course['sem']."<br />";
	echo "Author : ".$course['author']."<br />";
	echo "Date Created : ".$course['dateCreated']."<br />";
	echo "Description : ".$course['description']."<br />";
	echo "Files(Refrences) : ";//$course['file'];
}
?>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
