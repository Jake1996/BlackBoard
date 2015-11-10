<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<html>
<head>
	<title>Browse</title>
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/browse.css">
</head>
<?php require_once("../includes/layouts/header.php"); ?>
	<h1>Courses</h1>
	<div class = "row">
		<div class = "col-md-12">
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
</body>
<script type="text/javascript">
var x = document.getElementById("c1-y4-cs");
x.innerHTML = "Chemistry";
</script>
</html>
<?php require_once("../includes/layouts/footer.php"); ?>
