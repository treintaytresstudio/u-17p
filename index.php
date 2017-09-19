<?php
	include 'core/init.php';
	
	if($getFromU->loggedIn() === true){
		header('Location: home.php');
	}

	if(isset($_POST['login']) && !empty($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($email) or !empty($password)){
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = 'Invalid format';
            }else{
                if($getFromU->login($email, $password) === false){
                    $error = "The email or password is incorrect!";
                }
            }
        }else{
            $error = "Please enter username and password!";
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
	<title>Login</title>
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
						<input class="form-control input-accent" type="text" placeholder="Email" name="email">
					</div>
					<div class="form-item">
						<input class="form-control input-accent" type="password" placeholder="Password" name="password">
					</div>
					<?php
						if(isset($error)){
							echo 
							'<div class="form-item">'
								.'<div class="alert alert-danger" role="alert">'
									.$error
								.'</div>'
							.'</div>';
						}
					?>
					<div class="form-item--space">
						<input type="submit" name="login" class="btn btn-primary btn-lg btn-block bg-accent" value="Sign In"></input>
					</div>
					<div class="form-item">
						<a href="signup.php" class="med-font accent-font">Create new account</a>
					</div>
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