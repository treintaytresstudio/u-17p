<?php 
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    $post_open = 1;

    //ID del post
    $post_id = $_GET['id'];

    if($getFromU->loggedIn() === true){
        include BASE_URL.'/includes/header.php';
    }else{
        header('Location: index.php');
    }
?>

<div class="container mt-main">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
		<!-- posts -->
		<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 posts">
			<?php
				//Llamamos los posts del usuario 
				$getFromP->post($post_id,$user_id,$post_open); 
			?>
		</div> <!-- /posts -->
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
	</div>
</div>

<?php include 'includes/footer.php';   ?>