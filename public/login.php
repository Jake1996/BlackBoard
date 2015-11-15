<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>

<html>
<head><link rel="stylesheet" type="text/css" href="stylesheets/login.css"></head>
<!--<?php require_once("../includes/layouts/header.php"); ?>-->
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
		echo "Incorrect Username/Password";}
	}
	if(!isset($_SESSION['admin_id'])) {
?>
		<div id="login_form">
			<form  action = "login.php" method = "post">
				<table align = "center">	
					<p><tr>
						<td style = "padding : '10px'">Username : </td>
						<td><input id="username_textbox" type="text" name="username" value="" /></p></td>
					</tr>
					<tr>
     					<td>Password : </td>
     					<td><input id="password_textbox" type="password" name="password" value="" /></td>
      				</tr>
      				<tr>
      					<td colspan = "2"><input id="login_button" type="submit" name="submit" value="Login" class = "custom-button"/></td>
      				</tr>
      				<tr>
      					<td>Dont have an account?</td>
      					<td><a href="signup.php">Sign Up</a></td>
      				</tr>
				</table>
			</form>
		</div>

<?php } 
else 
{
	echo "Logged in";
	redirect_to("browse.php"); 
}
?>
</body>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>