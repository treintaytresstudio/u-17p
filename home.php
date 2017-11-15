<?php
	//Pagina activa en menu
	$page = 0;
	//Comentarios en los posts
	$post_open = 0;
	//Usuario nuevo
	if(isset($_GET['new_user'])){
		$new_user = $_GET['new_user'];
	}

	//Archivo principal de clases
    include_once 'core/init.php';

    //Usuario conectado
    $user_id = $_SESSION['user_id'];

    //Mini profile
	$user = $getFromU->userData($user_id);
	$username = $user->username;
    $profileId = $getFromU->userIdByUsername($username);
	$profileData = $getFromU->userData($profileId);
	$profileOwner = $profileData->user_id;
	$reciver = $profileOwner;
	
	//Si el usuario no está logueado, lo regresamos al login
	if($getFromU->loggedIn() === true){
		include BASE_URL.'/includes/header.php';
	}else{
		header('Location: index.php');
	}

    
?>

<div class="container mt-main">
	
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 animated fadeIn">
			<!-- mini profile -->
			<div class="mini-profile-container">
				<?php include 'includes/mini_profile_inc.php'; ?>
			</div><!-- /mini profile container -->

			<!-- my followigns -->
			<div class="followigns-home-container">
				<?php include 'includes/followings_home_inc.php'; ?>
			</div><!-- /followigns home container -->
		</div>
		<!-- posts -->
		<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 posts feed-container">
			<?php include 'includes/feed_inc.php'; ?>


		</div> <!-- /posts -->
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
			<!-- trends for you -->
			<div class="trends-for-you-container">
				<?php include 'includes/trends_home_inc.php'; ?>
			</div><!-- /trends for you -->

			<!-- suggested users -->
			<div class="suggested-users-container">
				<?php include 'includes/suggested_users_home_inc.php'; ?>
			</div><!-- /suggested users -->
		</div>
	</div>
</div>


<?php include BASE_URL.'/includes/footer.php' ?>
