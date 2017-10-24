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

<header class="menu" id="menuUser" data-user-id="<?php echo $user->user_id ?>" data-user-screenName="<?php echo $user->screenName?>">
    <div class="menu-left flex-a-center">
        <div class="menu-logo">
            <img src="assets/images/logo.png" alt="">
        </div>
        <div class="menu-search">
            <input type="text" placeholder="Search" id="menu-search">
            <i class="material-icons menu-search-input-icon">search</i>
            <div class="menu-search-result-wrap"></div>
        </div>
    </div>
    <nav>
        <ul>
            <li <?php if(isset($page) && $page == 1){?> class="active" <?php } ?>><a  href="home.php"><i class="material-icons">home</i>Home</a></li>
            <li><a href="explore.php"><i class="material-icons">public</i>Trending</a></li>
            <li><a href="#"><i class="material-icons">notifications</i>Notifications<span id="total_notifications"></span></a></li>
            <li class="menu-user">
                <div class="menu-avatar avatar <?php if(isset($page) && $page == 4){echo "profile-active";}?>" style="background: url(<?php echo $user->profileImage; ?>);"></div>
                <div class="btn-group">
                    <span  class="btn-menu-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo strtok($user->screenName, " "); ?>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button"><a href="profile.php?username=<?php echo $user->username; ?>">Profile</a></button>
                        <button class="dropdown-item" type="button"><a href="change-image-profile.php">New Profile Image</a></button>
                        <button class="dropdown-item" type="button"><a href="change-image-cover.php">New Cover Image</a></button>
                        <button class="dropdown-item" type="button"><a href="settings.php">Settings</a></button>
                        <button class="dropdown-item" type="button"><a href="includes/logout.php">Logout</a></button>
                    </div>
                </div>
            </li>
            <li>
                <button type="button" class="btn btn-primary openNewPost bg-accent">New Post</button>
            </li>
        </ul>
    </nav>
</header>

<?php include 'new-post.php';

