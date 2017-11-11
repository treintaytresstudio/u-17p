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
<div id="profile-followers">
	<h3>Followers list</h3>
	<ul class="list-tw">
		<?php $getFromF->getFollowersList($reciver) ?>
	</ul>
</div>