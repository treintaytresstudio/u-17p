<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- material design icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <!-- MDL -->
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <!-- animate -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="assets/css/33-style.css">
    <!-- firebase js -->
    <script src="https://www.gstatic.com/firebasejs/4.4.0/firebase.js"></script>
    <script src="../u-17p/core/js/firebase.js"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <!-- lazy load -->
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>

    <title>Ultra</title>

</head>
<body>


<!-- fondo de acciones -->
<div class="bg-action"></div>

<!-- confirmación eliminar post -->
<div class="box-confirm-wrap boxConfirmDeletePost">
    <div class="box-confirm">
        <h4>Are you sure to delete this post?</h4>

        <ul>
            <li><button class="btn bg-main cancellDeletePost" id="cancellDeletePost">Cancell</button></li>
            <li><button class="btn btn-danger confirmDeletePost" >Confirm</button></li>
        </ul>
    </div>
</div>

<header class="menu-top" id="menuUser" data-user-id="<?php echo $user->user_id; ?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <div class="logo">
                    <a href="home.php">
                        <img src="assets/images/logo-black.png" alt="">
                    </a>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-6 menu-top-middle">
                <div class="menu-top-search">
                    <input type="text" placeholder="Search" class="input-search">
                    <i class="material-icons menu-search-input-icon">search</i>
                    <div class="menu-search-result-wrap">
                        <ul class="menu-top-result-list"></ul>
                    </div>
                    
                </div>
                <div class="menu-top-icons">
                    <a href="stream.php">
                       <i class="material-icons <?php if($page === 'stream'){echo "active-menu-top";}?>">public</i>
                   </a>

                   <i class="material-icons">notifications_none</i>
                </div>
                <div class="menu-top-actions">
                        <div class="menu-top-avatar avatar <?php if(isset($page) && $page == 4){echo "profile-active";}?>" style="background: url(<?php echo $user->profileImage; ?>);"></div>

                        <button id="menu-top-user"
                                class="mdl-button mdl-js-button mdl-button--icon">
                          <i class="material-icons">arrow_drop_down</i>
                        </button>

                        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                            for="menu-top-user"">
                          <a href="profile.php?username=<?php echo $user->username;?>">
                            <li class="mdl-menu__item">My Profile</li>
                          </a>
                          <a href="change-image-profile.php">
                            <li class="mdl-menu__item">Change Profile Image</li>
                          </a>
                          <a href="includes/logout.php">
                            <li class="mdl-menu__item">Exit</li>
                          </a>
                        </ul>
                </div>
                    
            </div>
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 menu-top-buttons">
                <a href="settings.php" class="btn btn-tw btn-tw-linear">Settings</a>
                <span class="btn btn-tw btn-tw-linear bg-accent openNewPost">New post</span>
                <?php
                 $postCount = $getFromP->postCountTut($user_id);
                 if($postCount == 0){ 
                ?>
                <div class="tutorial-welcome-post animated bounce">
                    <span>Here you can create your first post</span>
                    <span id="tutorial-welcome-post-close" style="display: block; margin-top: 5px; width: 80px; color:#fff; font-weight: bold; font-size: 16px; cursor: pointer;">Close</span>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    
</header>

<div class="new-post-container">
    <?php include 'new-post.php';  ?> 
</div>

