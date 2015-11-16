<?php

	//all use functions
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function redirect_to($location)
	{
		header("Location: ".$location);
		exit;
	}

	function mysql_prep($string)
	{
		global $connection;
		$safe = mysqli_real_escape_string($connection,$string);
		return $safe;
	}

	//functions for handling admin users
	function find_admin_by_username($username) {
		global $connection;

		$safe_username = mysqli_real_escape_string($connection, $username);
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);

		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}

	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));

		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);

		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);

		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);

		return $salt;
	}

	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function attempt_login($username, $password) {

		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashedPassword"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}

	function logged_in() {
		return isset($_SESSION['admin_id']);
	}

	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}

	//getting information functions
	function getBranchByName($branchName) {
		global $connection;
		$safe_branch = mysqli_real_escape_string($connection, $branchName);
		$query  = "SELECT * ";
		$query .= "FROM branch ";
		$query .= "WHERE branchName = '{$safe_branch}' ";
		$branch_set = mysqli_query($connection, $query);
		confirm_query($branch_set);
		if($branch = mysqli_fetch_assoc($branch_set)) {
			mysqli_free_result($branch_set);
			return $branch;
		} else {
			return null;
		}
	}

	function getAllBranches() {
		global $connection;
		$query = "SELECT branchName FROM branch";
		$branch_set = mysqli_query($connection,$query);
		confirm_query($branch_set);
		return $branch_set;
	}

	function getAllCourses() {
		global $connection;
		$query = "select courseName,courseCode,branch,sem FROM course ORDER BY branch ASC,sem ASC";
		$branch_set = mysqli_query($connection,$query);
		confirm_query($branch_set);
		return $branch_set;
	}
	
	function getCourseByCode($courseCode) {
		global $connection;
		$safe_code = mysql_prep($courseCode);
		$query = "SELECT * FROM course ";
		$query .= "WHERE courseCode = '{$safe_code}'";
		$course_set = mysqli_query($connection, $query);
		if($course = mysqli_fetch_assoc($course_set)) {
			return $course;
		} else {
			return null;
		}
	}
	
	function getCourseByBranch($branch) {
		global $connection;
		$safe_branch = mysql_prep($branch);
		$query = "SELECT * FROM course ";
		$query .= "WHERE branch = '{$safe_branch}'";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
	}

	function getCourseByBranchSem($branch,$sem) {
		global $connection;
		$safe_branch = mysql_prep($branch);
		$query = "SELECT courseCode, courseName FROM course ";
		$query .= "WHERE branch = '{$safe_branch}' AND sem={$sem}";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		if($course_set) {
			return $course_set;
		}
		else {
			return null;
		}

	}

	//delete functions for all three tables
	function deleteBranchByName($branch) {
		$safe_branch = mysql_prep($connection, $branch);
		$query = "DELETE FROM branch WHERE ";
		$query .= "branchName = '{$safe_branch}'";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
	}
	
	function deleteCourseByCode($courseCode) {
		$safe_code = mysql_prep($courseCode);
		$query = "DELETE FROM course WHERE ";
		$query .= "courseCode = '{$safe_code}'";
		$result = mysqli_query($connection, $query);
		confirm_query($result);		
	}

	function deleteUserById($UserId) {
		$query = "DELETE FROM admins WHERE ";
		$query .= "id = {$id}";
		$result = mysqli_query($connection, $query);
		confirm_query($result);		
	}
	function upload($file) {
		$target_dir = "../assets/uploads/";
		$target_file = $target_dir . basename($file["name"]);
		$uploadOk = 1;
		$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size 10mb
		if ($file["size"] > 10000000) {
		    $uploadOk = 0;
		    //file too large
		}
		
		if(is_executable($target_file)) {
		    $uploadOk = 0;
		    //file is executable
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    return;
		// if everything is ok, try to upload file
		}
		else {
		    if (move_uploaded_file($file["tmp_name"], $target_file)) {
		        return $target_file;
		    } else {
		        return;
		    }
		}
	}
?>
