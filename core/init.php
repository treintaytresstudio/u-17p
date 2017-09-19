<?php
    include 'database/connection.php';
    include 'classes/user.php';
    include 'classes/post.php';
    include 'classes/follow.php';

    global $pdo;

    session_start();

    $getFromU = new User($pdo);
    $getFromP = new Post($pdo);
   

    define("BASE_URL", $_SERVER['DOCUMENT_ROOT']."/uphp/ultra/");
?>