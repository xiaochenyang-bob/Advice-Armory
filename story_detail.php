<?php
	require "config.php";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');
	$sql = "SELECT advice_id, story_text FROM story WHERE story_id=" . $_GET['story_id']; 
	$results = $mysqli->query($sql);
	if (!$results)
	{
		echo $mysqli->error;
		exit();
	}
	else
	{
		$row = $results->fetch_assoc();
		$advice_id = $row['advice_id'];
		$story_text = $row['story_text'];
	}
	function addLike($id)
	{
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$sql = "UPDATE story SET likes = likes + 1 WHERE story_id = " . $id . ";";
		$results = $mysqli->query($sql);
		if ( $results == false ) {
			echo $mysqli->error;
			exit();
		}
	}

	function removeLike($id)
	{
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$sql = "UPDATE story SET likes = likes - 1 WHERE story_id = " . $id . ";";
		$results = $mysqli->query($sql);
		if ( $results == false ) {
			echo $mysqli->error;
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Story Detail Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Caveat|Indie+Flower&display=swap" rel="stylesheet">
	<style>
		h1{
			color: white;
			font-family: 'Caveat', cursive;
		}
		#main{
			background-image: url("detail_background.jpg");
			width: 100%;
			/*change later*/
			height: 650px;
			background-size: cover;
			background-position: center;
		}
		#textWrapper
		{
			width: 80%;
			margin-left: auto;
			margin-right: auto;
			margin-top: 10px;
			background-color: white;
			padding: 2%;
			text-align: center;
			background-image: url("write_advice_background.jpg");
			background-size: cover;
			background-position: center;
			font-size: 2em;
			box-shadow: 5px 10px #888888;
			height: auto;
			overflow: auto;
			font-family: 'Indie Flower', cursive;
		}
		#textBox
		{
			height: 200px;
			overflow: auto;
			background-image: url("advice_background.jpg");
		}
		#content{
			width: 100%;
			font-size: 2em;
		}
		#back_button{
			width: 100%;
		}
		.fas{
			cursor: pointer;
			font-size: 1.5em;
		}
		.liked
		{
			color: #0D49EB;
		}
	</style>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div id = "main">
		<div class="container">
			<div class="row">
				<h1 class="col-12 mt-4 mb-4">Story Detail</h1>
			</div>

		</div>
		<div class = "container" id = "textWrapper">
				<div class = "row" >
					<!-- print the advice here -->
					<div class = "col-12 mt-5" id = "text">
					</div>
				</div>
		</div>
		<div class="container">
				<div class="row">
					<div class="col-sm-12 col-lg-9 mt-5" id = "textBox">
						<div id="content">
							<?php echo $story_text; ?>
							<i class="fas fa-thumbs-up"></i>
						</div>
					</div>
					<div class = "col-sm-12 col-lg-3 mt-5">
						<button type="button" class="btn btn-primary" id = "back_button">Back to stories</button>
					</div>
				</div>
			</form>
		</div>
		<?php include 'footer.php'; ?>
	</div>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		let endpoint = "https://api.adviceslip.com/advice/" + <?php echo $advice_id; ?>;
		function printFunction(results){
            console.log(results);
			let textBody = document.querySelector("#text");
			let text = results.slip.advice;
			textBody.innerHTML = text;	
		}
		ajax(endpoint, printFunction);
		document.querySelector("#back_button").onclick = function(){
			window.location.href = "stories.php";
		}
		document.querySelector(".fas").onclick = function(){
		if (this.classList.contains("liked"))
		{
			this.classList.remove("liked");
			<?php removeLike($_GET['story_id'])?>
		}
		else
		{
			this.classList.add("liked");
			<?php addLike($_GET['story_id'])?>
		}
	}
	</script>
</body>
</html>