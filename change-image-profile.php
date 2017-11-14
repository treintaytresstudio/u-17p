<?php
    $page = 'choose-image-profile';
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
    
<div class="settings change-profile-image">
    <form class="form">
        <div class="form-item settings-pp-wrap">
            <div class="settings-pp avatar" id="image_new" style="background:url(<?php echo $user->profileImage; ?>);"></div>
            <div class="flex-center">
                <h6>Please choose your new profile image</h6>
            </div>
            <div class="flex-center ">
                <input type="hidden" role="uploadcare-uploader" data-user="<?php echo $user->user_id; ?>" name="profileImage" id="profileImage"
                    data-crop="300x300 minimum"
                    data-preview-step="true"
                    data-images-only="true" />
            </div>
        </div>
        <div class="form-item--space">
		      <input type="submit" id="changeImagePhoto" class="btn btn-tw btn-tw-linear bg-accent" value="UPDATE">
		</div>
    </form>
</div>

<?php include BASE_URL.'/includes/footer.php' ?>

<script>
    
    //UPLOAD CARE INFO
    UPLOADCARE_LOCALE = "en";
    UPLOADCARE_TABS = "file facebook instagram";
    UPLOADCARE_PUBLIC_KEY = "16e381e4b3ec66d54756";

    //Mostrar imagen subida
    var image_new = document.getElementById('image_new');
    var widget = uploadcare.Widget('[role=uploadcare-uploader]');
    var button = document.getElementById('changeImagePhoto');
    widget.onUploadComplete(function (fileInfo) {
      //image_new.src = fileInfo.cdnUrl;

      image_new.setAttribute("style", "background:url("+fileInfo.cdnUrl+");");
      button.setAttribute("style","display:block; margin:0 auto;");

    });

</script>
