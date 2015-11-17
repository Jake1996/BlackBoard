<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	$branchName = mysql_prep($_POST['branchName']);

	$query  = "INSERT INTO branch ( branchName ) VALUES ( '{$branchName}' )";
	$result = mysqli_query($connection, $query);
	if ($result) {
		// Success
		mysqli_free_result($result);
		redirect_to("login.php");
	} else {
		// Failure
		redirect_to("signup.php");
	}
}

?>
<html>	
	<link rel="stylesheet" type="text/css" href="stylesheets/branch_edit.css">
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap/bootstrap.min.css">
	<head>
		<title>course management</title>
	</head>
	<?php require_once("../includes/layouts/header.php"); ?>
	<body>
		<form action="branch_edit.php" method="post" class = "formstyle">
			<table align = center>
				<tr>
					<td>Branch Name: </td> 
					<td><input type="text" name="branchName" value="" /></td>
				</tr>
				<tr>
					<td colspan = 2><input type="submit" name="submit" value="submit" class = "button"/></td>
				</tr>
			</table>
		</form>
			
		
	</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
