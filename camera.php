<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';
?>
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
	body {
        position: relative;
        min-height: 100%;
        min-height: 100vh;
        }
        footer {
        position: absolute;
        right: 0;bottom:0;
        }
        .navbar {
        overflow: hidden;
        background-color: #333;
        }
    .navbar a {
        float: left;
        font-size: 16px;
        color: green;
        text-align: center;
        padding:: 14px 16px;
        text-decoration: none;
    }
    .dropdown{
        float: left;
        overflow: hidden;
    }
    .dropdown .dropbtn{
        font-size: 16px;
        border: none;
        outline: none;
        color: pink;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }
    .navbar a:hover, .dropdown:hover .dropbtn{
        background-color: grey;
    }
    .dropdown-content {
        display:none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a{
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }
    .dropdown-content a:hover{
        background-color: #ddd;
    }
    .dropdown:hover .dropdown-content{
        display: block;
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
<h1><i>Camagru</i></h1><hr>
    <div class="navbar">
        <a href="index.php">Home</a>
            <div class="dropdown">
                <?php if (isset($_SESSION['username'])): ?>
                <button class="dropbtn">Menu 
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                <a href="private_gallery.php">My Gallery</a>
                <a href="gallery.php">Public Gallery</a>
                <a href="camera.php">Photo Booth</a>
                  <a href="update.php">Update Profile</a>
                  <a href="logout.php">Logout</a>
                </div>
                <?php endif ?>
            </div> 
    </div>
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