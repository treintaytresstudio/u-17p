<?php

class Post extends User
{
    
    function __construct($pdo){
        $this->pdo = $pdo;
    }

    //Creamos un nuevo post
    public function newPost($user_id,$post_caption,$post_image){

        $time = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO posts (post_user, post_caption, post_image, post_time) VALUES (:post_user,:post_caption,:post_image, :post_time)");
        $stmt->bindParam(":post_user", $user_id,PDO::PARAM_STR);
        $stmt->bindParam(":post_caption", $post_caption,PDO::PARAM_STR);
        $stmt->bindParam(":post_image", $post_image,PDO::PARAM_STR);
        $stmt->bindParam(":post_time", $time,PDO::PARAM_STR);
        $stmt->execute();

        $post_id = $this->pdo->lastInsertId();
        echo $post_id;

    }


    //Mostramos un post
    public function printPost($post_id, $user_connected){
        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
        $stmt->bindParam(":post_id", $post_id , PDO::PARAM_STR);
        $stmt->execute();

        $postData = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($postData as $post){

            $user_id = $post->post_user;
            $user = $this->userData($user_id); 

            echo '<!-- post -->'.
            '<div class="post" id="'.$post->post_id.'">';
                if(!empty($post->post_image)){
                    echo'<a href="post.php?post_open=1&id='.$post->post_id.'">'.
                        '<img class="post-image lazyload animated fadeIn" src="assets/images/load.gif" data-src="'.$post->post_image.'">'.
                        '</a>';

                }
                echo'<div class="post-content">'.
					'<div class="post-content-user">'.
						'<div class="avatar" style="background:url('.$user->profileImage.');"></div>'.
                        '<a href="profile.php?username='.$user->username.'">'.$user->screenName.
                            '<span>'.$this->timeAgo($post->post_time).'</span>'.
                        '</a>'.           
                    '</div>'.
                    '<div class="post-caption">'.
                        '<p class="post-caption-text">'.$this->getPostLinks($post->post_caption).'</p>'.
                    '</div>'.
                    '<div class="post-likes-users">'.
                        '<ul>'.
                            '<li><div class="avatar" style="background:url('.$user->profileImage.');"></div></li>'.
                            '<li><div class="avatar" style="background:url('.$user->profileImage.');"></div></li>'.
                            '<li><div class="avatar" style="background:url('.$user->profileImage.');"></div></li>'.
                            '<li><div class="avatar" style="background:url('.$user->profileImage.');"></div></li>'.
                            '<li><div class="avatar" style="background:url('.$user->profileImage.');"></div></li>'.
                            '<li><span>People who likes this post</span></li>'.    
                        '</ul>'.
                    '</div>'.
                    '<div class="post-liked" data-post-id="'.$post->post_id.'">'.
                    '</div>'.
                    '<div class="post-actions">'.
                        '<ul class="post-actions-items">'.
                            '<li>
                                <i class="material-icons likePost" id="'.$post->post_id.'l" data-post-id="'.$post->post_id.'">favorite_border</i>
                                <i class="material-icons unLikePost" id="'.$post->post_id.'u" data-post-id="'.$post->post_id.'">favorite</i>
                                <span id="'.$post->post_id.'likew">Like</span></li>'.
                            '<li><a href="post.php?post_open=1&id='.$post->post_id.'"><i class="material-icons">chat_bubble_outline</i><span> Comment</span></a></li>'.
                        '</ul>'.
                        '<button id="demo-menu-lower-right'.$post->post_id.'"'.
                        'class="mdl-button mdl-js-button mdl-button--icon">'.
                        '<i class="material-icons">more_vert</i>'.
                        '</button>'.
                        '<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"'.
                            'for="demo-menu-lower-right'.$post->post_id.'">';
                        if($user_connected === $post->post_user){
                            echo 
                            '<li class="mdl-menu__item deletePost" data-post-id="'.$post->post_id.'">Delete</li>';
                        }else{
                            $reported = $this->reportPostCheck($user_connected, $post->post_id);
                            if($reported > 0){
                                echo '<li class="mdl-menu__item" data-post-id="'.$post->post_id.'">Reported</li>';
                            }else{
                                echo '<li class="mdl-menu__item reportPostBtn" data-post-id="'.$post->post_id.'">Report</li>';   
                            }
                            echo '<li class="mdl-menu__item"><a href="'.BASE_URL.'/post/'.$post->post_id.'">View Post</a></li>';
                        }
                        echo '</ul>'.
                    '</div>';
                    if(isset($_GET['post_open']) && $_GET['post_open'] == 1 ){
                        echo 
                        '<div class="post-comments">'.
                            '<div class="post-comments-wrap">'.
                              '<div class="post-comment-input">'.
                                '<input type="text" placeholder="Enter your comment" id="pcival'.$post->post_id.'">'.
                                '<button class="mdl-button mdl-js-button mdl-button--icon">
                                  <i class="material-icons" id="commentBtn" data-post-id="'.$post->post_id.'">send</i>
                                </button>'.
                              '</div>'.
                            '</div>'.
                            '<div class="post-comments-items-wrap">'.
                                '<ul class="post-comments-items">'.
                                '</ul>'.
                            '</div>'.
                    '</div>';
                    }
            
			echo '</div>'.
			'</div><!-- /post -->'.
            '<script>'.
            'getLikesCount('.$post->post_id.');'.
            'isLiked('.$post->post_id.');'.
            'getComments('.$post->post_id.');'.
            'lazyload();'.
            '</script>';
        }

    }



    //Mostramos un post pura imagen
    public function printPostImage($post_id, $user_connected){
        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
        $stmt->bindParam(":post_id", $post_id , PDO::PARAM_STR);
        $stmt->execute();

        $postData = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($postData as $post){

            $user_id = $post->post_user;
            $user = $this->userData($user_id); 

                if(!empty($post->post_image)){
                    echo'<a href="post.php?post_open=1&id='.$post->post_id.'">'.
                        '<img class="lazyload animated fadeIn" src="assets/images/load.gif" data-src="'.$post->post_image.'">'.
                        '</a>'.
                        '<script>'.
                        'lazyload();'.
                        '</script>';
                }
                
        }

    }

    //Mostramos un post para post de hashtags
    public function printPostImageHashtag($post_id, $user_connected){
        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
        $stmt->bindParam(":post_id", $post_id , PDO::PARAM_STR);
        $stmt->execute();

        $postData = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($postData as $post){

            $user_id = $post->post_user;
            $user = $this->userData($user_id); 

                if(!empty($post->post_image)){

                    echo '<div class="box">
                            <a href="post.php?post_open=1&id='.$post->post_id.'">
                            <div data-thumbnail="'.$post->post_image.'" ></div>
                            
                            <div data-image="'.$post->post_image.'" ></div>
                            
                            <div class="thumbnail-caption">
                            <div class="avatar" style="background:url('.$user->profileImage.'); width:50px; height:50px; margin:0 auto; margin-bottom:5px;"></div>
                            '.$user->screenName.' post
                            </div>
                            </a>
                        </div>';
                       
                }
                
        }

    }

    //Mostramos los posts del usuario
    public function posts($user_id){

        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_user = :post_user ORDER BY post_id DESC");
        $stmt->bindParam(":post_user", $user_id , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($posts)){
            echo '<div class="no-post">
                    <img src="assets/images/picture.png" width="50px" style="width:50px !important;" alt="">
                    <p>This user has not post yet</p>
                 </div>';
                
        }else{
            //Si el usuario tiene posts, entonces los mostramos
            foreach($posts as $post){
                //Sacamos el id del post
                $post_id = $post->post_id;
                //Llamamos a la función para imprimir el post
                $postPrint = $this->printPostImage($post_id, $user_id);
            }
        }
    }

    //Mostramos el post abierto
    public function post($post_id,$user_id,$post_open){
        $user_connected = $user_id;
        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id ORDER BY post_id DESC");
        $stmt->bindParam(":post_id", $post_id , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($posts as $post){
            //Sacamos el id del post
            $post_id = $post->post_id;
            //Llamamos a la función para imprimir el post
            $postPrint = $this->printPost($post_id,$user_connected);
        }
    }

    //Convertimos #,@ y links en links reales
    public function getPostLinks($post_caption){
        $post_caption = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $post_caption);
        $post_caption = preg_replace("/#([\w]+)/", "<a href='hashtag.php?hashtag_name=$1'>$0</a>", $post_caption);
        $post_caption = preg_replace("/@([\w]+)/", "<a href='profile.php?username=$1'>$0</a>", $post_caption);
        return $post_caption;

    }

    //Eliminamos post
    public function deletePost($post_id){
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE post_id = :post_id");
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
        $stmt->execute();
        echo $post_id;

        //Borrar post de hashtag
        $this->deletePostFromHashtag($post_id);
    }

    public function deletePostFromHashtag($post_id){
        $stmt = $this->pdo->prepare("DELETE FROM hashtag_post WHERE post_id = :post_id");
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    //Retorna el número de post del usuario
    public function postCount($reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_user = :post_user");
        $stmt->bindParam(":post_user", $reciver , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->rowCount();

        echo $posts;
    }
    public function postCountTut($reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_user = :post_user");
        $stmt->bindParam(":post_user", $reciver , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->rowCount();

        return $posts;

    }

    //Mostramos el tiempo en 
    public function timeAgo($time){
        $time = strtotime($time);
        $current = time();
        $seconds = $current - $time;
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $months = round($seconds / 2600640);

        if($seconds <= 60){
            if($seconds == 0){
                return 'now';
            }else{
                return $seconds.'s'.' a go';
            }
        }else if($minutes <= 60){
            return $minutes.'m'.' a go';
        }else if($hours <= 24){
            return $hours.'h'.' a go';
        }else if($months <= 12){
            return date('M j', $time);
        }else{
            return date('j M Y', $time);
        }
    }

    public function streamPosts($user_id){
        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts ORDER BY post_id DESC");
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($posts)){
            echo '<div class="no-post">
                    <img src="assets/images/picture.png" width="50px" style="width:50px !important;" alt="">
                    <p>We dont have any post to show you yet</p>
                 </div>';
                
        }else{
            //Si el usuario tiene posts, entonces los mostramos
            foreach($posts as $post){
                //Sacamos el id del post
                $post_id = $post->post_id;
                //Llamamos a la función para imprimir el post
                $postPrint = $this->printPost($post_id, $user_id);
            }
        }
    }

    //Feed posts del usuario
    public function feedPosts($user_id){

         $user_connected = $user_id;
         //Datos del feed
         $stmt = $this->pdo->prepare("SELECT * from posts  WHERE post_user IN (SELECT reciver FROM follow WHERE sender=:sender) OR post_user IN (SELECT user_id FROM hashtag_followers WHERE user_id=:user_id) OR post_user=:post_user ORDER BY post_id DESC");
         $stmt->bindParam(":sender", $user_id , PDO::PARAM_STR);
         $stmt->bindParam(":post_user", $user_id , PDO::PARAM_STR);
         $stmt->bindParam(":user_id", $user_id , PDO::PARAM_STR);
         $stmt->execute();
 
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        //Si no hay actividad entonces mostramos mensaje de bienveida
        if(empty($posts)){
            echo 
                '<div class="no-post-message"><img src="assets/images/welcome.jpg"><h4>You dont have any activity, please create your first post. <br> Or visit our <a href="stream.php">stream</a> to see activity.</h4></div>';
        }
        //Mostramos los posts correspondientes
        else{
            foreach($posts as $post){
                 //Sacamos el id del post
                 $post_id = $post->post_id;
                 //Llamamos a la función para imprimir el post
                 $postPrint = $this->printPost($post_id,$user_connected);
            }
        }
 
        
    }

    //Reportar post
    public function reportPost($post_id, $sender_report){
        $stmt = $this->pdo->prepare("INSERT INTO report_post (post_id,sender_id) VALUES (:post_id,:sender_id)");
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
        $stmt->bindParam(":sender_id", $sender_report, PDO::PARAM_STR);
        $stmt->execute();

        $result =$stmt->rowCount();

        echo $result;
    }

    //Verificar si el usuario ya reportó el post
    public function reportPostCheck($user_connected, $post_id){
        $stmt = $this->pdo->prepare("SELECT * FROM report_post WHERE sender_id = :sender_id AND post_id = :post_id");
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
        $stmt->bindParam(":sender_id", $user_connected, PDO::PARAM_STR);
        $stmt->execute();

        $result =$stmt->rowCount();

        return $result;

    }
    
}
?>