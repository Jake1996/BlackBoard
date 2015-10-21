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
<head><link rel="stylesheet" type="text/css" href="stylesheets/signup.css">
</head>
<body>
	<form action="signup.php" method="post">
	<table align="center">
		<p><tr><td>Name : </td> <td> <input type="text" name="name" value="" /></p></td></tr>
		<p><tr><td>Username : </td> <td><input type="text" name="username" value="" /></p></td></tr>
		<p><tr><td>Password : </td> <td><input type="text" name="password" value="" /></p></td></tr>
		<p><tr><td>Confirm Password : </td> <td><input type="text" name="confirmPassword" value="" /></p></td></tr>
		<p><tr><td>E-Mail : </td> <td><input type="text" name="email" value="" /></p></td></tr>
		<p><tr><td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class = "custom-button" id = "submit"/></p></td></tr>
	</table>
	</form>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>