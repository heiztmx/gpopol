<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title></title>
</head>

<body>
<!-- 	<br>
	<br>
	<br>
	<br>
	<br>
 -->
	<div class="d-flex flex-column justify-content-center container ">
		<div id="loading" class="col-md-2 mx-auto"></div>
		<br>
		<h5 style="text-align: center; color: gray;">Cargando datos, Espere por favor </h5>

	</div>
</body>
<!-- <script type="text/javascript" src="js/medidas.js"></script> -->
<script>
	lottie.loadAnimation({
		container: document.getElementById('loading'), // the dom element that will contain the animation
		renderer: 'svg',
		loop: true,
		autoplay: true,
		path: '../../../lottie/animaciones/2198-loading-1.json' // the path to the animation json
	});
</script>

</html>