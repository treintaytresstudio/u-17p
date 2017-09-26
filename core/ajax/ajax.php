<?php 
    include '../init.php';

    //Seguir usuario
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'followUser'){
        
        $sender = $_POST['sender'];
        $reciver = $_POST['reciver'];

        if(isset($_POST['sender']) && !empty($_POST['sender']) && isset($_POST['reciver']) && !empty($_POST['reciver'])){
            //Seguimos usuario
            $follow = $getFromF->follow($sender, $reciver);
        }else{
            //Hubo un error
            echo 0;
        }    
        
    }

    //Dejar de seguir usuario
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'unFollowUser'){
        
        $sender = $_POST['sender'];
        $reciver = $_POST['reciver'];

        if(isset($_POST['sender']) && !empty($_POST['sender']) && isset($_POST['reciver']) && !empty($_POST['reciver'])){
            //Dejamos de seguir usuario
            $follow = $getFromF->unFollow($sender, $reciver);
        }else{
            //Hubo un error
            echo 0;
        }    
        
    }

    //Seguir hashtag
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'followHashtag'){
        
        $user_id = $_POST['user_id'];
        $hashtag_name = $_POST['hashtag_name'];

        if(isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['hashtag_name']) && !empty($_POST['hashtag_name'])){
            //Seguimos usuario
            $followHashtag = $getFromH->followHashtag($user_id, $hashtag_name);
        }else{
            //Hubo un error
            echo 0;
        }    
        
    }

    //Dejar de seguir hashtag
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'unFollowHashtag'){
        
        $user_id = $_POST['user_id'];
        $hashtag_name = $_POST['hashtag_name'];

        if(isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['hashtag_name']) && !empty($_POST['hashtag_name'])){
            //Seguimos usuario
            $unFollowHashtag = $getFromH->unFollowHashtag($user_id, $hashtag_name);
        }else{
            //Hubo un error
            echo 0;
        }    
        
    }


    //Post nuevo
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'newPost'){

        $user_id = $_POST['user_id'];
        $post_caption = $_POST['post_caption'];
        $post_image = $_POST['post_image'];

        if(isset($_POST['post_caption']) && !empty($_POST['post_caption'])){
            //Creamos post
            $post = $getFromP->newPost($user_id, $post_caption, $post_image);
        }else{
            //El caption viene vacío y regresamos un error para que lo llenen
            echo 0;
        }    
        
    }

    //Borrar post
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'deletePost'){
        //Recibimos el post
        $post_id = $_POST['post_id'];
        //Borramos el post
        $post = $getFromP->deletePost($post_id);
    }

    //Buscar usuario
    if(isset($_POST['search']) && !empty($_POST['search'])){
        $search = $getFromU->checkInput($_POST['search']);
        $result = $getFromU->search($search);
        
        if(!empty($result)){
            echo '<div class="menu-search-result"><ul>';
            foreach($result as $user){
                echo '<li>'.
                '<div class="avatar" style="background: url('.$user->profileImage.');"></div>'.
                '<a href="profile.php?username='.$user->username.'">'.$user->screenName.'</a>'.
                '</li>';
            }
            echo '</ul></div>';
        }

    }
    
    //Cambiar foto de perfil del usuario
    if(isset($_GET['operacion']) && $_GET['operacion'] === "updateProfileImage"){
        $user_id = $_GET['user_id'];
        $imagen = $_GET['imagen'];
        $getFromU->updateProfileImage($user_id,$imagen);
    }

    //Cambiar foto de cover del usuario
    if(isset($_GET['operacion']) && $_GET['operacion'] === "updateCoverImage"){
        $user_id = $_GET['user_id'];
        $imagen = $_GET['imagen'];
        $getFromU->updateCoverImage($user_id,$imagen);
    }

    //Actualizar datos del usuario
    if(isset($_GET['operacion']) && $_GET['operacion'] === "updateSettings"){
        $user_id = $_GET['user_id'];
        $screenName = $_GET['screenName'];
        $username = $_GET['username'];
        $bio = $_GET['bio'];
        $country= $_GET['country'];

        //Verifica si no se modifico el username
        $checkMyUsername = $getFromU->checkMyUserName($user_id);

        //Verifica si el usuario está disponible
        $checkUserName = $getFromU->checkUserName($username);

        //Si el usuario está disponible o el usuario es el actual, entonces insertamos en la base de datos no los nuevos datos
        if($checkUserName === true or $checkMyUsername === $username){
            $getFromU->updateSettings($user_id, $screenName, $bio, $country ,$username);
            echo 1;
        }else{
            echo 0;
        }
    }

    //Verificar si el # del nuevo post existe o no, si no existe lo insertamos en la base de datos
    if(isset($_POST['operacion']) && $_POST['operacion'] === "captionHashtag"){
        $hashtag_name = $_POST['hashtag_name'];
        $post_id = $_POST['post_id'];
        $getFromH->captionHashtag($hashtag_name, $post_id);
    }

?>

