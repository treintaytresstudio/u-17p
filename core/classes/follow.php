<?php

class Follow extends User{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    //Seguir usuario
    public function follow($sender, $reciver){
        //Registramos el tiempo
        $time = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO follow (sender, reciver, follow_time) VALUES (:sender,:reciver,:follow_time)");
        $stmt->bindParam(":sender", $sender, PDO::PARAM_STR);
        $stmt->bindParam(":reciver", $reciver, PDO::PARAM_STR);
        $stmt->bindParam(":follow_time", $time, PDO::PARAM_STR);
        $stmt->execute();

    }

    //Dejar de seguir usuario
    public function unFollow($sender, $reciver){
        $stmt = $this->pdo->prepare("DELETE FROM follow WHERE sender = :sender AND reciver = :reciver");
        $stmt->bindParam(":sender", $sender, PDO::PARAM_STR);
        $stmt->bindParam(":reciver", $reciver, PDO::PARAM_STR);
        $stmt->execute();

    }

    //Saber si el usuario lo está siguiendo o no y en base a eso mostramos los botones correspondientes en el perfil
    public function isFollowing($sender,$reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :sender AND reciver = :reciver");
        $stmt->bindParam(":sender", $sender, PDO::PARAM_STR);
        $stmt->bindParam(":reciver", $reciver, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            echo 
            '<span class="btn btn-tw btn-tw-linear unFollowBtn" data-reciver="'.$reciver.'" data-sender="'.$sender.'" id="unFB'.$reciver.'">FOLLOWING</span>'.
            '<span class="btn btn-tw btn-tw-linear bg-accent followBtn"  data-reciver="'.$reciver.'" data-sender="'.$sender.'" style="display:none;" id="fB'.$reciver.'">FOLLOW</span>';
        }else{
            echo 
            '<span class="btn btn-tw btn-tw-linear bg-accent followBtn"  data-reciver="'.$reciver.'" data-sender="'.$sender.'" id="fB'.$reciver.'">FOLLOW</span>'.
            '<span class="btn btn-tw btn-tw-linear unFollowBtn"  data-reciver="'.$reciver.'" data-sender="'.$sender.'" style="display:none;" id="unFB'.$reciver.'">FOLLOWING</span>';
        }

    }

    //Followings home
    public function getFollowingsList($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :sender LIMIT 10");
        $stmt->bindParam(":sender", $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($users)){
            echo "<p>List empty</p>";
        }else{
            foreach($users as $user){
                //Sacamos el id del usuario
                $user_id = $user->reciver;
                //Sacamos los datos del usuario
                $userData = $this->userData($user_id);

                $sender = $_SESSION['user_id'];
                $reciver = $userData->user_id;

                echo'<li class="list-tw-item">
                        <span class="avatar"style="background:url('.$userData->profileImage.');"></span>
                        <div class="list-tw-item-right">
                            <div class="list-tw-item-top">
                                <a href="profile.php?username='.$userData->username.'"><span class="name-list">'.$userData->screenName.'</span></a>
                            </div>
                            <div class="list-btns">';
                                $this->isFollowing($sender,$reciver);
                            '</div>                   
                        </div>
                    </li>';

            }
        }

    }

    //Followers list
    public function getFollowersList($reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE reciver = :reciver LIMIT 10");
        $stmt->bindParam(":reciver", $reciver, PDO::PARAM_STR);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($users)){
            echo "<p>List empty</p>";
        }else{
            foreach($users as $user){
                //Sacamos el id del usuario
                $user_id = $user->sender;
                //Sacamos los datos del usuario
                $userData = $this->userData($user_id);

                $sender = $_SESSION['user_id'];
                $reciver = $userData->user_id;

                echo'<li class="list-tw-item">
                        <span class="avatar"style="background:url('.$userData->profileImage.');"></span>
                        <div class="list-tw-item-right">
                            <div class="list-tw-item-top">
                                <a href="profile.php?username='.$userData->username.'"><span class="name-list">'.$userData->screenName.'</span></a>
                            </div>
                            <div class="list-btns">';
                               $this->isFollowing($sender,$reciver);
                            '</div>                   
                        </div>
                    </li>';

            }
        }

    }

    //Retorna el número de followers
    public function followersCount($reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE reciver = :reciver");
        $stmt->bindParam(":reciver", $reciver , PDO::PARAM_STR);
        $stmt->execute();

        $followers = $stmt->rowCount();

        echo $followers;
    }

    //Retorna el número de followings
    public function followingsCount($reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :reciver");
        $stmt->bindParam(":reciver", $reciver , PDO::PARAM_STR);
        $stmt->execute();

        $followings = $stmt->rowCount();

        echo $followings;
    }

}

?>