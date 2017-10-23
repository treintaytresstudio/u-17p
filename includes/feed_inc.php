<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/u-17p/core/init.php';
	$user_id = $_SESSION['user_id'];
	//Llamamos los posts del usuario 
	$getFromP->feedPosts($user_id);
?>
