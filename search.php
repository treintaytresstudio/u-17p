<?php 
    include 'core/init.php';
    include 'includes/header.php'; 
    $user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);

    if($getFromU->loggedIn() === true){
        include BASE_URL.'/includes/header.php';
    }else{
        header('Location: index.php');
    }
    

?>