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
            '<button class="btn btn-primary btn-lg bg-main" id="unFollowBtn" data-reciver="'.$reciver.'" data-sender="'.$sender.'">FOLLOWING</button>'.
            '<button class="btn btn-primary btn-lg bg-accent" id="followBtn" data-reciver="'.$reciver.'" data-sender="'.$sender.'" style="display:none;">FOLLOW</button>';
        }else{
            echo 
            '<button class="btn btn-primary btn-lg bg-accent" id="followBtn" data-reciver="'.$reciver.'" data-sender="'.$sender.'">FOLLOW</button>'.
            '<button class="btn btn-primary btn-lg bg-main" id="unFollowBtn" data-reciver="'.$reciver.'" data-sender="'.$sender.'" style="display:none;">FOLLOWING</button>';
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