<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	if(isset($_POST['submit'])) {
		$courseCode = mysql_prep($_GET['courseId']);
		$courseName = mysql_prep($_POST['courseName']);
		$branch = mysql_prep($_POST['branch']);
		$sem = mysql_prep($_POST['sem']);
		$author = $_SESSION["username"];
		$description = mysql_prep($_POST['description']);
	    $query  = "UPDATE course SET ";
	    $query .= "courseName = '{$courseName}', ";
	    $query .= "branch = '{$branch}', ";
	    $query .= "sem = {$sem}, ";
	    $query .= "author = '{$author}', ";
	    $query .= "description = '{$description}' ";
	    $query .= "WHERE courseCode = '{$courseCode}' ";
	    $query .= "LIMIT 1";
	    $result = mysqli_query($connection, $query);
	    if($result) {
	    	mysqli_free_result($result);
	    	$_SESSION['message']="Changes made Successfully";
	    	redirect_to("course.php?courseId={$courseCode}");
	    }
	    else {
	    	$_SESSION['message']=$query;
	    	redirect_to("course_edit.php?courseId={$courseCode}");
	    }
	}
	else {
		if(isset($_GET['courseId'])) { 
				$course1 = getCourseByCode($_GET['courseId']);
			?>
			<html>
			<head><title>Course Edit</title></head>
			<?php require_once("../includes/layouts/header.php"); ?>
			<p class="message">
			<?php 
				if(isset($_SESSION['message'])) {
					echo $_SESSION['message'];
					$_SESSION['message']=null;
				}
			?>
			</p>
			<form action="course_edit.php?courseId=<?php echo $course1['courseCode']; ?>" method="post">
				<p>CourseCode : <?php echo $course1['courseCode']; ?></p>
				<p>CourseName : <input type="text" name="courseName" value="<?php echo $course1['courseName']; ?>" /></p>
				<p>Branch : <select name="branch">
				<?php
					$output = "";
					$branch_set = getAllBranches();
					while($branch = mysqli_fetch_assoc($branch_set)) {
						$output .= "<option value=\"{$branch['branchName']}\" ";
						if($branch['branchName']==$course1['branch']) {
							$output .= "selected ";
						}
						$output .= ">{$branch['branchName']}</option>";
					}
					mysqli_free_result($branch_set);
					echo $output;
				?>
	 			</select>
				<p>Sem :<select name="sem">
					<?php 
						$output ="";
						for($i=1;$i<=8;$i++) {
							$output .="<option value=\"{$i}\"";
							if($course1['sem'] == $i) {
								$output .= "selected ";
							}
							$output .= ">{$i}</option>";
						}
						echo $output;
					?>
					</select></p>
				<p>Description :<br /> <textarea name="description"><?php echo $course1['description']; ?></textarea><br />
				*Enter description of the course can use html elements like table etc</p>
				<p>File : <input type="file" name="email" value="<?php echo $course1['file']; ?>" /></p>
				<p> <input type="submit" name="submit" value="Submit" /></p>
			</form>
			<?php require_once("../includes/layouts/footer.php"); ?>
		<?php 
		}	
		else {
			$_SESSION['message']="select a course to edit";
	    	redirect_to("course.php");
		}
	}
?>
