<?php
	include 'core/init.php';
	if(isset($_SEESION['user_id'])){
		header('Location: home.php');
	}

	if(isset($_POST['signup'])){
		$screenName = $_POST['screenName'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$error = '';

		if(empty($screenName) or empty($password) or empty($email)){
			$error = 'All fields are required';
		}else{
			$email = $getFromU->checkInput($email);
			$screenName = $getFromU->checkInput($screenName);
			$password = $getFromU->checkInput($password);
			if(!filter_var($email)){
				$error = 'Invalid email format';
			}else if(strlen($screenName)>20){
				$error = 'Name must be between in 6-20 characters';
			}else if(strlen($password)< 5){
				$error = 'Password is too short';
			}else{
				if($getFromU->checkEmail($email) === true){
					$error = 'Email is already in use';
				}else{
					$getFromU->registerUser($email, $screenName, $password);
					header('Location: settings.php');
				}
			}
		}

	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/css/33-style.css">
	<title>Sign up</title>
</head>
<body>

<!-- login -->
<div class="fluid-container login">
	<div class="row">
		<!-- login hero -->
		<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 login-hero">

		</div><!-- /login hero -->

		<!-- login-form -->
		<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form">
			<div class="wrap">
				<div class="form-logo">
					<img src="assets/images/logo.png" alt="logo ultra">
				</div>
				<form method="POST">
					<div class="form-item">
						<button type="button" class="btn btn-primary btn-lg btn-block bg-facebook">Connect with Facebook</button>
					</div>
					<div class="form-item">
						<span>or</span>
                    </div>
                    <div class="form-item">
						<input class="form-control input-accent" type="text" placeholder="Name" name="screenName">
					</div>
					<div class="form-item">
						<input class="form-control input-accent" type="text" placeholder="Email" name="email">
                    </div>
					<div class="form-item">
						<input class="form-control input-accent" type="password" placeholder="Password" name="password">
					</div>
					<div class="form-item--space">
						<input type="submit" class="btn btn-primary btn-lg btn-block bg-accent" name="signup" value="Sign up">
					</div>
					<?php
						if(isset($error)){
							echo '<div class="form-item">'
								.$error.
							'</div>';
						}
					?>
				
				</form>
			</div>
			<div class="login-links">
				<ul>
					<li><a href="#">About</a></li>
					<li><a href="#">Privacy</a></li>
					<li><a href="#">Contact us</a></li>
				</ul>
			</div>
		</div><!-- /login-form -->
	</div>
</div>
<!-- /login -->


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>