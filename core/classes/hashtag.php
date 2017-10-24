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
        //Sacamos el id del hashtag
        $hashtag_id = $this->hashtagId($hashtag_name);

        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM hashtag_post WHERE hashtag_id = :hashtag_id");
        $stmt->bindParam(":hashtag_id", $hashtag_id , PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0){
            $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            foreach($posts as $post){
                
                //Sacamos el id del post
                $post_id = $post->post_id;
                //Llamamos a la función para imprimir el post en post class  
                $postPrint = $this->printPost($post_id);
    
            }
        }else{
            echo $count.' Sorry we cant find post for #'.$hashtag_name;
        }

    }

    //Seguir hashtag
    public function followHashtag($user_id, $hashtag_name){
        //Sacamos el id del hashtag
        $hashtag_id = $this->hashtagId($hashtag_name);

        //Tiempo
        $hashtag_follow_time = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO hashtag_followers (hashtag_id, user_id, hashtag_follow_time) VALUES (:hashtag_id, :user_id, :hashtag_follow_time)");
        $stmt->bindParam(":hashtag_id", $hashtag_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":hashtag_follow_time", $hashtag_follow_time, PDO::PARAM_STR);
        $stmt->execute();
    }

    //Dejar de seguir hashtag
    public function unFollowHashtag($user_id, $hashtag_name){
        //Sacamos el id del hashtag
        $hashtag_id = $this->hashtagId($hashtag_name);

        $stmt = $this->pdo->prepare("DELETE FROM hashtag_followers WHERE hashtag_id = :hashtag_id AND user_id = :user_id");
        $stmt->bindParam(":hashtag_id", $hashtag_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Saber si el usuario lo está siguiendo o no y en base a eso mostramos los botones correspondientes en el perfil
    public function isFollowingHashtag($user_id,$hashtag_name){
        //Sacamos el id del hashtag
        $hashtag_id = $this->hashtagId($hashtag_name);

        $stmt = $this->pdo->prepare("SELECT * FROM hashtag_followers WHERE user_id = :user_id AND hashtag_id = :hashtag_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $stmt->bindParam(":hashtag_id", $hashtag_id, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            echo 
            '<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bg-main" id="unFollowHashtagBtn" data-user-id="'.$user_id.'" data-hashtag-name="'.$hashtag_name.'">'.
                'FOLLOWING <?php echo "#".$hashtag_name; ?>'.
            '</button>';

            '<button style="display:none;" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bg-accent" id="followHashtagBtn" data-user-id="'.$user_id.'" data-hashtag-name="'.$hashtag_name.'">'.
                'FOLLOW <?php echo "#".$hashtag_name; ?>'.
            '</button>';
        }else{
            echo 
            '<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bg-accent" id="followHashtagBtn" data-user-id="'.$user_id.'" data-hashtag-name="'.$hashtag_name.'">'.
                'FOLLOW <?php echo "#".$hashtag_name; ?>'.
            '</button>';

            echo 
            '<button style="display:none;" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bg-main" id="unFollowHashtagBtn" data-user-id="'.$user_id.'" data-hashtag-name="'.$hashtag_name.'">'.
                'FOLLOWING <?php echo "#".$hashtag_name; ?>'.
            '</button>';
        }

    }

    //Obtener los datos del hashtag
    public function getHashtagData($hashtag_id){
        $stmt = $this->pdo->prepare("SELECT * FROM hashtags WHERE  hashtag_id = :hashtag_id");
        $stmt->bindParam(":hashtag_id", $hashtag_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    //Obtener los hashtag a los que el usuario sigue
    public function userHashtags($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM hashtag_followers WHERE user_id = :user_id LIMIT 10");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $hashtags = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($hashtags as $hashtag){
            //Obtenemos el id del hashtag
            $hashtag_id = $hashtag->hashtag_id;
            //Obtenemos los datos del hashtag
            $hd = $this->getHashtagData($hashtag_id);

            echo '<li><a href="hashtag.php?hashtag_name='.$hd->hashtag_name.'">#'.$hd->hashtag_name.'</a></li>';
        }

    }

    //Trending topic Home
    public function trendingUsersHome(){
        $stmt = $this->pdo->prepare("SELECT hashtag_id, COUNT(*) FROM hashtag_post GROUP BY hashtag_id ORDER BY COUNT(*) DESC LIMIT 10");
        $stmt->execute();
        $hashtags = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($hashtags as $hashtag){
            //Sacamos el id del usuario
            $hashtag_id = $hashtag->hashtag_id;
            //Sacamos cuantos posts tiene el hashtag
            $countPost = $this->getHashtagsPostsCount($hashtag_id);
            //Sacamos los datos del usuario
            $hd = $this->getHashtagData($hashtag_id);
            echo '<li><a href="hashtag.php?hashtag_name='.$hd->hashtag_name.'">#'.$hd->hashtag_name.'</a><p>'.$countPost.' Posts</p></li>';
        }
    }

    //Obtenemos el total de posts en el hashtag
    public function getHashtagsPostsCount($hashtag_id){
        $stmt = $this->pdo->prepare("SELECT * FROM hashtag_post WHERE hashtag_id = :hashtag_id");
        $stmt->bindParam(":hashtag_id",$hashtag_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }

    public function randomColor(){
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    //Trending topic Explore
    public function trendingHashtagsExplore(){
        $stmt = $this->pdo->prepare("SELECT hashtag_id, COUNT(*) FROM hashtag_post GROUP BY hashtag_id ORDER BY COUNT(*) DESC LIMIT 12");
        $stmt->execute();
        $hashtags = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($hashtags as $hashtag){
            //Sacamos el id del usuario
            $hashtag_id = $hashtag->hashtag_id;
            //Sacamos cuantos posts tiene el hashtag
            $countPost = $this->getHashtagsPostsCount($hashtag_id);
            //Sacamos los datos del Hashtag
            $hd = $this->getHashtagData($hashtag_id);
            //Sacamos el cover del hashtag
            $cover = $this->getHashtagTrendCover($hashtag_id);
            
            //Mostramos el cover
            $coverHeader = "url('$cover')";

            //Si no existe cover, entonces generamos un color random
            if($cover === ''){
                $coverHeader = $this->randomColor();
            }

            echo 
            '<!-- explore hashtag item -->'.
            '<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">'.
                '<div class="explore-hashtag-item">'.
                    '<div class="explore-hashtag-item-header" style="background:'.$coverHeader.';"></div>'.
                    '<div class="explore-hashtag-item-info">'.
                        '<h5>#'.$hd->hashtag_name.'</h5>'.
                        '<p>'.$countPost.' Posts</p>'.
                        '<button class="mdl-button mdl-js-button mdl-button--raised">'.
                            'FOLLOW'.
                        '</button>'.
                    '</div>'.
                '</div>'.
            '</div><!-- /explore hashtag item -->';
        }
    }

    //Obtener el último post con foto del hashtag
    public function getHashtagTrendCover($hashtag_id){
        $stmt = $this->pdo->prepare("SELECT posts.post_image, posts.post_id 
        FROM `hashtag_post` 
        INNER JOIN posts 
        ON hashtag_post.post_id = posts.post_id 
        WHERE hashtag_post.hashtag_id = :hashtag_id
        AND posts.post_image IS NOT NULL 
        ORDER BY posts.post_id DESC
        LIMIT 1");
        $stmt->bindParam(":hashtag_id",$hashtag_id,PDO::PARAM_STR);
        $stmt->execute();

        $cover = $stmt->fetch(PDO::FETCH_OBJ);
        return $cover->post_image;
    }


    //Trending topic Home
    public function trendingHashtagsHome(){
        $stmt = $this->pdo->prepare("SELECT hashtag_id, COUNT(*) FROM hashtag_post GROUP BY hashtag_id ORDER BY COUNT(*) DESC LIMIT 9");
        $stmt->execute();
        $hashtags = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($hashtags as $hashtag){
            //Sacamos el id del hashtag
            $hashtag_id = $hashtag->hashtag_id;

            //Sacamos los datos del Hashtag
            $hd = $this->getHashtagData($hashtag_id);
            
            //Sacamos el cover del hashtag
            $cover = $this->getHashtagTrendCover($hashtag_id);
            
            //Mostramos el cover
            $coverHeader = "url('$cover')";

            //Si no existe cover, entonces generamos un color random
            if($cover === ''){
                $coverHeader = $this->randomColor();
            }

            echo 
                '<!-- home trend item -->'.
                '<li style="background:'.$coverHeader.';"></li>'.
                '<!-- /home trend item -->';
        }
    }

   

    //Buscar Hashtags
    public function searchHashtags($searchExplore){
        $searchM = '%'.$searchExplore.'%';
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_caption LIKE ? ORDER BY post_id DESC");
        $stmt->bindParam(1, $searchM, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }


}
?>