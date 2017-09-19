<?php

class Post extends User
{
    
    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function newPost($user_id,$post_caption,$post_image){
        $time = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO posts (post_user, post_caption, post_image, post_time) VALUES (:post_user,:post_caption,:post_image, :post_time)");
        $stmt->bindParam(":post_user", $user_id,PDO::PARAM_STR);
        $stmt->bindParam(":post_caption", $post_caption,PDO::PARAM_STR);
        $stmt->bindParam(":post_image", $post_image,PDO::PARAM_STR);
        $stmt->bindParam(":post_time", $time,PDO::PARAM_STR);
        $stmt->execute();

        $error = $stmt->errorInfo();
        var_dump($error);
    }

    public function posts($user_id){
        //Datos del usuario
        $stmt2 = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt2->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt2->execute();
        $user = $stmt2->fetch(PDO::FETCH_OBJ);

        //Datos del post
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE post_user = :post_user ORDER BY post_id DESC");
        $stmt->bindParam(":post_user", $user_id , PDO::PARAM_STR);
        $stmt->execute();

        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($posts as $post){

            echo '<!-- post -->'.
            '<div class="post">';
                if(!empty($post->post_image)){
				    echo '<div class="post-image" style="background:url('.$post->post_image.');"></div>';
                }
                echo'<div class="post-content">'.
					'<div class="post-content-user">'.
						'<div class="avatar" style="background:url('.$user->profileImage.');"></div>'.
                        '<a href="'.$user->username.'">'.$user->screenName.
                            '<span>@'.$user->username.'</span>'.
                        '</a>'.
                        
					'</div>'.
					'<div class="post-caption">'.
						'<p>'.$post->post_caption.'</p>'.
                    '</div>'.
                    '<div class="post-actions">'.
                        '<ul>'.
                            '<li><i class="material-icons">favorite</i></li>'.
                            '<li><i class="material-icons">comment</i></li>'.
                        '</ul>'.
                    '</div>'.
				'</div>'.
			'</div><!-- /post -->';
        }
    }
}
?>