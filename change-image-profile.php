<?php
    $page = 'choose-image-profile';
    include 'core/init.php';
    //Usuario nuevo

    if(isset($_GET['new_user'])){
        $new_user = $_GET['new_user'];
    }
    
    $user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);
	if($getFromU->loggedIn() === true){
		include BASE_URL.'/includes/header.php';
	}else{
		header('Location: index.php');
	}
    
?>

<div class="full">
    
<div class="settings change-profile-image">
    <form class="form">
        <div class="form-item settings-pp-wrap">
            <div class="settings-pp avatar" id="image_new" style="background:url(<?php echo $user->profileImage; ?>);"></div>
            <div class="flex-center" id="text-help-change-image">
                <h6>Please choose your new profile image</h6>
            </div>
            <div class="flex-center ">
                <input type="hidden" role="uploadcare-uploader2" data-user="<?php echo $user->user_id; ?>" name="profileImage" id="profileImage"
                    data-crop="300x300 minimum"
                    data-preview-step="true"
                    data-images-only="true" />
            </div>
        </div>
        <div class="form-item--space">
		      <input type="submit" id="changeImagePhoto" class="btn btn-tw btn-tw-linear bg-accent" value="UPDATE">
            
              <?php if(isset($new_user) && $new_user == 1){ ?>
              <a href="stream.php?new_user=1" id="slikpChangeImagePhoto" class="btn btn-tw btn-tw-linear">SKIP</a>
              <?php } ?>

		</div>
    </form>
    <?php if(isset($new_user) && $new_user == 1){ ?>
    <div id="tutorial-photo" class="tutorial-welcome-change-profile-image animated bounce">
        <span>Here you can change yur profile image</span>
    </div>
    <?php } ?>
</div>

<?php include BASE_URL.'/includes/footer.php' ?>


