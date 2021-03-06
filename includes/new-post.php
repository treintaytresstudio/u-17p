<?php

    //Archivo principal de clases
    include_once $_SERVER['DOCUMENT_ROOT'].'/u-17p/core/init.php';

    //Usuario conectado
    $user_id = $_SESSION['user_id'];

    //Mini profile
    $user = $getFromU->userData($user_id);
  
    

    
?>
<div class="new-post-wrap">
    <div class="new-post" data-user="<?php echo $user->user_id; ?>">
        <div class="new-post-header">
            <div class="avatar" style="background:url(<?php echo $user->profileImage; ?>);"></div>
            <h4>New Post</h4>
            <i class="material-icons new-post-close">close</i>
        </div>
        <div class="new-post-input">
            <textarea name="newPostInput" id="newPostInput" cols="20" rows="3" placeholder="Enter the caption"></textarea>
            <span id="captionError"></span>
        </div>
        <div class="new-post-footer">
            <div class="flex-a-center"> 
                <i class="material-icons new-post-addPhoto"><i class="material-icons">photo_size_select_large</i></i>
                <input type="hidden" id="post_image" role="uploadcare-uploader" name="content"
                    data-images-only="true" />
                <div class="image-recent">
                    <img src="" alt="" id="image">
                </div>
            </div>
            <button type="button" class="btn btn-primary bg-accent" id="newPostBtn">Create</button>
        </div>
    </div>
</div>
