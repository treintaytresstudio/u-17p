<?php

    if(isset($_GET['username']) === true  && empty($_GET['username']) === false){
		include 'core/init.php';

		$page = 4;
		
		//Sabemos de quien es el perfil y sacamos sus datos
        $username = $getFromU->checkInput($_GET['username']);
        $profileId = $getFromU->userIdByUsername($username);
		$profileData = $getFromU->userData($profileId);
		$profileOwner = $profileData->user_id;
		$reciver = $profileOwner;
		
		//Sabemos quien está logueado
		$user_id = $_SESSION['user_id'];
		$user = $getFromU->userData($user_id);
		$sender = $_SESSION['user_id'];

		if($getFromU->loggedIn() === true){
			include BASE_URL.'/includes/header.php';
		}else{
			//necesitas loguearte para ver este perfil
			header('Location: index.php');
		}
    }else{
		//Perfil no válido
	}
?>

<section>
	<!--
	<div class="profile-top">
		<i class="material-icons">keyboard_backspace</i>
		<span>Back</span>
	</div>-->
	<div class="profile" style="background:url(<?php $cover = $getFromP->getCoverProfile($user_id); echo $cover; ?>);">
		<div class="profile-wrap">
			<div class="profile-info">
				<div class="profile-info-item flex-a-center">
					<div class="profile-info-pp">
						<div class="avatar" style="background:url(<?php echo $profileData->profileImage; ?>);">
							<?php if($user_id == $reciver){ ?>
							<div class="profile-image-update">
								<i class="material-icons">file_upload</i>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="profile-info-user">
						<h2><?php echo $profileData->screenName; ?></h2>
						<p class="profile-username">@<?php echo $profileData->username; ?></p>
						<p class="profile-bio"><?php echo $profileData->bio; ?></p>
					</div>
				</div>
				<!--
				<div class="profile-info-item">
					<div class="profile-numbers-user">
						<span>Followers </span><?php $getFromF->followersCount($reciver) ?>
						<span>Followings </span><?php $getFromF->followingsCount($reciver) ?>
						<span>Posts </span><?php $getFromP->postCount($reciver) ?>
					</div>
				</div>
				-->

				<?php if($user_id === $profileOwner){ ?>
			
				<?php }else{ ?>
				
				<div class="profile-info-item profile-btn-action">
					<?php $getFromF->isFollowing($sender,$reciver) ?>
				</div>

				<?php } ?>
			</div>
		</div>
	</div>
</section>

<div class="profile-side">
		<div class="profile-side-nav">
			<ul>
				<li id="profilePostLink" <?php if(isset($_GET['postsO']) && $_GET['postsO'] == 1){ echo 'class="active"'; }else if(!isset($_GET['followersO']) && !isset($_GET['followingsO'])){echo 'class="active"'; } ?>>
					<span class="bold"><?php $getFromP->postCount($profileOwner) ?></span>
					<span class="light">Posts</span>
				</li>
				<li id="profileFollowersLink" <?php if(isset($_GET['followersO']) && $_GET['followersO'] == 1){ echo 'class="active"'; } ?>>
					<span class="bold"><?php $getFromF->followersCount($profileOwner) ?></span>
					<span class="light">Followers</span>
				</li>
				<li id="profileFollowingsLink" <?php if(isset($_GET['followingsO']) && $_GET['followingsO'] == 1){ echo 'class="active"'; } ?>>
					<span class="bold"><?php $getFromF->followingsCount($profileOwner) ?></span>
					<span class="light">Followings</span>
				</li>
			</ul>
		</div>
		

		<!-- Post profile -->
		<div class="profile-content">
			<?php 
				if(isset($_GET['postsO']) && $_GET['postsO'] == 1){
					include 'includes/profile_posts_inc.php';
				}else if(!isset($_GET['followersO']) && !isset($_GET['followingsO'])){
					include 'includes/profile_posts_inc.php';
				}

				if(isset($_GET['followingsO']) && $_GET['followingsO'] == 1){
					include 'includes/profile_followings_inc.php';
				}

				if(isset($_GET['followersO']) && $_GET['followersO'] == 1){
					include 'includes/profile_followers_inc.php';
				}
			?>
		</div>
		<!-- / -->
</div>

 
<?php include BASE_URL.'/includes/footer.php'; ?>