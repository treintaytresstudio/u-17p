<?php

class Hashtag extends Post
{
    
    function __construct($pdo){
        $this->pdo = $pdo;
    }

    //Verifica si el hashtag existe o no en la base de datos
    public function captionHashtag($hashtag_name, $post_id){
        $stmt = $this->pdo->prepare("SELECT hashtag_name FROM hashtags WHERE hashtag_name = :hashtag_name ");
        $stmt->bindParam(":hashtag_name", $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            //Si el hashtag ya existe entonces
            //LLamamos a la función para insertar el post en el hashtag
            $this->insertPostInHashtag($hashtag_name, $post_id);
        }else{ 
            //Si el hashtag no existe entonces
            //LLamamos a la función para crear el hashtag
            $this->createHashtag($hashtag_name, $post_id);
        }
    }

    //Crea el hashtag dentro de la base de datos
    public function createHashtag($hashtag_name, $post_id){
        $stmt = $this->pdo->prepare("INSERT INTO hashtags (hashtag_name) VALUES (:hashtag_name)");
        $stmt->bindParam(":hashtag_name", $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();

        //Llamamos a la función para insertar el post en el hashtag
        $this->insertPostInHashtag($hashtag_name, $post_id);
      
    }

    //Inserta el post en el hashtag correspondiente
    public function insertPostInHashtag($hashtag_name, $post_id){

        //Traemos el id del hashtag
        $hashtag_id = $this->hashtagId($hashtag_name);

        $stmt = $this->pdo->prepare("INSERT INTO hashtag_post (hashtag_id, post_id) VALUES (:hashtag_id, :post_id)");
        $stmt->bindParam(":hashtag_id" ,$hashtag_id , PDO::PARAM_STR);
        $stmt->bindParam(":post_id" ,$post_id , PDO::PARAM_STR);
        $stmt->execute();

        //$error = $stmt->errorInfo();
        //var_dump($error);
    }

    //Retornamos el id del hashtag
    public function hashtagId($hashtag_name){
        $stmt = $this->pdo->prepare("SELECT * FROM hashtags WHERE hashtag_name = :hashtag_name");
        $stmt->bindParam(":hashtag_name", $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();

        $hashtag = $stmt->fetch(PDO::FETCH_OBJ);
        return $hashtag->hashtag_id;
    }

    //Mostramos todos los posts pertenecientes al Hashtag
    public function postsHashtag($hashtag_name){
        
        $hashtag_id = $this->hashtagId($hashtag_name);

        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM hashtag_post WHERE hashtag_id = :hashtag_id");
        $stmt->bindParam(":hashtag_id", $hashtag_id , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($posts as $post){
            
            //Sacamos el id del post
            $post_id = $post->post_id;
            //Llamamos a la función para imprimir el post en post class  
            $postPrint = $this->printPost($post_id);

        }

    }


}
?>