<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">

	<title>Take the Cake | Number Playground</title>

	<style>
		body {
			background: #000000;
			overflow: hidden;
			margin: 0 auto;
			padding: 0;
		}

		.disable-selection {
			cursor: default;
			-moz-user-select: none; /* Firefox */
			-ms-user-select: none; /* Internet Explorer */
			-khtml-user-select: none; /* KHTML browsers (e.g. Konqueror) */
			-webkit-user-select: none; /* Chrome, Safari, and Opera */
			-webkit-touch-callout: none; /* Disable Android and iOS callouts*/
		}

		#canvas {
			padding: 0;
			margin: auto;
			display: block;
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
		}

		#warning-message {
			display: none;
		}

		@font-face {
			font-family: "Grilcb";
			src: url('fonts/29C4F4_0_0.eot?') format('eot'), url('fonts/29C4F4_0_0.woff') format('woff'), url('fonts/29C4F4_0_0.ttf') format('truetype');
		}

		@media only screen and (orientation: portrait) {
			#wrapper {
				display: none;
			+874 }

			#warning-message {
				display: block;
			}
		}

		@media only screen and (orientation: landscape) {
			#warning-message {
				display: none;
			}
		}

	</style>
</head>
<body>

<script>
	document.addEventListener('touchmove', function(e) {
		e.preventDefault();
	}, { passive: false });

</script>
<div id="wrapper">

	<div id='preload' style='display: none'>

		<img src=images/logo.png id="pre"/></div>
	<canvas id="sketch" width="1024" height="640" style=" position: absolute; display: none "></canvas>
	<canvas id="canvas" width="1024" height="615"
			oncontextmenu="return false"
			style="position: absolute; display: block; background-color: #000000;"></canvas>

	<div id="draw" width="1024" height="640" style="display: none; position: absolute;"></div>0+

</div>
<div id="warning-message">
	<canvas id="portrait" style="z-index:0;position:absolute;left:0px;top:0px; background-color: black" width="768px" height="1024px"></canvas>
</div>
</body>
<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
<script src="js/createjs-2015.11.26.min.js"></script>
<script src=js/bingomultiplication.js></script>
<script>
</script>
</html>