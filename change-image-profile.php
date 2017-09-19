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

<div class="full">
    
<div class="settings">
    <form class="form">
        <div class="form-item settings-pp-wrap">
            <div class="settings-pp avatar" style="background:url(<?php echo $user->profileImage; ?>);"></div>
            <div class="flex-center">
                <h6>Please choose your new profile image</h6>
            </div>
            <div class="flex-center">
                <input type="hidden" role="uploadcare-uploader" data-user="<?php echo $user->user_id; ?>" name="profileImage" id="profileImage"
                    data-crop="300x300 minimum"
                    data-preview-step="true"
                    data-images-only="true" />
            </div>
        </div>
        <div class="form-item--space">
		    <input type="submit" id="changeImagePhoto" class="btn btn-primary btn-block btn-lg bg-accent" name="signup" value="UPDATE">
		</div>
    </form>
</div>


<?php include BASE_URL.'/includes/footer.php' ?>
