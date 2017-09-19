//JQUERY
$("document").ready(function(){

    //Abrir new post
    $(".openNewPost").click(function(){
        $(".new-post-wrap").css("display", "flex");
    });

    //Cerrar new post
    $(".new-post-close").click(function(){
        $(".new-post-wrap").css("display", "none");
    });

    //Buscar usuario
    $("#menu-search").keyup(function(){
        var search = $(this).val();
        if(search.length == 0){
            $(".menu-search-input-icon").css("color","#5b6775");
        }else if(search.length > 0){
            $(".menu-search-input-icon").css("color","#0085EA");
            
        }
        $.post('../ultra/core/ajax/ajax.php', {search:search},function(data){
            $(".menu-search-result-wrap").html(data);
            $("#menu-search").css("border", "none")
        })
    });

    //Cambiar foto de perfil del usuario
    $("#changeImagePhoto").click(function(e){
        event.preventDefault(e);

        var imagen = $("#profileImage").val();
        var user_id =$("#profileImage").attr("data-user");

        //LLamamos al archivo ajax para ejecutar la función de cambiar foto de perfil en php
        $.ajax({
            url:'../ultra/core/ajax/ajax.php',
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
            url:'../ultra/core/ajax/ajax.php',
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
            url:'../ultra/core/ajax/ajax.php',
            type: 'GET',
            contentType:'application/x-www-form-urlencoded; charset=UTF-8',
            data: {user_id: user_id, operacion: 'updateSettings', screenName: screenName, username: username, bio: bio, country: country},
            beforeSend: function(){
              $("#settingsBtn").val('Loading');
            }
          })
          .done(function(data) {
              if(data == 1){
                  //El usuario, está disponible
                  $("#settingsUsername").removeClass("settings-input-error");
                  $(".settings-response-username").hide().html("");
              }else if(data == 0){
                //El usuario no está disponible
                $("#settingsUsername").addClass("settings-input-error");
                $(".settings-response-username").show().html("Username is already taken, please enter a new username").css("color","red");
              }
          });
    });

    //Crear Post
    $("#newPostBtn").click(function(){
        
        var user_id = $(".new-post").attr("data-user");
        var post_caption= $("#newPostInput").val();
        var post_image = $("#post_image").val(); 


        //LLamamos al archivo ajax para ejecutar la función de cambiar los datos del usuario en la sección settings
        $.ajax({
            url:'../ultra/core/ajax/ajax.php',
            type: 'POST',
            contentType:'application/x-www-form-urlencoded; charset=UTF-8',
            data: {user_id: user_id, operacion: 'newPost', post_caption: post_caption, post_image: post_image},
            beforeSend: function(){
              //Antes de enviar la petición
              $('#newPostBtn').val('Creating Post');
            }
          })
          .done(function(data) {
            $('#newPostBtn').val('Ready').css("background","green");
            $('.new-post-wrap').css("display","none");
          });
    });

});

//JAVASCRIPT
UPLOADCARE_LOCALE = "en";
UPLOADCARE_TABS = "file facebook instagram";
UPLOADCARE_PUBLIC_KEY = "16e381e4b3ec66d54756";
