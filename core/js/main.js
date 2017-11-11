//JQUERY
$("document").ready(function(){
    //getNotifications();

    var ajaxPhp = '../u-17p/core/ajax/ajax.php';
    var postsHome = '../u-17p/includes/posts_home.php';
    var regex = /[#|@](\w+)$/ig

    //Grid
    //INITIALIZE THE PLUGIN
    //INITIALIZE THE PLUGIN
    $('#grid').grid({
        showFilterBar: false, //Show the navigation filter bar at the top 
        imagesToLoad: 21, //The number of images to load when you click the load more button
        imagesToLoadStart: 21, //The number of images to load when it first loads the grid
        lazyLoad: true, //If you wish to load more images when it reach the bottom of the page
        isFitWidth: true, //Nedded to be true if you wish to center the gallery to its container
        horizontalSpaceBetweenThumbnails: 5, //The space between images horizontally
        verticalSpaceBetweenThumbnails: 5, //The space between images vertically
        columnWidth: 'auto', //The width of each columns, if you set it to 'auto' it will use the columns instead
        columns: 5, //The number of columns when you set columnWidth to 'auto'
        columnMinWidth: 220, //The minimum width of each columns when you set columnWidth to 'auto'
        isAnimated: true, //If you wish the gallery to have animated effects when resizing the grid
        caption: true, //Show the caption in mouse over
        captionType: 'grid', // 'grid', 'grid-fade', 'classic' the type of caption effect
        lightBox: false, //Do you want the lightbox?
        lightboxKeyboardNav: true, //Keyboard navigation of the next and prev image
        lightBoxSpeedFx: 500, //The speed of the lightbox effects
        lightBoxZoomAnim: true, //Do you want the zoom effect of the images in the lightbox?
        lightBoxText: true, //If you wish to show the text in the lightbox
        lightboxPlayBtn: true, //Show the play button?
        lightBoxAutoPlay: false, //The first time you open the lightbox it start playing the images
        lightBoxPlayInterval: 4000, //The interval in the auto play mode 
        lightBoxShowTimer: true, //If you wish to show the timer in auto play mode
        lightBoxStopPlayOnClose: false, //Do you want pause the auto play mode when you close the lightbox?
    });

    //Seguir usuario
    $("#followBtn").on("click", function(){
        var sender = $(this).data('sender');
        var reciver = $(this).data('reciver');

        $.ajax({
            url:ajaxPhp,
            type: 'POST',
            data: {operacion: 'followUser', sender: sender, reciver: reciver},
            beforeSend: function(){
              //
            },
            complete: function(data){
                $("#followBtn").hide();
                $("#unFollowBtn").show();  

                followerNot(sender,reciver);
            }
          });

    });

    //Dejar de seguir usuario
    $("#unFollowBtn").on("click", function(){
        var sender = $(this).data('sender');
        var reciver = $(this).data('reciver');

        $.ajax({
            url:ajaxPhp,
            type: 'POST',
            data: {operacion: 'unFollowUser', sender: sender, reciver: reciver},
            beforeSend: function(){
              //
            },
            complete: function(res){
                $("#unFollowBtn").hide();
                $("#followBtn").show();         
            }
          });

    });

    //Seguir hashtag
    $("#followHashtagBtn").on("click", function(){
        var user_id = $(this).data('user-id');
        var hashtag_name = $(this).data('hashtag-name');

        $.ajax({
            url:ajaxPhp,
            type: 'POST',
            data: {operacion: 'followHashtag', user_id: user_id, hashtag_name: hashtag_name},
            beforeSend: function(){
              //
            },
            complete: function(res){
                //$("#followHashtagBtn").hide();
                //$("#unFollowHashtagBtn").show();
                location.reload();

            }
          });
    });

    //Reportar post
    $(".reportPostBtn").on("click", function(){
        var sender_report =$("#menuUser").data("user-id");
        var post_id = $(this).data('post-id');

        $.ajax({
            url:ajaxPhp,
            type: 'POST',
            data: {operacion: 'reportPost', sender_report: sender_report, post_id: post_id},
            beforeSend: function(){
              //
            }
        
          }).done(function(res) {
            if(res == 1){
                //Recargamos posts
                $( ".feed-container" ).load( "includes/feed_inc.php", function() {
                    //Material lite menu
                    componentHandler.upgradeAllRegistered();
                });
                
                //Mostramos notificación
                $('.notification-body').html('You reported this post');
                $('.notification-body').addClass('animated fadeIn');
                $('.notification-body').removeClass('fadeOut');

                //Mostramos notificación
                $(".notification-body").show();

                //Cerramos notificación
                setTimeout(function(){
                  $('.notification-body').removeClass('fadeIn');
                  $('.notification-body').addClass('animated fadeOut');
                }, 2000);
            }
        })
    });

    //Dejar de seguir hashtag
    $("#unFollowHashtagBtn").on("click", function(){
        var user_id = $(this).data('user-id');
        var hashtag_name = $(this).data('hashtag-name');

        $.ajax({
            url:ajaxPhp,
            type: 'POST',
            data: {operacion: 'unFollowHashtag', user_id: user_id, hashtag_name: hashtag_name},
            beforeSend: function(){
              //
            },
            complete: function(res){
                //$("#unFollowHashtagBtn").hide();
                //$("#followHashtagBtn").show();
                location.reload();
            }
          });
    });

    //Dropdowns Bootstrap
    $('.dropdown-toggle').dropdown()

    //Abrir new post
    $(".openNewPost").click(function(){
        $(".new-post-wrap").css("display", "flex");
    });

    //Cerrar new post
    $(".new-post-close").on("click" , function(){
        $(".new-post-wrap").css("display", "none");
    });

    //Buscar usuario
    $(".input-search").keyup(function(){
        var search = $(this).val();
        if(search.length == 0){
            $(".menu-search-input-icon").css("color","#5b6775");
            $(".menu-search-result-wrap").css("border","none");
            $(".input-search").css("border-color","#000");
        }else if(search.length > 0){
            $(".menu-search-input-icon").css("color","#0085EA");
            $(".input-search").css("border-color","#0085EA");
            $(".menu-search-result-wrap").css("border-left","1px solid #0085EA");
            $(".menu-search-result-wrap").css("border-right","1px solid #0085EA");
            $(".menu-search-result-wrap").css("border-bottom","1px solid #0085EA");
            
        }
        $.post(ajaxPhp, {search:search},function(data){
            $(".menu-top-result-list").html(data);
        })
    });

    //Buscar hashtags
    $("#explore-search").keyup(function(){
        var searchExplore = $(this).val();
        if(searchExplore.length == 0){
            $(".hideOnSearch").css("display", "flex");
        }else if(searchExplore.length > 0){
            $(".hideOnSearch").css("display", "none");
        }
        $.post(ajaxPhp, {searchExplore:searchExplore},function(data){
            $("#explore-search-data").html(data);
        })
    });

    

    //Comentar en post
    $("#commentBtn").click(function(){
        var post_id = $(this).data('post-id');
        var comment = $('#pcival'+post_id).val();
        var userScreenName = $(this).data('user-screenName');
        commentPost(post_id,comment);
    });

    //Cambiar foto de perfil del usuario
    $("#changeImagePhoto").click(function(e){
        event.preventDefault(e);

        var imagen = $("#profileImage").val();
        var user_id =$("#profileImage").attr("data-user");

        //LLamamos al archivo ajax para ejecutar la función de cambiar foto de perfil en php
        $.ajax({
            url:ajaxPhp,
            type: 'GET',
            data: {imagen: imagen, operacion: 'updateProfileImage', user_id: user_id},
            beforeSend: function(){
              $("#changeImagePhoto").val('Cargando');
            },
            complete: function(res){
                $("#changeImagePhoto").val('Actualizada');
                location.reload();
            }
          });
    });

    //Cambiar foto de cover del usuario
    $("#changeCoverPhoto").click(function(e){
        event.preventDefault(e);

        var imagen = $("#coverImage").val();
        var user_id =$("#coverImage").attr("data-user");

        //LLamamos al archivo ajax para ejecutar la función de cambiar foto de perfil en php
        $.ajax({
            url:ajaxPhp,
            type: 'GET',
            data: {imagen: imagen, operacion: 'updateCoverImage', user_id: user_id},
            beforeSend: function(){
              $("#changeImagePhoto").val('Cargando');
            },
            complete: function(res){
                $("#changeImagePhoto").val('Actualizada');
                location.reload();
            }
          });
    });

    //Actualizar datos del usuario
    $("#settingsBtn").click(function(e){
        event.preventDefault(e);

        var user_id =$("#settingsForm").attr("data-user");
        var screenName = $("#settingsScreenName").val();
        var username = $("#settingsUsername").val();
        var bio = $("#settingsBio").val();
        var country = $("#settingsCountry").val();


        //LLamamos al archivo ajax para ejecutar la función de cambiar los datos del usuario en la sección settings
        $.ajax({
            url:ajaxPhp,
            type: 'GET',
            contentType:'application/x-www-form-urlencoded; charset=UTF-8',
            data: {user_id: user_id, operacion: 'updateSettings', screenName: screenName, username: username, bio: bio, country: country},
            beforeSend: function(){

              $('.not-update').addClass('animated fadeIn');
              $('.not-update').removeClass('fadeOut');
            }
          })
          .done(function(data) {
              
              if(data == 1){
              //El usuario, está disponible
              $("#settingsUsername").removeClass("settings-input-error");
              $(".settings-response-username").hide().html("");

              //Mostramos notificación
              $(".not-update").show();

              //Cerramos notificación
              setTimeout(function(){
                $('.not-update').removeClass('fadeIn');
                $('.not-update').addClass('animated fadeOut');
              }, 2000);

              }else if(data == 0){
                $("#settingsUsername").addClass("settings-input-error");
                $(".settings-response-username").show().html("The username is already taken, please choose other option");
              }
              
          });
    });

    //Crear Post
    $("#newPostBtn").click(function(){
        
        var user_id = $(".new-post").attr("data-user");
        var post_caption= $("#newPostInput").val();
        var post_image = $("#post_image").val(); 


        $.ajax({
            url:ajaxPhp,
            type: 'POST',
            contentType:'application/x-www-form-urlencoded; charset=UTF-8',
            data: {user_id: user_id, operacion: 'newPost', post_caption: post_caption, post_image: post_image},
            beforeSend: function(){
              //Antes de enviar la petición
              $('#newPostBtn').val('Creating Post');
            }
          })
          .done(function(data) {
            
            //Verificamos que el caption no venga vacío
            if(data == 0){
                //Si viene vacío el caption entonces
                //Mostramos al usuario un error
                $("#newPostInput").css("border", "1px solid red");
                $("#captionError").html("The caption cant be empty").css("color","red");
            }else if(data == 400){
                //Si viene vacío la imagen entonces
                //Mostramos al usuario un error
                $("#captionError").html("You have to select an image").css("color","red");
            }else{
                //Si no viene vacío entonces
                //Cerramos nuevo post
                $('.new-post-wrap').css("display","none");
                //Formateamos el valor del input
                $("#newPostInput").val('');
                //Recargamos el div con el nuevo post
                $( ".feed-container" ).load( "includes/feed_inc.php", function() {
                    componentHandler.upgradeAllRegistered()
                });

                //Actualizar contador de mini perfil
                $( ".mini-profile-container" ).load( "includes/mini_profile_inc.php", function() {});

                var post_id = data;


                //Insertamos el post en firebase
                postFb(post_id,user_id);


                //Llamamos a la función encargada de verificar si existen # en el caption del post
                hashtagPost(post_caption, post_id);

                

                //Mostramos notificación
                setTimeout(function(){
                  //Mostramos notificación
                  $('.notification-body').html('Your post has been posted');
                  $('.notification-body').addClass('animated fadeIn');
                  $('.notification-body').removeClass('fadeOut');

                  //Mostramos notificación
                  $(".notification-body").show();
                }, 1000);

                //Cerramos notificación
                setTimeout(function(){
                  $('.notification-body').removeClass('fadeIn');
                  $('.notification-body').addClass('animated fadeOut');
                }, 3500);
            }

          });
    });

    ////////////----------Funciones----------////////////
    
    //Confirmación para borrar post

    //Función para sacar los hashtags del caption post
    function hashtagPost(post_caption,post_id){
        
          //recibimos el caption del post
          var caption = post_caption;
        
          //dividimos el post en un array
          var caption_split = caption.split(" ");
        
          //recorremos los items del arreglo
          for(var hashtag in caption_split) {
              
              //Si algun item del arreglo comienza con # entonces tenemos un hashtag, si no, lo ignoramos
              if (caption_split[hashtag].match("^#")) {
        
                //Le quitamos el # para poder trabajar con el string
                hashtag_name = caption_split[hashtag].replace('#','');
        
                //Mandamos llamar la función encargada de verificar si el # existe o no 
                $.ajax({
                    url:ajaxPhp,
                    type: 'POST',
                    contentType:'application/x-www-form-urlencoded; charset=UTF-8',
                    data: {operacion: 'captionHashtag', hashtag_name: hashtag_name, post_id: post_id},
                    beforeSend: function(){
                      //Antes de enviar la petición
                      
                    }
                  })
                  .done(function(data) {
                    //Operación exitosa
                  });
                
              }
          }
         
    }

});

//Delegation event "Para manejar clicks después de cargar con Ajax"

//Like post
$(document).on('click', '.likePost', function(){
    var post_id = $(this).data('post-id');
    $("#"+post_id+"u").show();
    $("#"+post_id+"l").hide();
    likePost(post_id);
});

//Unlike post
$(document).on('click', '.unLikePost', function(){
    var post_id = $(this).data('post-id');
    $("#"+post_id+"u").hide();
    $("#"+post_id+"l").show();
    unLikePost(post_id);
});

//Cancelar borrar post
$(document).on('click', '.cancellDeletePost', function(){
   $(".boxConfirmDeletePost").css("display","none");
   $(".bg-action").hide();
});

//Abrir la confirmación para eliminar el post
$(document).on('click', '.deletePost', function(){
    var post_id = $(this).data('post-id');
    deletePostConfirm(post_id);
});

//Followers profile open
$(document).on('click', '#profileFollowersLink', function(){
    var username_profile = $(".profile").data('profile-username');

    $( ".profile-content" ).load( "includes/profile_followers_inc.php?username_profile="+username_profile );
    $("#profileFollowersLink").addClass('active');
    $("#profileFollowingsLink").removeClass('active');
    $("#profilePostLink").removeClass('active');

});

//post profile open
$(document).on('click', '#profilePostLink', function(){
    var username_profile = $(".profile").data('profile-username');

    $( ".profile-content" ).load( "includes/profile_posts_inc.php?username_profile="+username_profile );
    $("#profilePostLink").addClass('active');
    $("#profileFollowersLink").removeClass('active');
    $("#profileFollowingsLink").removeClass('active');

});

//Followings profile open
$(document).on('click', '#profileFollowingsLink', function(){
    var username_profile = $(".profile").data('profile-username');
    $( ".profile-content" ).load( "includes/profile_followings_inc.php?username_profile="+username_profile );
    $("#profileFollowingsLink").addClass('active');
    $("#profileFollowersLink").removeClass('active');
    $("#profilePostLink").removeClass('active');

});


//Borar post
function deletePostConfirm(post_id){
    $(".bg-action").show();
    $(".boxConfirmDeletePost").css("display","flex");
    $(".confirmDeletePost").attr('data-post-id', post_id);
}

//Borrar post
$(document).on('click', '.confirmDeletePost', function(){
    console.log("valor de : post_id "+post_id)
    var ajaxPhp = '../u-17p/core/ajax/ajax.php';
    var post_id = $(this).attr('data-post-id');
    console.log("valor de : post_id "+post_id);


    $.ajax({
        url:ajaxPhp,
        type: 'POST',
        data: {operacion: 'deletePost', post_id: post_id},
        beforeSend: function(){
          
        },
        complete: function(res){
            //Cerramos caja de confirmación
            $(".boxConfirmDeletePost").css("display","none");
            $(".bg-action").hide();
            //Recargamos posts
            $( ".feed-container" ).load( "includes/feed_inc.php", function() {
                //Material lite menu
                componentHandler.upgradeAllRegistered();
            });

            //Mostramos notificación
            $('.notification-body').addClass('animated fadeIn');
            $('.notification-body').removeClass('fadeOut');

            //Mostramos notificación
            $(".notification-body").show();

            //Cerramos notificación
            setTimeout(function(){
              $('.notification-body').removeClass('fadeIn');
              $('.notification-body').addClass('animated fadeOut');
            }, 2000);

            //Actualizar contador de mini perfil
            $( ".mini-profile-container" ).load( "includes/mini_profile_inc.php", function() {});


            var post_id = null;
            
        }
      });
});


//JAVASCRIPT

//UPLOAD CARE INFO
UPLOADCARE_LOCALE = "en";
UPLOADCARE_TABS = "file facebook instagram";
UPLOADCARE_PUBLIC_KEY = "16e381e4b3ec66d54756";

//Mostrar imagen subida
var image = document.getElementById('image');
var widget = uploadcare.Widget('[role=uploadcare-uploader]');
widget.onUploadComplete(function (fileInfo) {
  image.src = fileInfo.cdnUrl;
});
