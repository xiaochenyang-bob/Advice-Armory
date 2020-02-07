<?php
require "config.php";
if ( isset($_POST['email']) && !empty($_POST['email'])
&& isset($_POST['username']) && !empty($_POST['username'])
&& isset($_POST['password']) && !empty($_POST['password']) ) {
	
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$username = $mysqli->real_escape_string($_POST['username']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$password = hash("sha256", $_POST['password']);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$check_sql = "SELECT * FROM users WHERE username = '" . $username . "' OR email = '" . $email. "';";
	$results_registered = $mysqli->query($check_sql);
	if ($results_registered->num_rows > 0)
 	{
 		echo "Username or email has been already taken. Please choose another one.";
 	}
 	else{
	    $sql = "INSERT INTO users(username, email, password)
	    		VALUES('" . $username . "','" . $email . "', '" . $password . "');"; 
	    $results = $mysqli->query($sql);
	    if ($results) {
	    	echo $mysqli->error;
	    }
	    $_SESSION['logged_in'] = true;
		$_SESSION['username'] = $username;
    }
    $mysqli->close();
}
else
{
	echo "Fill up required fields";
}
?>
