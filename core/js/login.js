$("document").ready(function(){
	var ajaxPhp = '../u-17p/core/ajax/ajax.php';

	//Login
	$("#loginBtn").on("click",function(){
		var email = $("#email").val();
		var password = $("#password").val();

	    $.ajax({
	        url:ajaxPhp,
	        type: 'POST',
	        data: {operacion: 'login', email: email, password: password},
	        beforeSend: function(){
	          $("#loginBtn").hide();
	          $(".login-loader").show();
	        }
	    })
	    .done(function(data) {

	    	//Si no llenaron los campos entonces
	    	if(data == 300){
	    		$(".login-error").show();
	    		$(".login-error").html("Email and Password are required");
	    		//Ocultar loader
		    	$("#loginBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el correo no tiene un formato correcto entonces
	    	if(data == 100){
	    		$(".login-error").show();
	    		$(".login-error").html("The email has an incorrect format");
	    		//Ocultar loader
		    	$("#loginBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el correo o la contraseña no son correctos
	    	if(data == 200){
	    		$(".login-error").show();
	    		$(".login-error").html("The email or password are wrong");
	    		//Ocultar loader
		    	$("#loginBtn").show();
		        $(".login-loader").hide();
	    	}
	    	if(data == 1){
	    		window.location.href = "home.php";
	    		
	    	}


	    });

	});

	//Register
	$("#registerBtn").on("click",function(){
		var email = $("#email").val();
		var password = $("#password").val();
		var screenName = $("#screenName").val();
		var username = $("#username").val();

	    $.ajax({
	        url:ajaxPhp,
	        type: 'POST',
	        data: {operacion: 'register', email: email, password: password,screenName: screenName,username: username},
	        beforeSend: function(){
	          $("#registerBtn").hide();
	          $(".login-loader").show();
	        }
	    })
	    .done(function(data) {

	    	//Si no llenaron los campos entonces
	    	if(data == 5){
	    		$(".register-error").show();
	    		$(".register-error").html("Name is required");
	    		$("#screenName").addClass("error-input");

	    		setTimeout(function(){
	    		  $("#screenName").removeClass("error-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    		
	    	}
	    	if(data == 6){
	    		$(".register-error").show();
	    		$(".register-error").html("Email is required");

	    		$("#email").addClass("error-input");

	    		setTimeout(function(){
	    		  $("#email").removeClass("error-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	if(data == 7){
	    		$(".register-error").show();
	    		$(".register-error").html("Password is required");

	    		$("#password").addClass("error-input");

	    		setTimeout(function(){
	    		  $("#password").removeClass("error-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	if(data == 8){
	    		$(".register-error").show();
	    		$(".register-error").html("Username is required");

	    		$("#username").addClass("error-input");

	    		setTimeout(function(){
	    		  $("#username").removeClass("error-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el correo no tiene un formato correcto entonces
	    	if(data == 100){
	    		$(".register-error").show();
	    		$(".register-error").html("The email has an incorrect format");

	    		$("#email").addClass("error-format-input");

	    		setTimeout(function(){
	    		  $("#email").removeClass("error-format-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el screen name no está entre 6 y 20 caracteres
	    	if(data == 600){
	    		$(".register-error").show();
	    		$(".register-error").html("The name must be between 6 and 20 characters");

	    		$("#screenName").addClass("error-format-input");

	    		setTimeout(function(){
	    		  $("#screenName").removeClass("error-format-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el screen name no está entre 6 y 20 caracteres
	    	if(data == 700){
	    		$(".register-error").show();
	    		$(".register-error").html("The password must be bigger than 5 characters");

	    		$("#password").addClass("error-format-input");

	    		setTimeout(function(){
	    		  $("#password").removeClass("error-format-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el correo ya existe en la bd
	    	if(data == 800){
	    		$(".register-error").show();
	    		$(".register-error").html("The email is already taken");

	    		$("#email").addClass("error-taken-input");

	    		setTimeout(function(){
	    		  $("#email").removeClass("error-taken-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	//Si el correo ya existe en la bd
	    	if(data == 900){
	    		$(".register-error").show();
	    		$(".register-error").html("The username is already taken, please try with other option");

	    		$("#username").addClass("error-taken-input");

	    		setTimeout(function(){
	    		  $("#username").removeClass("error-taken-input");
	    		}, 1000);
	    		//Ocultar loader
		    	$("#registerBtn").show();
		        $(".login-loader").hide();
	    	}
	    	
	    	if(data == 1){
	    		window.location.href = "home.php";
	    	}

	    	

	    });

	});

});