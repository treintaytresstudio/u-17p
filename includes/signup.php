<?php
    include '../core/init.php';
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);

    if(isset($_GET['step']) === true &&  empty($_GET['step']) === false){
        if(isset($_POST['next'])){
            $username = $getFromU->checkInput($_POST['username']);

            if(!empty($username)){
                if(strlen($username)>20){
                    $error = "Username must be between in 6-20 chatacters!";
                }else if($getFromU->checkUsername($username) === true){
                    $error = "Username is already taken!";
                }else{
                    //Asignamos el usuario
                    $getFromU->username($user_id, $username);
                    header('Location: signup.php?step=2');
                }
            }
        }
        include '../includes/choose_username.php';
        
    }
?>