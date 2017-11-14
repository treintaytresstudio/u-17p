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
<div class="mini-profile">
	<div class="mini-profile-top">
		<div class="avatar" style="background: url(<?php echo $user->profileImage; ?>);"></div>
		<a class="acc-color" href="profile.php?username=<?php echo $user->username; ?>">
			<?php echo $user->screenName; ?>
			<span class="gray-color">@<?php echo $user->username; ?></span>	
		</a>
	</div>
	<div class="mini-profile-stats">
		<ul>
			<a href="profile.php?username=<?php echo $user->username; ?>&followersO=1" >
				<li><span class="number"><?php $getFromF->followersCount($reciver) ?></span> <span class="s-type">Followers</span></li>
			</a>
	
			<a href="profile.php?username=<?php echo $user->username; ?>&followingsO=1">
				<li><span class="number"><?php $getFromF->followingsCount($reciver) ?></span> <span class="s-type">Followings</span></li>
			</a>
			<a href="profile.php?username=<?php echo $user->username; ?>&postsO=1">
				<li><span class="number"><?php $getFromP->postCount($reciver) ?></span> <span class="s-type">Posts</span></li>
			</a>
		</ul>
	</div>
</div>
<!--<div class="new-post-home">
	<input type="text" placeholder="Caption">
	<i class="material-icons">add_a_photo</i>
	<i class="material-icons">send</i>
</div>-->