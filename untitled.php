<div class="fluid-container login">
	<div class="row">
		<!-- login hero -->
		<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 login-hero">

		</div><!-- /login hero -->

		<!-- login-form -->
		<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form">
			<div class="wrap">
				<form method="POST" autocomplete="off">
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
						<input class="form-control input-accent" type="password" placeholder="Password" name="password" autocomplete="new-password">
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
			
		</div><!-- /login-form -->
	</div>
</div>