<?php 
    include '../init.php';

    //Post nuevo
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'newPost'){

        $user_id = $_POST['user_id'];
        $post_caption = $_POST['post_caption'];
        $post_image = $_POST['post_image'];

        //Creamos post
        $post = $getFromP->newPost($user_id, $post_caption, $post_image);
        
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
                '<a href="'.$user->username.'">'.$user->screenName.'</a>'.
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


?>

