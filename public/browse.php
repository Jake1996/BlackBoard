<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/session.php"); ?>

<html>
<head>
	<title>Browse</title>
	<link rel="stylesheet" type="text/css" href="stylesheets/browse.css">
</head>
<?php require_once("../includes/layouts/header.php"); ?>
	<p class="message">
		<?php 
			if(isset($_SESSION['message'])) {
				echo $_SESSION['message'];
				$_SESSION['message']=null;
			}
		?>
	</p>

	<h1>Courses</h1>
	<div class = "row1">
		<div class = "">
	      <?php
	        $output ="";
	        $output .="<ul id = \"navmenu\">";
	        $current_branch = "";
	        $current_sem = -1;
	        $course_set = getAllCourses();
	        if($course = mysqli_fetch_assoc($course_set))
	        {
	          $id = htmlentities(str_replace(' ', '', $course["branch"]));
	          $current_sem = $course["sem"];
	          $output .= "<li><h2 id = \"{$id}\">";
	          $output .= htmlentities($course["branch"]);
	          $output .= "</h2>";
	          $output .= "<table class = \"{$id}\">";
	          $current_branch = $course["branch"];
	          $output .= "<tr><th>Sem {$current_sem}</th>";
	          $output .= "<td id = \"" . htmlentities($course["courseCode"]) . "\">";
	          $output .= "<a href=\"course.php?courseId={$course["courseCode"]}\">". htmlentities($course["courseName"]) . "</a>";
	          $output .= "</td>";
	          while($course = mysqli_fetch_assoc($course_set)) {
	            if($current_branch != $course["branch"]) {
	              $id = htmlentities(str_replace(' ', '', $course["branch"]));
	              $output .= "</table></li>";
	              $output .= "<li><h2 id = \"{$id}\">";
	        	  $output .= htmlentities($course["branch"]);
	          	  $output .= "</h2>";
	              $output .= "<table class = \"{$id}\">";
	              $current_branch = $course["branch"];
	              $current_sem = -1;
	            }
	            if($current_sem != $course["sem"]) {
	              $current_sem = $course["sem"];
	              $output .= "</tr>";
	              $output .= "<tr><th>Sem {$current_sem}</th>";
	            }
	            $output .= "<td id = \"" . htmlentities($course["courseCode"]) . "\">";
	            $output .= "<a href=\"course.php?courseId={$course["courseCode"]}\">". htmlentities($course["courseName"]) . "</a>";
	            $output .= "</td>";
	          }
	          $output .= "</table></li>";
	        }
	        mysqli_free_result($course_set);
	        $output .= "</ul>";
	        echo $output;
	      ?>
		<div>
	<div>	

<?php require_once("../includes/layouts/footer.php"); ?>
