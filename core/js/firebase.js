// Initialize Firebase
var config = {
apiKey: "AIzaSyDAqwYSO1ccnjNKmbT5_n-ulDkNUoNHsJc",
authDomain: "u-17p-964f5.firebaseapp.com",
databaseURL: "https://u-17p-964f5.firebaseio.com",
projectId: "u-17p-964f5",
storageBucket: "u-17p-964f5.appspot.com",
messagingSenderId: "382810553154"
};
firebase.initializeApp(config);


//Get Likes
function getLikesCount(post_id){
      var likes = firebase.database().ref().child("posts/"+post_id+"/likes")    
      likes.on("child_added", snap =>{

      likes.once('value')
        .then(function(snapshot){ 
	        var total_likes = snapshot.numChildren();
	        $("#"+post_id+"likew").html(total_likes);
      });

    });
}

//Mostrar comentarios del post
function getComments(post_id){
    var rootRef = firebase.database().ref().child("posts/"+post_id).child("comments")
    rootRef.on("child_added", snap =>{

     var comment = snap.key;
     var comment_caption = snap.child("comment").val();
     var comment_screenName = snap.child("screenName").val();

     var comment_html = `
                          <li> <span class="bold">${comment_screenName}</span>  ${comment_caption}</li>
                              `
                    $(".post-comments-items").append(comment_html);
   
     });

}

//Saber si usuario ha dado like
function isLiked(post_id){

	//usuario conectado
	var user_id = $(menuUser).data('user-id');


	 var likes = firebase.database().ref().child('posts/'+post_id).child('/likes')
	 .orderByChild('user_id').equalTo(user_id);
      
      likes.once('value')
        .then(function(snapshot){

          var likeResult = snapshot.numChildren();
          
          if(likeResult == 0){
            $("#"+post_id+"l").show();
          }else{
          	$("#"+post_id+"u").show();
          }
        })

}

//Insertamos el post el firebase
function postFb(post_id,user_id){
    post_idC = post_id.replace(/[^a-zA-Z 0-9.]+/g,' ');
    post_idC = post_id.split('"').join('');
    post_idC = post_idC.trim()

    var postData = {
      post_id:post_idC,
      post_user:user_id
    };

    // Guardamos el post, simultaneamente
    var updates = {};
    updates['/posts/' + post_idC] = postData;

    //Ejecutamos la acciòn de guardar
    firebase.database().ref().update(updates);
}

//Insertamos like en post
function likePost(post_id){
	var user_id = $(menuUser).data('user-id');
    var refToPost = firebase.database().ref().child('posts/'+post_id)
    refToPost.child("likes").push({
      user_id:user_id,
      post_id:post_id
    });

    //Insertamos notificación
    var refToPost = firebase.database().ref().child('notifications/'+1).push({
      user_id:'1',
      post_id:post_id,
      not_type:'1'

    });
}

//Insertamos el comentario en el post
function commentPost(post_id,comment){
	var user_id = $('#menuUser').data('user-id');
  var user_screenName = $('#menuUser').data('user-screenname');

  console.log(user_screenName);

    var refToPost = firebase.database().ref().child('posts/'+post_id)
    refToPost.child("comments").push({
      user_id:user_id,
      comment:comment,
      screenName : user_screenName
    });

    //Insertamos notificación
    var refToPost = firebase.database().ref().child('notifications/'+1).push({
      user_id:'1',
      post_id:post_id,
      not_type:'1'

    });
}

//Quitamos like al post
function unLikePost(post_id){
	//User id
	var user_id = $(menuUser).data('user-id');

	//Sacamos el id de like según el usuario
	var unLike = firebase.database().ref().child('posts/'+post_id)
		.child('/likes')
		.orderByChild('user_id')
		.equalTo(user_id);

	  unLike.once('value')
	    .then(function(snapshot){

	      var unLike = snapshot.val();
	      
	      for(like_user in unLike){
	        
	        //ID del like
	        id = like_user;
	        
	        //Borramos el Like
	        var deleteLike = firebase.database().ref().child('posts/'+post_id+'/likes/'+id)
	          deleteLike.remove();

	        getLikesCount(post_id);
	      }

	    });
}

//Insertamos follower notificación
function followerNot(reciver,sender){

    //Insertamos notificación
    var refToPost = firebase.database().ref().child('notifications/'+1).push({
      sender:reciver,
      reciver:sender,
      not_type:'2'
    });
}

 /*-------------NOTIFICATIONS---------------*/
//Get Notifications
function getNotifications(){

    var id = 1;

      //Mostramos notificaciones
      var notifications = firebase.database().ref().child("notifications/"+id)    
      notifications.on("child_added", snap =>{

      //Sacamos el total de notificaciones
      notifications.once('value')
        .then(function(snapshot){

          
          var total_notifications = snapshot.numChildren();
          
          if(total_notifications > 0){
            $(".menu-notifications-alert").css("display","flex")
            $("#total_notifications").html();
          }

      });

    });
}
