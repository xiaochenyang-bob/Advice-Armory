<?php
	if (isset($_GET['advice_id']) || !empty($_GET['advice_id']))
	{
		$advice_id = $_GET['advice_id'];
	}
	else
	{
		$advice_id = -1;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="nav_style.css">
	<style>
		#main{
			background-image: url("register_background.jpg");
			width: 100%;
			height: 650px;
			background-size: cover;
			background-position: center;
		}
		#register_form{
			width: 60%;
			margin-left: auto;
			margin-right: auto;
		}
		#error_message{
			color: red;
		}
    </style>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div id = "main">
		<div id = "register_form">
			<form action="" method="">
			<div class = "row mb-3">
			</div>
			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<!-- In bootstrap, class is-invalid and invalid-feedback can help doing validation -->
					<input type="text" class="form-control" id="username-id" name="username">
					<small id="username-error" class="invalid-feedback">Username is required.</small>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="email-id" class="col-sm-3 col-form-label text-sm-right">Email: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="email" class="form-control" id="email-id" name="email">
					<small id="email-error" class="invalid-feedback">Email is required.</small>
				</div>
			</div> <!-- .form-group -->	

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
					<small id="password-error" class="invalid-feedback">Password is required.</small>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="ml-auto col-sm-9">
					<span class="text-danger font-italic">* Please fill out the required fileds</span>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-3">
					<button type="submit" class="btn btn-primary">Register</button>
					<a href="HomePage.php" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="col-sm-9 ml-sm-auto">
					<a href="login.php">Already have an account</a>
				</div>
			</div> <!-- .row -->

			<div class = "row">
				<div class="col-sm-9 ml-sm-auto" id = "error_message">
				</div>
			</div>

		</form>
		</div>
		<?php include 'footer.php';?>
	</div>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		document.querySelector("form").onsubmit = function(event)
		{
			event.preventDefault();
			//validation
			if ( document.querySelector('#username-id').value.trim().length == 0 ) {
				document.querySelector('#username-id').classList.add('is-invalid');
			} else {
				document.querySelector('#username-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password-id').value.trim().length == 0 ) {
				document.querySelector('#password-id').classList.add('is-invalid');
			} else {
				document.querySelector('#password-id').classList.remove('is-invalid');
			}
			//
			let usernameInput = document.querySelector("#username-id").value.trim();
			let emailInput = document.querySelector('#email-id').value.trim();
			let passwordInput = document.querySelector('#password-id').value.trim();
			let advice_id = "<?php echo $advice_id?>";
			ajaxPost("register_confirmation.php", "username=" + usernameInput + "&email=" + emailInput + "&password=" + passwordInput, function(results){
				document.querySelector("#error_message").innerHTML = results;
				if (results.trim() == '')
				{
				    if (advice_id != -1)
				    {
				    	location.href = "storyForm.php?advice_id=" + advice_id;
				    }
				    else {
					 	location.href = "HomePage.php";
				    }			
				}
			});

			//return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}





		function ajaxPost(endpointUrl, postdata, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('POST', endpointUrl, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						returnFunction( xhr.responseText );
					} else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send(postdata);
		};
	</script>
</body>
</html>