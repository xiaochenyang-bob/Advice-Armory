<?php
	require "config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Caveat&display=swap" rel="stylesheet">
	<style>
		#main{
			background-image: url("home_background.jpg");
			width: 100%;
			height: auto;
			background-size: cover;
			background-position: center;
			padding-bottom: 10px;
		}
		#mainAdvice{
			margin-top: 2%;
			padding: 2%;
			background-color: white;
			text-align: center;
			background-image: url("advice_background.jpg");
			background-size: cover;
			background-position: center;
			font-family: 'Caveat', cursive;
			font-size: 4em;
			box-shadow: 5px 10px #888888;
			height: 500px;
			overflow: auto;
		}
		#icon{
			font-size: 0.7em;
			cursor: pointer;
			float: right;
			margin-top: 10px;
		}
		#changeButton button
		{
			width: 100%;
			font-size: 2em;
		}
		#changeButton
		{
			margin-top: 2%;
		}
		#storyButton button
		{
			width: 100%;
			font-size: 2em;
		}
		#storyButton{
			margin-top: 2%;
		}
	</style>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div id = "main">
		<div class = "container-fluid">
        	<div class = "row">
        		<div id = "mainAdvice" class = "col col-8 offset-2">
        			<!-- this is where the main text body locates -->
        			<div id = "text">
        			</div>
        			<div class="clearfloat"></div>
        		</div>
        		<div id = "changeButton" class = "col col-lg-3 offset-lg-2 col-8 offset-2">
        			<button type="button" class="btn btn-primary" id = "changeText">Give me another one</button>
        		</div>
        		<div id = "storyButton" class = "col col-lg-3 col-8 offset-2">
        			<button type="button" class="btn btn-primary" id = "readStory">Read stories</button>
        		</div>
        	</div>
        	<div class = "row mt-4">
        	</div>
         </div>
         <?php include 'footer.php'; ?>
    </div>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		let endpoint = "https://api.adviceslip.com/advice";
		function printFunction(results){
			let textBody = document.querySelector("#text");
			let text = results.slip.advice;
			let id = results.slip.slip_id;
			console.log(text);
			textBody.innerHTML = text;
			let element = document.createElement("div");
			element.id = "icon";
			let heart = document.createElement("i");
			heart.classList.add("fas");
			heart.classList.add("fa-heart");
			element.appendChild(heart);
			textBody.appendChild(element);
			heart.onclick = function()
			{
				<?php if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) : ?>
			 		location.href = "register.php?advice_id=" + id;
			 	<?php else:?>
			 		//Where the user can fill up a story for the advice
			 		location.href = "storyForm.php?advice_id="+ id;
			 	<?php endif;?>		
			}		

		}
		ajax(endpoint, printFunction);
		document.querySelector("#changeText").onclick = function()
		{
			ajax(endpoint, printFunction);
		}
		document.querySelector("#readStory").onclick = function()
		{
			window.location.href = "stories.php";
		}
	</script>
</body>
</html>