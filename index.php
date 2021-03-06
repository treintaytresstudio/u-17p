<?php
	include 'core/init.php';
	
	if($getFromU->loggedIn() === true){
		header('Location: home.php');
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
	<title>Login</title>
</head>
<body>
<!-- login header -->
<header class="login-header">
	<div class="logo">
		<img src="assets/images/logo-black.png" alt="logo ultra">
	</div>
	<nav>
		<ul>
			<li><a href="#">ABOUT</a></li>
			<li><a href="#">PRIVACY</a></li>
			<li><a href="#">BUSINESS</a></li>
			<li><a href="#">CONTACT</a></li>
		</ul>
	</nav>
	<a href="signup.php" class="btn bg-mainDark">CREATE ACCOUNT</a>

</header><!-- /login header -->

<!-- login -->
<div class="full login">
	<div class="full-box login-box">
		<div class="phone">
			<img src="assets/images/phone.png" alt="">
		</div>
		<div class="form">
			<form method="POST" autocomplete="off">
				<h1>Please sign in</h1>
				<div class="form-item">
					<button type="button" class="btn btn-primary btn-lg btn-block bg-facebook">Connect with Facebook</button>
				</div>
				<div class="form-item">
					<span>or</span>
				</div>
				<div class="form-item">
					<input class="form-control input-accent" type="text" placeholder="Email" name="email" id="email">
				</div>
				<div class="form-item">
					<input class="form-control input-accent" type="password" placeholder="Password" id="password" name="password" autocomplete="new-password">
				</div>
				<div class="form-item hide login-error">
					edc
				</div>
				<div class="form-item--space">
					<span class="btn btn-primary btn-lg btn-block bg-main" id="loginBtn">Sign in</span>
				</div>

				<div class="sk-fading-circle hide login-loader">
				  <div class="sk-circle1 sk-circle"></div>
				  <div class="sk-circle2 sk-circle"></div>
				  <div class="sk-circle3 sk-circle"></div>
				  <div class="sk-circle4 sk-circle"></div>
				  <div class="sk-circle5 sk-circle"></div>
				  <div class="sk-circle6 sk-circle"></div>
				  <div class="sk-circle7 sk-circle"></div>
				  <div class="sk-circle8 sk-circle"></div>
				  <div class="sk-circle9 sk-circle"></div>
				  <div class="sk-circle10 sk-circle"></div>
				  <div class="sk-circle11 sk-circle"></div>
				  <div class="sk-circle12 sk-circle"></div>
				</div>
				
			</form>
		</div>
	</div>
</div>
<!-- /login -->


<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="../u-17p/core/js/login.js"></script>
</body>
</html>