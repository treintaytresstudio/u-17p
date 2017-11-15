<div class="notification-body hide">
	Your post has been deleted
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script charset="utf-8" src="//ucarecdn.com/libs/widget/3.1.3/uploadcare.full.min.js"></script>

<!-- Masonry grid -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<!-- animaciones en la app -->
<script src="../u-17p/assets/js/animate-content.js"></script>

<!-- salvatore grid -->
<script src="../u-17p/assets/js/grid.js"></script>
<script src="../u-17p/assets/js/rotate.js"></script>

<script src="../u-17p/core/js/main.js"></script>

<!-- lazy load para las imagenes -->
<script>
    lazyload();
</script>

<?php 
if(isset($page) && $page === 'choose-image-profile'){
?>
<script>
	//UPLOAD CARE INFO
	UPLOADCARE_LOCALE = "en";
	UPLOADCARE_TABS = "file facebook instagram";
	UPLOADCARE_PUBLIC_KEY = "16e381e4b3ec66d54756";

	//Mostrar imagen subida
	var image_new = document.getElementById('image_new');
	var widget_cpi = uploadcare.Widget('[role=uploadcare-uploader2]');
	var button = document.getElementById('changeImagePhoto');
	var button_skip = document.getElementById('slikpChangeImagePhoto');
	var tutorial = document.getElementById('tutorial-photo');
	var help_text = document.getElementById('text-help-change-image');

	widget_cpi.onUploadComplete(function (fileInfo) {

		  image_new.setAttribute("style", "background:url("+fileInfo.cdnUrl+");");
		  button.setAttribute("style","display:block; margin:0 auto;");
		  button_skip.setAttribute("style","display:none;");
		  tutorial.setAttribute("style","display:none;");
		  help_text.setAttribute("style","display:none;");


	});
</script>
<?php }else{ ?>

<script>
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

	var widget = uploadcare.initialize();

</script>
<?php } ?>

</body>
</html>