<?php 
    include 'core/init.php';

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
		<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 trends-block">
            <div class="home-section-title">
                <h2>Trends for you</h2>
                <a href="#" class="acc-color">Change</a>
            </div>
            <ul>
                <?php $getFromH->trendingUsersHome(); ?> 
            </ul>            
        </div>
		<!-- posts -->
		<div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">

            <div class="section-title">
                <h1><?php echo '#'.$hashtag_name ?></h1>
                <div class="section-button">
                    <?php $getFromH->isFollowingHashtag($user_id,$hashtag_name); ?>
                </div>
                
            </div>
            <div class="posts-mosaic">
                    <?php
                        //Llamamos los posts del usuario 
                        $getFromH->postsHashtag($hashtag_name, $user_id);
                    ?>
            </div>
		</div> <!-- /posts -->
	</div>
</div>


<?php include 'includes/footer.php'; ?>