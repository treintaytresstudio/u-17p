<?php

class User 
{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    //Limpia string recibido
    public function checkInput($var){
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripcslashes($var);

        return $var;
    }

    //Iniciar sesión
    public function login($email, $password){
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = :email AND password = :password");
        $passwordHash = md5($password); //Here we created new variable for hash password
        $stmt->bindParam(":email", $email,  PDO::PARAM_STR);
        $stmt->bindParam(":password", $passwordHash, PDO::PARAM_STR); // here we added the hash password variable
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();

        if($count > 0){
            $_SESSION['user_id'] = $user->user_id;
            echo 1;
        }else{
            return false;
        }
    }

    //Regresa datos del usuario
    public function userData($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);

    }

    //Registro de usuario
    public function registerUser($email, $screenName, $password, $username){
        $hashPassword = md5($password);
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password, screenName, profileImage, profileCover,username) VALUES (:email, :password, :screenName, 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png',:username)");
        $stmt->bindParam(":email", $email , PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashPassword , PDO::PARAM_STR);
        $stmt->bindParam(":screenName", $screenName , PDO::PARAM_STR);
        $stmt->bindParam(":username", $username , PDO::PARAM_STR);
        $stmt->execute();

        $user_id = $this->pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        echo 1;
    }

    //Asignamos username
    public function username($user_id, $username){
        $stmt = $this->pdo->prepare("UPDATE users SET username=:username WHERE user_id=:user_id");
        $stmt->bindParam(":username", $username , PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id , PDO::PARAM_STR);
        $stmt->execute();
    }

    //Actualizamos los datos del usuario
    public function updateSettings($user_id, $screenName, $bio, $country ,$username){
        $stmt = $this->pdo->prepare("UPDATE users SET screenName=:screenName, bio=:bio, country=:country, username=:username WHERE user_id=:user_id");
        $stmt->bindParam(":user_id", $user_id , PDO::PARAM_STR);
        $stmt->bindParam(":screenName", $screenName , PDO::PARAM_STR);
        $stmt->bindParam(":bio", $bio , PDO::PARAM_STR);
        $stmt->bindParam(":country", $country , PDO::PARAM_STR);
        $stmt->bindParam(":username", $username , PDO::PARAM_STR);
        $stmt->execute();
    }

    //Actualizamos la foto de perfil
    public function updateProfileImage($user_id, $imagen){
        $stmt = $this->pdo->prepare("UPDATE users SET profileImage=:profileImage WHERE user_id=:user_id");
        $stmt->bindParam(":profileImage", $imagen , PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id , PDO::PARAM_STR);
        $stmt->execute();
    }

    //Actualizamos la foto de cover
    public function updateCoverImage($user_id, $imagen){
        $stmt = $this->pdo->prepare("UPDATE users SET profileCover=:profileCover WHERE user_id=:user_id");
        $stmt->bindParam(":profileCover", $imagen , PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id , PDO::PARAM_STR);
        $stmt->execute();
    }

    //Cerrar sesión
    public function logOut(){
        $_SESSION = array();
        session_destroy();
        header('Location: '.BASE_URL.'index.php');
    }

    //Se asegura que el email no esté en uso
    public function checkEmail($email){
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    //Verificar si es mi username actual
    public function checkMyUserName($user_id){
        
        $stmt = $this->pdo->prepare("SELECT username FROM users WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->username;
    }

    //Se asegura que el username no esté en uso
    public function checkUserName($username){

        $stmt = $this->pdo->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0){
            //el usuario ya está en uso
            return false;
        }else{
            //el usuario si está disponible
            return true;
        }
    }

    //Sacar el id del usuario según el username
    public function userIdByUsername($username){
        $stmt = $this->pdo->prepare(" SELECT user_id FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username , PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->user_id;
    }

    //Sacar el id del usuario según el screenName
    public function userIdByscreenName($screenName){
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE screenName = :screenName");
        $stmt->bindParam(":screenName", $screenName , PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->user_id;
    }

    //Sabemos si el usuario está logueado o no
    public function loggedIn(){
        return (isset($_SESSION['user_id'])) ? true : false;
    }

    //Buscar usuarios
    public function search($search){
        $searchM = $search.'%';
        $stmt = $this->pdo->prepare("(SELECT t_search, screenName as name FROM users
        WHERE screenName LIKE ?)
        UNION
        (SELECT t_search,  hashtag_name AS name  FROM hashtags
        WHERE hashtag_name LIKE ?)");
        $stmt->bindParam(1, $searchM, PDO::PARAM_STR);
        $stmt->bindParam(2, $searchM, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //Trending users
    public function trendingUsers(){
        $stmt = $this->pdo->prepare("SELECT reciver, COUNT(*) FROM follow GROUP BY reciver ORDER BY COUNT(*) DESC");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($users as $user){
            //Sacamos el id del usuario
            $user_id = $user->reciver;
            //Sacamos los datos del usuario
            $userData = $this->userData($user_id);

            echo '<li><a href="profile.php?username='.$userData->username.'"><span class="avatar" style="background:url('.$userData->profileImage.');"></span></a></li>';

        }
    }

    //Followings home
    public function getFollowingsList($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :sender LIMIT 10");
        $stmt->bindParam(":sender", $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($users as $user){
            //Sacamos el id del usuario
            $user_id = $user->reciver;
            //Sacamos los datos del usuario
            $userData = $this->userData($user_id);

            echo'<li class="list-tw-item">
                    <span class="avatar"style="background:url('.$userData->profileImage.');"></span>
                    <div class="list-tw-item-right">
                        <div class="list-tw-item-top">
                            <a href="profile.php?username='.$userData->username.'"><span class="name-list">'.$userData->screenName.'</span></a>
                            <button id="menu-for'.$userData->user_id.'"
                                    class="mdl-button mdl-js-button mdl-button--icon">
                              <i class="material-icons">more_vert</i>
                            </button>

                            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                for="menu-for'.$userData->user_id.'">
                              <li class="mdl-menu__item">Report</li>
                            </ul>
                        </div>'.
                        $sender = $sender = $_SESSION['user_id'];
                        $reciver = $userData->user_id;
                        Follow::isFollowing($sender,$reciver);
                        
                        '<div class="list-btns">
                            <span class="btn btn-tw btn-tw-linear">Following</span>
                        </div>
                    </div>
                </li>';

        }

    }

    //Trending users home 
    public function suggestedUsersHome($user_id){
        $stmt = $this->pdo->prepare("SELECT reciver, COUNT(*) FROM follow WHERE NOT reciver = :reciver GROUP BY reciver ORDER BY COUNT(*) DESC LIMIT 9");
        $stmt->bindParam(":reciver", $user_id , PDO::PARAM_STR);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($users as $user){
            //Sacamos el id del usuario
            $user_id = $user->reciver;
            //Sacamos los datos del usuario
            $userData = $this->userData($user_id);
            echo '<li><a href="profile.php?username='.$userData->username.'"><div class="avatar" style="background:url('.$userData->profileImage.');"></div></a></li>';
        }
    }

    //Foto de cover
    public function getCoverProfile($user_id){
        $stmt = $this->pdo->prepare("SELECT posts.post_image, posts.post_id , posts.post_user
        FROM posts 
        INNER JOIN users 
        ON posts.post_user = users.user_id 
        WHERE posts.post_user= :user_id
        AND posts.post_image IS NOT NULL 
        ORDER BY posts.post_id DESC
        LIMIT 1");
        $stmt->bindParam(":user_id",$user_id,PDO::PARAM_STR);
        $stmt->execute();

        $cover = $stmt->fetch(PDO::FETCH_OBJ);
        return $cover->post_image;
    }

    
}

?>