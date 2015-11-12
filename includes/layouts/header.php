<link rel="stylesheet" type="text/css" href="stylesheets/NavbarStylings.css">
<link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.min.css">  
<body>

	<div class = "row">
		<div class = "col-md-12">	
			<nav id="mynavbar">
				<ul>
					<li style = "float:right;" id = "loginFeild">				
						<div class = "loginInput">
							<input type = "text" value = "Username" />
							<input type = "password" value = password />
						</div>
					</li>	
					<li style = "float: right;" class = "loginButton" onclick = "appear()"><a href = "#">Login in</a></li>
					<li style = "float: right;" class ><a href = "#">Sign Up</a></li>				
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
	    	     		 		$output .= "<a href=\"course.php?courseId={$course["courseCode"]}\">". htmlentities($course["courseName"]) . "</a>";
	    	    	  			$output .= "</li>";
	    	      				while($course = mysqli_fetch_assoc($course_set)) 
	        			  		{
	        	    				if($current_branch != $course["branch"]) 
	            					{
	            						$id = htmlentities(str_replace(' ', '', $course["branch"]));
	            						$output .= "</ul></li></ul></li>";
	          			  				$output .= "<li id = \"{$id}\"><a href =\"#\">". htmlentities($course["branch"]) ."</a>";
	          							$output .= "<ul>";
	     	    	   					$current_branch = $course["branch"];
	        	    					$current_sem = -1;
	            					}
	            					if($current_sem != $course["sem"]) 
	            					{
	            						if($current_sem != -1) 
	            						{
	            							$output .= "</ul></li>";
	            						}
	            						$current_sem = $course["sem"];
	            						$output .= "<li><a href=\"#\">Sem {$current_sem}</a><ul>";
	            					}
	            					$output .= "<li id = \"" .htmlentities($course["courseCode"]) ."\">";
	          						$output .= "<a href=\"course.php?courseId={$course["courseCode"]}\">" . htmlentities($course["courseName"]) . "</a>";
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
		</div>
	</div>
</body>
<script>
	var login = document.getElementById("loginButton");
	var inputFields = document.getElementById("loginFeild")
	
	function appear()
	{
		inputFields.style.display = (inputFields.style.display == "none") ? "block" : "none"; 
	}

	

</script>