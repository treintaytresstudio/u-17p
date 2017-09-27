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
<!-- explore -->
<div class="container mt-main">

    <div class="container-middle">
        <!-- row explore-search -->
        <div class="row">
            <div class="explore-search">
                <input type="text" id="explore-search" placeholder="Search for # and posts">
            </div>
            <div id="explore-search-data"></div>
        </div><!-- /row explore-search -->

        <!-- row trending people-->
        <div class="row hideOnSearch">
            <?php include 'includes/trending-users-explore.php';?>
        </div><!-- /row trending people-->

        <!-- title-->
        <div class="row hideOnSearch">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="explore-title">
                    <h2>Hashtag trends</h2>
                </div>
            </div>
        </div><!-- /title-->

        <!-- row trending hashtags-->
        <div class="row hideOnSearch explore-sug-hashtags">
            <?php include 'includes/trending-hashtags-explore.php';?>
        </div><!-- /row trending hashtags-->
    </div>

</div><!-- /explore -->


<?php include BASE_URL.'/includes/footer.php' ?>