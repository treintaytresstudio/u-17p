<?php 
    include 'core/init.php';
    include 'includes/header.php'; 
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    $post_open = 1;

    //ID del post
    $hashtag_name = $_GET['hashtag_name'];

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
                $getFromH->postsHashtag($hashtag_name);
			?>
		</div> <!-- /posts -->
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
	</div>
</div>


<?php include 'includes/footer.php'; ?>