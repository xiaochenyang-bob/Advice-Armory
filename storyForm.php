<?php
require "config.php";

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<link href="https://fonts.googleapis.com/css?family=Caveat|Indie+Flower&display=swap" rel="stylesheet">
	<style>
		#main{
			background-image: url("storyForm_background.jpg");
			width: 100%;
			/*change later*/
			height: 650px;
			background-size: cover;
			background-position: center;
		}
		h1{
			color: white;
			font-family: 'Caveat', cursive;
		}
		#textWrapper
		{
			width: 80%;
			margin-left: auto;
			margin-right: auto;
			background-color: white;
			margin-top: 2%;
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
		}
		#share_button{
			width: 100%;
		}
		#story-error{
			font-size: 2em;
		}
	</style>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div id = "main">
		<div class="container">
			<div class="row">
				<h1 class="col-12 mt-4 mb-4">Write Down Your Story</h1>
			</div>

		</div>
		<div class = "container" id = "textWrapper">
			<div class = "row" >
				<!-- print the advice here -->
				<div class = "col-12" id = "text">
				</div>
			</div>
		</div>
		<div class="container">
			<form action="submit_confirmation.php" method="POST" name="submitForm">
				<div class="form-group row">
					<div class="col-sm-12 col-lg-9 mt-5">
						<textarea name = "story" class="form-control" id = "textBox" placeholder="What's in your mind?"></textarea>
						<small id="story-error" class="invalid-feedback">Please fill up the story. </small>
						<!-- <input type="text" class="form-control" id="textBox" name="story"> -->
					</div>
					<div class = "col-sm-12 col-lg-3 mt-5">
						<input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>">
						<input name="advice_id" type = "hidden" value = "<?php echo $_GET['advice_id']; ?>">
						<input type="submit" class="btn btn-primary" id = "share_button">
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
		let endpoint = "https://api.adviceslip.com/advice/" + <?php echo $_GET['advice_id']; ?>;
		function printFunction(results){
            console.log(results);
			let textBody = document.querySelector("#text");
			let text = results.slip.advice;
			textBody.innerHTML = text;	
		}
		ajax(endpoint, printFunction);
		document.querySelector("form").onsubmit = function()
		{
			ajax(endpoint,printFunction);
			if ( document.querySelector('#textBox').value.trim().length == 0 ) {
				document.querySelector('#textBox').classList.add('is-invalid');
			} else {
				document.querySelector('#textBox').classList.remove('is-invalid');
			}
			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
</body>
</html>