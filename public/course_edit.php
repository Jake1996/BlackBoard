<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	if(isses($_POST['submit'])) {
	
	}
	else {
		if(isset($_GET['courseId'])) { 
				$course1 = getCourseByCode($_GET['courseId']);
			?>
			<form action="course_edit.php" method="post">
				<p>CourseCode : <?php echo $course1['courseCode']; ?></p>
				<p>CourseName : <input type="text" name="courseName" value="<?php echo $course1['courseName']; ?>" /></p>
				<p>Branch : <select name="branch">
				<?php
					$output = "";
					$branch_set = getAllBranches();
					while($branch = mysqli_fetch_assoc($branch_set)) {
						$output .= "<option value=\"{$branch['branchName']}\">{$branch['branchName']}</option>";
					}
					mysqli_free_result($branch_set);
					echo $output;
				?>
	 			</select>
				<p>Sem :<select name="sem">
					<option name="1">1</option>
					<option name="2">2</option>
					<option name="3">3</option>
					<option name="4">4</option>
					<option name="5">5</option>
					<option name="6">6</option>
					<option name="7">7</option>
					<option name="8">8</option>
					</select></p>
				<p>Description :<br /> <textarea name="description"><?php echo $course1['description']; ?></textarea><br />
				*Enter description of the course can use html elements like table etc</p>
				<p>File : <input type="file" name="email" value="<?php echo $course1['file']; ?>" /></p>
				<p> <input type="submit" name="submit" value="Submit" /></p>
			</form>
		<?php 
		}	
		else {
			$_SESSION['message']="select a course to edit";
	    	redirect_to("course.php");
		}
	}
?>