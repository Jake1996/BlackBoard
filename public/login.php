<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>

<html>
<head></head>
<?php require_once("../includes/layouts/header.php"); ?>
<?php	
	if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$found_admin = attempt_login($username, $password);
	if ($found_admin) {
      		// Success
		
		// Mark user as logged in
		$_SESSION["admin_id"] = $found_admin["id"];
		$_SESSION["username"] = $found_admin["username"];
	}
	else {
		echo "not logged in";}
	}
	if(!isset($_SESSION['admin_id'])) {
?>

	<form  action = "login.php" method = "post">
		<p>Username : <input type="text" name="username" value="" /></p>
     		<p>Password : <input type="password" name="password" value="" /></p>
      		<input type="submit" name="submit" value="Submit" />
	</form>
<?php } else echo "Logged in"; ?>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>