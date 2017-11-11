<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/u-17p/core/init.php';


        //Mini profile
    	$username_profile = $_GET['username_profile'];
        $profileId = $getFromU->userIdByUsername($username_profile);
    	$profileData = $getFromU->userData($profileId);
    	$profileOwner = $profileData->user_id;
    	$user_id = $profileOwner;

?>
<div id="profile-posts">
	<div class="posts-mosaic">
		<?php $getFromP->posts($user_id); ?>
	</div>
</div>