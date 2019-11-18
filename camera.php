<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Snapper</title>
	<style>
	footer{
        position: absolute;
        right:0; bottom:0;
	}
	/* /* body {
		margin: 0;
		padding: 0;
		font-family: Arial, Helvetica, sans-serif;
		background: #FFF;
		overflow-x: hidden;
	}

	.top-container{
		width: 500px;
		margin: 30px auto;
	}

	.btn{
		display: block;
		width: 100%;
		padding: 10px;
		margin-bottom: 5px;
	} */

	button{
		background: #f4f4f4;
		color: #000;
		border: purple 1px solid;

	}

	/* .select{
		height:40px;
		background: #333;
		color: #FFF;
		padding: 3px;
		width: 100%;
		border: 1px #ffa500;
		margin-bottom: 10px;
	}

	#canvas{
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
	} */ */
    </style>
</head>
<body>
	<div>
		<h1>snapper</h1>
	</div>
	<div>
		<video id="video"> stream not available</video>
		<button class="btn" id="photo-button"> Take photo</button>
		<select id="photo-filter">
			<option value="none">Normal</option>
			<option value="grascale(100%)">Grayscale</option>
			<option value="sepia(100%)">Sepia</option>
			<option value="Invert(100%)">Invert</option>
			<option value="hue-rotate(90deg)">Hue</option>
			<option value="blur(10px)">Blur</option>
			<option value="contrast(200%)">Contrast</option>
		</select>
		<!-- <button class="" id="clear-button">Clear</button> -->
		<button id="save imagine"  onclick="takePicture()">Save</button>
		<canvas id="canvas"></canvas>
	</div>
	<div id="photos"><div id="fromphp"> </div>
	<!-- //display taken images in DESC order on camera,delete image on camera page -->
	<script src="camera.js"></script>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>