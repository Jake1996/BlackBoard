<link rel="stylesheet" href="stylesheets/NavbarStylings.css">
<body>
<nav id="mynavbar">
	<ul>
		<li><a href="#">Home</a></li>
		<li><a href="#">Courses</a>
		<?php
	        $output ="";
	        $output .="<ul id = \"navmenu\">";
	        $current_branch = "";
	        $current_sem = 0;
	        $course_set = getAllCourses();
	        if($course = mysqli_fetch_assoc($course_set))
	        {
	          $id = htmlentities(str_replace(' ', '', $course["branch"]));
	          $current_sem = $course["sem"];
	          $output .= "<li id = \"{$id}\"><a href =\"#\">". htmlentities($course["branch"])."</a>";
	          $output .= "<ul>";
	          $current_branch = $course["branch"];
	          $output .= "<li><a href = \"#\">Sem {$current_sem}</a><ul>";
	          $output .= "<li id = \"";
	          $output .= htmlentities($course["courseCode"]) . "\">";
	          $output .= "<a href \"#\">". htmlentities($course["courseName"]) . "</a>";
	          $output .= "</li>";
	          while($course = mysqli_fetch_assoc($course_set)) {
	            if($current_branch != $course["branch"]) {
	            	$id = htmlentities(str_replace(' ', '', $course["branch"]));
	            	$output .= "</ul></li></ul></li>";
	            	$output .= "<li id = \"{$id}\"><a href =\"#\">". htmlentities($course["branch"]) ."</a>";
	          		$output .= "<ul>";
	            	$current_branch = $course["branch"];
	            	$current_sem = -1;
	            }
	            if($current_sem != $course["sem"]) {
	            	if($current_sem != -1) {
	            		$output .= "</ul></li>";
	            	}
	            	$current_sem = $course["sem"];
	            	$output .= "<li><a href=\"#\">Sem {$current_sem}</a><ul>";
	            }
	            $output .= "<li id = \"" .htmlentities($course["courseCode"]) ."\">";
	          	$output .= "<a href \"#\">" . htmlentities($course["courseName"]) . "</a>";
	         	$output .= "</li>";
	          }
	          mysqli_free_result($course_set);
	        }
	        $output .= "</ul>";
	        echo $output;
	    ?>
		</li>	
	</ul>
</nav>