
    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);
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