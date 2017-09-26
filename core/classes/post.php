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

        //$error = $stmt->errorInfo();
        //var_dump($error);
        $post_id = $this->pdo->lastInsertId();
        echo $post_id;
    }

    //Mostramos un post
    public function printPost($post_id){
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
                    echo'<a href="post.php?id='.$post->post_id.'">'.
                        '<div class="post-image" style="background:url('.$post->post_image.');"></div>'.
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
                        '<a class="color-mainDark bold" href="post.php?id='.$post->post_id.'">View post </a>'.
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
                    '<div class="post-actions">'.
                        '<ul class="post-actions-items">'.
                            '<li><i class="material-icons">favorite</i></li>'.
                            '<li><i class="material-icons">comment</i></li>'.
                        '</ul>'.
                        '<button id="demo-menu-lower-right'.$post->post_id.'"'.
                        'class="mdl-button mdl-js-button mdl-button--icon">'.
                        '<i class="material-icons">more_vert</i>'.
                        '</button>'.
                        '<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"'.
                            'for="demo-menu-lower-right'.$post->post_id.'">';
                        if($user_id === $post->post_user){
                            echo 
                            '<li class="mdl-menu__item deletePost" data-post-id="'.$post->post_id.'">Delete</li>';
                        }else{
                            echo 
                            '<li class="mdl-menu__item">Report</li>'.
                            '<li class="mdl-menu__item"><a href="'.BASE_URL.'/post/'.$post->post_id.'">View Post</a></li>';
                        }
                        echo '</ul>'.
                    '</div>'.
				'</div>'.
			'</div><!-- /post -->';
        }
    }

    //Mostramos los posts del usuario
    public function posts($user_id){

        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_user = :post_user ORDER BY post_id DESC");
        $stmt->bindParam(":post_user", $user_id , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($posts as $post){
            //Sacamos el id del post
            $post_id = $post->post_id;
            //Llamamos a la función para imprimir el post
            $postPrint = $this->printPost($post_id);
        }
    }

    //Mostramos el post abierto
    public function post($post_id,$user_id,$post_open){

        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id ORDER BY post_id DESC");
        $stmt->bindParam(":post_id", $post_id , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($posts as $post){
            //Sacamos el id del post
            $post_id = $post->post_id;
            //Llamamos a la función para imprimir el post
            $postPrint = $this->printPost($post_id);
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
        //$error = $stmt->errorInfo();
        //var_dump($error);
    }

    //Retorna el número de post del usuario
    public function postCount($reciver){
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_user = :post_user");
        $stmt->bindParam(":post_user", $reciver , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->rowCount();

        echo $posts;
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

    //Feed posts del usuario
    public function feedPosts($user_id){
         //Datos del feed
         $stmt = $this->pdo->prepare("SELECT * from posts  WHERE post_user IN (SELECT reciver FROM follow WHERE sender=:sender) OR post_user IN (SELECT user_id FROM hashtag_followers WHERE user_id=:user_id) OR post_user=:post_user ORDER BY post_id DESC");
         $stmt->bindParam(":sender", $user_id , PDO::PARAM_STR);
         $stmt->bindParam(":post_user", $user_id , PDO::PARAM_STR);
         $stmt->bindParam(":user_id", $user_id , PDO::PARAM_STR);
         $stmt->execute();
 
         $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
 
         foreach($posts as $post){
             //Sacamos el id del post
             $post_id = $post->post_id;
             //Llamamos a la función para imprimir el post
             $postPrint = $this->printPost($post_id);
         }
    }
    
}
?>