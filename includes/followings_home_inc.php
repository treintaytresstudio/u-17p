<div class="followings-home">
	<div class="home-section-title">
		<h2> Following</h2>
		<a href="profile.php?username=<?php echo $user->username; ?>&followingsO=1">Show all</a>
	</div>
	<ul class="list-tw">
		<?php $getFromF->getFollowingsList($user_id); ?>
	</ul>
</div>