<?php
    include '../core/init.php';
    $getFromU->logOut();
    if($getFromU->loggedIn() === false){
		  header('Location: ../index.php');
	  }
?>