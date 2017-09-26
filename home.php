<?php
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);
	
	if($getFromU->loggedIn() === true){
		include BASE_URL.'/includes/header.php';
	}else{
		header('Location: index.php');
	}
    
?>

<div class="container mt-main">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
			<?php include 'includes/your-hashtags-home.php'; ?>
			<?php include 'includes/trending-topic-home.php'; ?>
		</div>
		<!-- posts -->
		<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 posts">
			<?php
				//Llamamos los posts del usuario 
				$getFromP->feedPosts($user_id)
			?>
		</div> <!-- /posts -->
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
			<?php include 'includes/trending-people-home.php'; ?>
			<?php include 'includes/ad-home.php'; ?>
		</div>
	</div>
</div>


<?php include BASE_URL.'/includes/footer.php' ?>
