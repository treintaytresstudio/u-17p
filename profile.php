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
	<div class="profile" style="background:url(<?php echo $profileData->profileCover; ?>);">
		<div class="profile-wrap">
			<div class="profile-info">
				<div class="profile-info-item flex-a-center">
					<div class="profile-info-pp">
						<div class="avatar" style="background:url(<?php echo $profileData->profileImage; ?>);"></div>
					</div>
					<div class="profile-info-user">
						<h2><?php echo $profileData->screenName; ?></h2>
						<p class="profile-username">@<?php echo $profileData->username; ?></p>
						<p class="profile-bio"><?php echo $profileData->bio; ?></p>
					</div>
				</div>

				<div class="profile-info-item">
					<div class="profile-numbers-user">
						<span>Followers </span><?php $getFromF->followersCount($reciver) ?>
						<span>Followings </span><?php $getFromF->followingsCount($reciver) ?>
						<span>Posts </span><?php $getFromP->postCount($reciver) ?>
					</div>
				</div>

				<?php if($user_id === $profileOwner){ ?>
				<div class="profile-info-item profile-btn-action">
					<a href="settings.php">
					<button class="btn btn-primary btn-lg bg-accent">SETTINGS</button>
					</a>
				</div>
				<?php }else{ ?>
				<div class="profile-info-item profile-btn-action">
					<?php $getFromF->isFollowing($sender,$reciver) ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>

</section>

 
<?php include BASE_URL.'/includes/footer.php'; ?>