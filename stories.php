<?php 
	require "config.php";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');
	$sql = "SELECT story_id, advice_id, story_text FROM story ORDER BY likes DESC;"; 
	$results = $mysqli->query($sql);
	if ( $results == false ) {
		echo $mysqli->error;
		exit();
	}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Story Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Amatic+SC&display=swap" rel="stylesheet">
	<style>
		#main{
			background-image: url("story_background.jpg");
			width: 100%;
			height: auto;
			background-size: cover;
			background-position: center;
		}
		.wrapper{
			overflow: auto;
		}
		.wrapper p
		{
			font-size: 2em;	
		}
		.advice
		{
			margin-top: 2%;
			border-style: solid;
			border-color: black;
			border-width: 1px;
			background-color: white;
		}
		.story
		{
			margin-top: 2%;
			border-style: solid;
			border-color: black;
			border-width: 1px;
			background-color: white;
		}
		.advice
		{
			cursor: pointer;
		}
		.advice p{
			font-family: 'Bebas Neue', cursive;
		}
		.story p{
			font-family: 'Amatic SC', cursive;
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
		<div class = "container-fluid">
        	<div class = "row wrapper" id = "allStories">
        		<!-- where all database data came in -->
        	</div>
        	<div class = "row mt-5">
			</div>
        </div>
        <?php include 'footer.php'; ?>
	</div>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		let wrapper = document.querySelector("#allStories");
		function fillStory(){
			let endpoint = "";
			let text = "";
			let story = "";
			let element1;
			let element2;
			<?php while ( $row = $results->fetch_assoc() ) : ?>
				endpoint = "https://api.adviceslip.com/advice/" + <?php echo $row['advice_id']?>;
				ajax(endpoint, function(results){
					text = results.slip.advice;
					element1 = document.createElement("div");
		  			element1.classList.add("col", "col-8", "offset-2", "col-lg-5", "offset-lg-1", "advice");
		  			if (text.length>50)
		  			{
		  				text = text.substring(0, 50) + "...";
		  			}
		  			element1.innerHTML = "<p>Advice: " + text + "</p>";
		  			wrapper.appendChild(element1);
		  			element1.onclick = function(){
		  				location.href = "story_detail.php?story_id=" + <?php echo $row['story_id'];?>;
		  			}
		  			story = "<?php echo $row['story_text'];?>";
					element2 = document.createElement("div");
					element2.classList.add("col", "col-8",  "offset-2", "col-lg-5", "offset-lg-0", "story");
					if (story.length>50)
	   	  			{
	   	  				story = story.substring(0, 50) + "...";
	   	  			}
	   	  			element2.innerHTML = "<p>Story: " + story + "</p>";
	   	//   			let thumb = document.createElement("i");
					// thumb.classList.add("fas");
					// thumb.classList.add("fa-thumbs-up");
					// thumb.onclick = function(){
					// 	if (this.classList.contains("liked"))
					// 	{
					// 		this.classList.remove("liked");
					// 		<?php //removeLike($row['story_id']);?>
					// 	}
					// 	else
					// 	{
					// 		this.classList.add("liked");
					// 		<?php //addLike($row['story_id']);?>
					// 	}
					// }
					// element2.appendChild(thumb);
	   	  			wrapper.appendChild(element2);
					});
			<?php endwhile; ?>
		}
		fillStory();	
		let thumbs = document.querySelectorAll(".fas");
		console.log("test");	
	</script>
</body>
</html>