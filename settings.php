<?php 
    include 'core/init.php';
    $user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);

    if($getFromU->loggedIn() === true){
        include BASE_URL.'/includes/header.php';
    }else{
        header('Location: index.php');
    }

    $responseUserName = null;
    
?>

<div class="not-update hide animated fadeIn">
    <span>Your account has updated successfully</span>
</div>

<div class="not-user-update hide animated fadeIn">
    <span>Ther username has updated successfully</span>
</div>
<div class="container-center">

<div class="settings">
    <h1>Account settings</h1>
    <form class="form" id="settingsForm" data-user="<?php echo $user->user_id; ?>">
        <div class="form-item">
            <label for="username">Name</label>
            <input class="form-control input-accent" type="text" id="settingsScreenName" name="screenName" value="<?php echo $user->screenName; ?>">
        </div>
        <div class="form-item">
            <label for="username">Email</label>
            <input class="form-control input-accent" readonly type="text" id="settingsEmail" name="email" value="<?php echo $user->email; ?>">
            <small>If you need change this email, please contact us on support@ultra.com</small>
        </div>
        <div class="form-item">
            <label for="username">Username</label>
            <input class="form-control input-accent" type="text" id="settingsUsername" name="username" value="<?php echo $user->username; ?>">
            <span class="settings-response-username"></span>
        </div>
        <div class="form-item">
            <label for="exampleFormControlTextarea1">Bio</label>
            <textarea class="form-control input-accent" id="settingsBio" rows="3"><?php echo $user->bio; ?></textarea>
        </div>
        <div class="form-item">
            <label for="country">Country</label>
            <select class="form-control input-accent" id="settingsCountry">
                <option value="<?php echo $user->country; ?>">
                    <?php 
                        if($user->country === '1'){echo 'USA';}
                        else if($user->country === '2'){echo 'México';}
                        else{echo 'Choose your country';}
                    ?>
                </option>
                <?php if($user->country === '1'){ ?>
                    <option value="2">México</option>
                <?php }else if($user->country === '2'){?>
                    <option value="1">USA</option>
                <?php }else{ ?>
                    <option value="1">USA</option>
                    <option value="2">México</option>
                <?php } ?>
                
                
            </select>
        </div>
        <div class="sk-fading-circle hide settings-loader">
          <div class="sk-circle1 sk-circle"></div>
          <div class="sk-circle2 sk-circle"></div>
          <div class="sk-circle3 sk-circle"></div>
          <div class="sk-circle4 sk-circle"></div>
          <div class="sk-circle5 sk-circle"></div>
          <div class="sk-circle6 sk-circle"></div>
          <div class="sk-circle7 sk-circle"></div>
          <div class="sk-circle8 sk-circle"></div>
          <div class="sk-circle9 sk-circle"></div>
          <div class="sk-circle10 sk-circle"></div>
          <div class="sk-circle11 sk-circle"></div>
          <div class="sk-circle12 sk-circle"></div>
        </div>
        <div class="form-item--space">
		    <input type="submit" class="btn btn-primary btn-lg bg-accent" id="settingsBtn" name="signup" value="Update">
		</div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>