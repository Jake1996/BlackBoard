<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	$id = $_SESSION['admin_id'];
	$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
  	$result = mysqli_query($connection, $query);

  	if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    	$_SESSION["message"] = "Admin deleted.";
    	$_SESSION['username'] = null;
    	$_SESSION['admin_id'] = null;
    	redirect_to("login.php");
  	} else {
    // Failure
    	$_SESSION["message"] = "Admin deletion failed.";
    	redirect_to("profile_edit.php");
  }
?>