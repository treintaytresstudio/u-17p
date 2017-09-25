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
    <!-- main style -->
    <link rel="stylesheet" href="assets/css/33-style.css">
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

<header class="menu">
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
            <li><a href="home.php"><i class="material-icons">home</i></a></li>
            <li><a href="explore.php"><i class="material-icons">public</i></a></li>
            <li><a href="#"><i class="material-icons">notifications</i></a></li>
            <li class="menu-user">
                <div class="menu-avatar avatar" style="background: url(<?php echo $user->profileImage; ?>);"></div>
                <div class="btn-group">
                    <button type="button" class="btn btn-menu-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $user->screenName; ?>
                    </button>
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

