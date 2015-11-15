<body>
<link rel="stylesheet" type="text/css" href="stylesheets/NavbarStylings.css" />
<link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.min.css" />  

	<div class = "row">
		<div class = "col-md-12">	
			<nav id="mynavbar">
				<ul>
					<?php
						if(!isset($_SESSION['username'])) {
					?>
					<li style = "float:right;" id = "loginFeild" class = "loginFeild">				
						<div class = "loginInput">
							<form id="myform" action="login.php" method="post">
								<input type = "text" name="username" value = "Username" class = "username"/>
								<input type = "password" name="password" value = "password" class = "password"/>
								<input type="submit" name="submit" value="submit" >
							</form>
							<button class = "submit" onclick="submitform()"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></button>
						</div>
					</li>
					<li style = "float: right;" class = "loginButton" onclick = "appear()"><a href = "#">Login in</a></li>		
					<?php }
					else {
					?>
					<li style = "float: right;" class = "profile" ><a href="#"><?php echo $_SESSION['username']; ?></a>
						<ul>
							<li style="color: white;"><a href="profile_edit.php">Edit Profile</a></li>
							<li style="color: white;"><a href="logout.php">Logout</a></li>
						</ul>
					</li>
					<?php
					}
					?>
					<li><a href = "#">BlackBoard</a>
					<ul>
					<?php if(!isset($_SESSION['username'])) { ?>
					<li><a href = "signup.php">Sign Up</a></li> 
					<?php }?>
					<li><a href = "new_course.php">Contribute</a></li>
					</ul>
					</li>		
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
<?php	if(!isset($_SESSION['username'])) { ?>
<script>
	var login = document.getElementById("loginButton");
	var inputFields = document.getElementById("loginFeild")
	
	function appear()
	{
		inputFields.style.display = (inputFields.style.display == "none") ? "block" : "none"; 
	}

	function submitform()
	{
  		document.getElementById("myform").submit();
	}

</script>
<?php }
?>