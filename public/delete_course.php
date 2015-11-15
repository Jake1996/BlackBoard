<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
if(isset($_GET['courseId'])) {
	$id = $_GET['courseId'];
	$query = "DELETE FROM course WHERE courseCode = '{$id}' LIMIT 1";
  $result = mysqli_query($connection, $query);
  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    	$_SESSION["message"] = "course deleted.";
    	redirect_to("course.php");
  	} else {
    // Failure
    	$_SESSION["message"] = "course deletion failed.";
    	redirect_to("course.php");
  }
}
else {
  $_SESSION['message']="Failed to delete course - no course selected";
  redirect_to("course.php");
}
?>