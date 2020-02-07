<?php
	require "config.php";
	if( isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
		header('Location: HomePage.php');
	}
	else{
		if( isset($_POST['username']) && isset($_POST['password']) ){
			if( empty($_POST['username']) || empty($_POST['password']) ) {
				$error = "Please enter a username and password ";
			}
			else{
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				if($mysqli->connect_errno) {
					echo $mysqli->connect_error;
					exit();
				}
				$usernameInput = $_POST["username"];	
				$passwordInput = hash("sha256", $_POST["password"]);
				$sql = "SELECT * FROM users
					WHERE username = '" . $usernameInput . "' AND password = '" . $passwordInput . "';";
				$results = $mysqli->query($sql);
				if (!$results)
				{
					echo $mysqli->error;
					exit();
				}
				if ($results->num_rows > 0){
					$_SESSION['logged_in'] = true;
					$_SESSION['username'] = $usernameInput;
					header('Location: HomePage.php');
				}
				else{
					$error = "Invalid username or password";
				}
				$mysqli->close();
			}
		}
	}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Story Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<style>
		#main{
			background-image: url("login_background.jpg");
			width: 100%;
			height: 650px;
			background-size: cover;
			background-position: center;
		}
		#logIn_form{
			width: 60%;
			margin-left: auto;
			margin-right: auto;
		}
		#error_message{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div id = "main">
		<div id = "logIn_form">
	  		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto" id = "error_message">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			
			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->
		    </form>
	  </div>
	  <?php include 'footer.php'; ?>
	</div>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>