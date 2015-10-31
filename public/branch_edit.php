<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
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
	<head><title>course management</title></head>
	<body>
		<div class = "container-fluid">
			<div class = "row form">
				<div class = "col-md-12">
					<?php require_once("../includes/layouts/header.php"); ?>
					<form action="branch_edit.php" method="post" class = "formstyle">
						<p>Branch Name: <input type="text" name="branchName" value="" /></p>
						<p> <input type="submit" name="submit" value="submit" class = "button"/></p>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
