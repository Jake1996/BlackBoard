<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	$name = mysql_prep($_POST['name']);
	$username = mysql_prep($_POST['username']);
	$password = mysql_prep($_POST['password']);
	$email = mysql_prep($_POST['email']);
	$hashedPassword = password_encrypt($password);
	$query  = "INSERT INTO admins (";
	$query .= "  name, username, hashedPassword, email";
	$query .= ") VALUES (";
	$query .= "  '{$name}', '{$username}', '{$hashedPassword}', '{$email}'";
	$query .= ")";
	$result = mysqli_query($connection, $query);
	if ($result) {
		// Success
		redirect_to("login.php");
	} else {
		// Failure
		redirect_to("signup.php");
	}
}

?>
<?php require_once("../includes/layouts/header.php"); ?>
<head></head>
<body>
	<form action="signup.php" method="post">
		<p>Name : <input type="text" name="name" value="" /></p>
		<p>Username : <input type="text" name="username" value="" /></p>
		<p>Password : <input type="text" name="password" value="" /></p>
		<p>Confirm Password : <input type="text" name="confirmPassword" value="" /></p>
		<p>E-Mail : <input type="text" name="email" value="" /></p>
		<p> <input type="submit" name="submit" value="submit" /></p>
	</form>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>