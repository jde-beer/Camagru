<!-- <!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Document</title>

		<link rel="stylesheet" type="text/css" href="videoCss.css">
	</head>
	<body>

		<div class="booth">
			<video id="video" width="400" height="300" autoplay></video>
			<a href="#" id="capture" class="booth-capture-button">Take photo</a>
			<canvas id="canvas" width="400" height="300"></canvas>
		</div>

		<script src="camera.js"></script>
	</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Snapper</title>
</head>
<body>
	<div>
		<h1>snapper</h1>
	</div>
	<div>
		<video id="video"> stream not available</video>
		<button id="photo-button"> Take photo</button>
		<select id="photo-filter">
			<option value="none">Normal</option>
			<option value="grascale(100%)">Grayscale</option>
			<option value="sepia(100%)">Sepia</option>
			<option value="Invert(100%)">Invert</option>
			<option value="hue-rotate(90deg)">Hue</option>
			<option value="blur(10px)">Blur</option>
			<option value="contrast(200%)">Contrast</option>
		</select>
		<button id="clear-button">Clear</button>
		<canvas id="canvas"></canvas>
	</div>
	<div id="photos"></div>
	
	<script src="snap.js"></script>
</body>
</html>