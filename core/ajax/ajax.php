<?php 
    include '../init.php';

    //Login
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'login'){
        $email = $_POST['email'];
        $password = $_POST['password'];


        if(!empty($email) or !empty($password)){
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo 100;
            }else{
                if($getFromU->login($email, $password) === false){
                    //Si el correo o la contraseña estan mal entonces
                    echo 200;
                }
            }
        }else{
            //el correo o la contraseña o ambos están vacíos
            echo 300;
        }
    }

    //Registro
    if(isset($_POST['operacion']) && $_POST['operacion'] === 'register'){
        $screenName = $_POST['screenName'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        if(empty($screenName)){
            echo 5;
        }else if(empty($email)){
            echo 6;
        }else if(empty($password)){
            echo 7;
        }else if(empty($username)){
            echo 8;
        }else{
            $email = $getFromU->checkInput($email);
            $screenName = $getFromU->checkInput($screenName);
            $password = $getFromU->checkInput($password);
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                //Si el correo no tiene un formato válido
                echo 100;
            }else if(strlen($screenName)>20){
                //El nombre debe de estar entre 6 y 20 caracteres
                echo 600;
            }else if(strlen($password)< 5){
                //La contraseña debe ser mayor a 5 caracteres
                echo 700;
            }else{
                if($getFromU->checkEmail($email) === true){
                    //El correo ya está en uso
                    echo 800;
                }else if($getFromU->checkUserName($username) === false){
                    //El usuario ya está en uso
                    echo 900;
                }else{
                    $getFromU->registerUser($email, $screenName, $password, $username);
                   
                }
            }
        }

    }


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
            if(empty($post_image)) {
                //La imagen viene vacía
                echo 400;
            }else{
                //Creamos post
                $post = $getFromP->newPost($user_id, $post_caption, $post_image);
            }
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

        echo 'estoy en ajax';
    }

    //Buscar usuario
    if(isset($_POST['search']) && !empty($_POST['search'])){
        $search = $getFromU->checkInput($_POST['search']);
        $result = $getFromU->search($search);
        
        if(!empty($result)){
            echo '<div class="menu-search-result"><ul>';
            foreach($result as $r){
                if($r->username == ''){
                    echo '<li>'.
                '<span>#'.$r->name.'</span>'.
                '</li>';
            }else{
                echo '<li>'.
                '<span>user'.$r->name.'</span>'.
                '</li>';
                
            }
            echo '</ul></div>';
            }
        }

    }
    /*
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
    */

    //Buscar hashtags
    if(isset($_POST['searchExplore']) && !empty($_POST['searchExplore'])){
        $searchExplore = $getFromU->checkInput($_POST['searchExplore']);
        $result = $getFromH->searchHashtags($searchExplore);
        
        if($result){
            foreach($result as $hashtag){
                $post_id = $hashtag->post_id;
                $getFromP->printPost($post_id);
            }
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

