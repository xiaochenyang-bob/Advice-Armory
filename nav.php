<?php
	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
	{
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$sql = "SELECT * FROM users
				WHERE username = '" . $_SESSION['username'] . "';";
		$results = $mysqli->query($sql);
		if (!$results)
		{
			echo $mysqli->error;
			exit();
		}
		if ($results->num_rows > 0){
			//Try to find the user's id
			$row = $results->fetch_assoc();
			$user_id = $row['user_id'];
		}
	}
?>
<!-- bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- font awesome -->
<link href="https://fonts.googleapis.com/css?family=Solway&display=swap" rel="stylesheet">
<!-- google fonts -->
<script src="https://kit.fontawesome.com/4abbf48612.js" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
	<img src = "logo.png" alt = "logo" id = "logo-image">
	 <?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) : ?>
    	<div class="p-2" id = "welcome_message">Hello <?php echo $_SESSION['username']; ?>!</div>
    	<!-- user icon -->
    	<i class="far fa-user-circle" id = "user_icon" >
    	</i>
    <?php endif; ?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		 <span class="navbar-toggler-icon"></span>
    </button>
   
	  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
	            <a class="nav-item nav-link" href="HomePage.php">Home Page <span class="sr-only">(current)</span></a>
	      <?php if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) : ?>
	            <a class="nav-item nav-link" href="login.php">Login</a>
	            <a class="nav-item nav-link" href="register.php">Register</a>
	            <a class="nav-item nav-link" href="stories.php">Stories</a>
		   <?php else : ?>
	            <a class="nav-item nav-link" href="logout.php">Logout</a>
	            <a class="nav-item nav-link" href="stories.php">Stories</a>
	       <?php endif; ?>
	  </div>
</nav>
