<?php
	require "config.php";
	// echo $_POST["username"];
	// echo $_POST["advice_id"];
	// echo $_POST["story"];
if(isset($_POST['story']) && !empty($_POST['story'])){
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$story = $mysqli->real_escape_string($_POST['story']);
	$check_sql = "SELECT * FROM users
				WHERE username = '" . $_SESSION['username'] . "';";
	$results = $mysqli->query($check_sql);
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
	$insert_sql = "INSERT INTO story(user_id, advice_id, story_text, likes)
	    		VALUES(" . $user_id . "," . $_POST['advice_id'] . ", '" . $_POST['story'] . "', 0);"; 
	//echo $insert_sql;
	$results = $mysqli->query($insert_sql);
	if ($results) {
	   echo $mysqli->error;
	}
	$mysqli->close();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<style>
		#main{
			width: 100%;
			text-align: center;
			margin-top: 20px;
			color: green;
			font-size: 2em;
		}
		.container
		{
			width: 80%;
			margin-left: auto;
			margin-right: auto;
		}
		.btn
		{
			width: 100%;
		}
	</style>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div id = "main">
		Congratulations! Your story is shared.
	</div>
	<div class = "container">
		<div class = "row">
			<div id = "changeButton" class = "col col-12 col-lg-5 mt-4">
		      <button type="button" class="btn btn-primary" id = "backHome">Back to Home Page</button>
	        </div>
	        <div id = "storyButton" class = "col col-12 col-lg-5 offset-lg-2 mt-4">
		      <button type="button" class="btn btn-primary" id = "readStory">Read stories</button>
	        </div>
		</div>
	</div>
	
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		document.querySelector("#backHome").onclick = function()
		{
			window.location.href = "HomePage.php";
		}
		document.querySelector("#readStory").onclick = function()
		{
			window.location.href = "stories.php";
		}
	</script>
</body>
</html>