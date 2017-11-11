<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/u-17p/core/init.php';
	$user_id = $_SESSION['user_id'];

	        //Mini profile
	    	$username_profile = $_GET['username_profile'];
	        $profileId = $getFromU->userIdByUsername($username_profile);
	    	$profileData = $getFromU->userData($profileId);
	    	$profileOwner = $profileData->user_id;
	    	$reciver = $profileOwner;
?>
<div id="profile-followings">
	<h3>Followings list</h3>
	<ul class="list-tw">
		<?php $getFromF->getFollowingsList($reciver) ?>
	</ul>
</div>