<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	if(isset($_POST['submit'])) {

	    $username = $_SESSION['username'];
	    $password = $_POST['password'];
	    $found_admin = attempt_login($username,$password );
	    $hashedPassword = $found_admin['hashedPassword'];
	    if($found_admin) {
	    	if($_POST['confirmPassword']!="") {
	    		$password=$_POST['confirmPassword'];
	    	}
	    	$hashedPassword = password_encrypt($password);
	    	mysqli_free_result($found_admin);
	    }
	    else {
	    	$_SESSION['message']="Wrong Password";
	    	redirect_to("profile_edit.php");
	    }
	    $id = $_SESSION['admin_id'];
	    $name = mysql_prep($_POST['name']);
	    $email = mysql_prep($_POST['email']);
	    $query  = "UPDATE admins SET ";
	    $query .= "name = '{$name}', ";
	    $query .= "email = '{$email}', ";
	    $query .= "hashedPassword = '{$hashedPassword}', ";
	    $query .= "username = '{$username}' ";
	    $query .= "WHERE id = {$id} ";
	    $query .= "LIMIT 1";
	    $result = mysqli_query($connection, $query);
	    if($result) {
	    	mysqli_free_result($result);
	    	$_SESSION['message']="Changes made Successfully";
	    	redirect_to("profile_edit.php");
	    }
	    else {
	    	$_SESSION['message']="Problems making changes";
	    	redirect_to("profile_edit.php");
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
<head>
	<title>Profile Edit</title>
	<style type="text/css">
		td,tr {
			padding: 10px !important;
		}

		.button {
  			display: block;
  			width: 150px;
  			height: 50%;
  			background: white;
  			padding: 10px;
  			text-align: center;
  			border-radius: 5px;
  			color: #cc0000;
  			border-radius: 20px;
  			font-weight: bold;
  			border: 2px solid #cc0000;
		}

	.button:hover {
		text-decoration: none;
		color: white;
		background-color: #cc0000;	
	}
	</style>
</head>
<?php require_once("../includes/layouts/header.php"); ?>
    <form action = "profile_edit.php" method="post">
	<table align="center">
		<tr>
			<td>Name : </td> <td> <input type="text" name="name" value="<?php echo $name; ?>" /></td>
		</tr>
		<tr>
			<td>Username : </td> <td><?php echo $username; ?></td>
		</tr>
		<tr>
			<td>Old Password : </td> <td><input type="password" name="password" value="" /></td>
		</tr>
		<tr>
			<td>New Password : </td> <td><input type="password" name="confirmPassword" value="" /></td>
		</tr>
		<tr>
			<td>E-Mail : </td> <td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class="button" id="submit"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><a href="delete_user.php" class = "button">Delete User</a></td>
		</tr>
	</table>
	</form>
	
<?php } ?>
<?php require_once("../includes/layouts/footer.php"); ?>