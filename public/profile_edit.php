<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_logged_in(); ?>
<?php 
	if(isset($_POST['submit'])) {

	    $username = $_SESSION['username'];
	    $password = $_POST['password'];
	    $found_admin = attempt_login($username,$password );
	    $hashedPassword = $found_admin['hashedPassword'];
	    if($found_admin) {
	    	$password=$_POST['confirmPassword'];
	    	$hashedPassword = password_encrypt($password);
	    	mysqli_free_result($found_admin);
	    }
	    else {
	    	$_SESSION['message']="Wrong Password";
	    	redirect_to("profile_edit");
	    }
	    $id = $_SESSION['admin_id'];
	    $name = mysql_prep($_POST['name']);
	    $email = mysql_prep($_POST['email']);
	    $query  = "UPDATE admis SET ";
	    $query .= "name = '{$name}', ";
	    $query .= "email = '{$email}, ";
	    $query .= "hashedPassword = '{$hashedPassword}', ";
	    $query .= "username = '{$username}' ";
	    $query .= "WHERE id = {$id} ";
	    $query .= "LIMIT 1";
	    $result = mysqli_query($connection, $query);
	    if($result) {
	    	mysqli_free_result($result);
	    	$_SESSION['message']="Changes made Successfully";
	    	redirect_to("profile_edit");
	    }
	    else {
	    	$_SESSION['message']="Problems making changes";
	    	redirect_to("profile_edit");
	    }
	}
	else {
		$username = $_SESSION['username'];
		$user = find_admin_by_username($username);
		$email = $user['email'];
		$name = $user['name'];

	
?>
<?php 
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		$_SESSION['message']=null;
	}
?>
<html>
<head><title>Profile Edit</title>
</head>
<?php require_once("../includes/layouts/header.php"); ?>
    <form action="profile_edit.php" method="post">
	<table align="center">
		<p><tr><td>Name : </td> <td> <input type="text" name="name" value="<?php echo $name; ?>" /></p></td></tr>
		<p><tr><td>Username : </td> <td><?php echo $username; ?></p></td></tr>
		<p><tr><td>Old Password : </td> <td><input type="password" name="password" value="" /></p></td></tr>
		<p><tr><td>New Password : </td> <td><input type="password" name="confirmPassword" value="" /></p></td></tr>
		<p><tr><td>E-Mail : </td> <td><input type="text" name="email" value="<?php echo $email; ?>" /></p></td></tr>
		<p><tr><td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class = "custom-button" id = "submit"/></p></td></tr>
	</table>
	</form>
	<a href="delete_user.php">-Delete User</a>
	<?php } ?>