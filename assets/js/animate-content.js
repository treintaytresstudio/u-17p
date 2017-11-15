$("document").ready(function(){
	setTimeout(function(){
	  $('.trends-home').css("display", "block").addClass('animated fadeIn');
	}, 700);

	setTimeout(function(){
	  $('.trends-home-list').css("display", "flex").addClass('animated fadeIn');
	}, 720);

	setTimeout(function(){
	  $('.suggested-home').css("display", "block").addClass('animated fadeIn');
	}, 800);

	setTimeout(function(){
	  $('.tutorial-welcome-post').removeClass('animated bounce').hide();
	}, 4000);
});
