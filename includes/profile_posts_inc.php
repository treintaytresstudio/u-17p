<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/u-17p/core/init.php';
	$user_id = $_SESSION['user_id'];

	    //Mini profile
		$user = $getFromU->userData($user_id);
		$username = $user->username;
	    $profileId = $getFromU->userIdByUsername($username);
		$profileData = $getFromU->userData($profileId);
		$profileOwner = $profileData->user_id;
		$reciver = $profileOwner;
?>
<div id="profile-posts">
	<div class="posts-mosaic">
		<?php $getFromP->posts($profileOwner); ?>
	</div>
</div>