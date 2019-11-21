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

#recap, .dec {
	display: none;
}

.stickers {
	width: 80px;
	display: inline-block;

}

.wrapper {
	margin: 0 auto;
	position: relative;
	display: none;
    width: 400px;
    height: 300px;
}

.viewS {
    position: relative;
    top: 0;
	left: 0;
}

.viewS #view {
	display: none;
}

#post {
	display: none;
}

.dec {
	height: 100px;
}

.view {
	position: absolute;
}

#post{
	display: block;
	margin: 1vh auto;
}

#reset {
	display: none;
}

#video, .view {
	transform: rotateY(180deg);
    -webkit-transform:rotateY(180deg); /* Safari and Chrome */
    -moz-transform:rotateY(180deg); 
	display: block; 
}

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

    .stickers {
    width: 10vw;
    height: 10vh;
	display: inline-block;
    }

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
	<div class="form">
<div class="try">	
	<video id="video" autoplay width="640" hieght="480"></video>
	<div class="wrapper">

	<canvas display="none" id="view" class="view"></canvas>
	<canvas display="none" id="viewS" class="viewS"></canvas>
	</div>
	<button id="cap" class="btn btn-primary">Capture</button>
	<input type="file" name="u_pic" onchange="uploadToC()" id="ftu">
	<button id="recap" display="none" class="btn btn-primary">Recapture</button>
	<button id="reset" display="none" onClick="reset()" class="btn btn-primary">Reset Stickers</button>
</div>	
<div class="dec">
	<?php
			if ($handle = opendir('stickers')) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        echo "<button onclick='addImg(\"$entry\")'><img class='stickers' src='stickers/".$entry."'></button>";
                    }
                }
                closedir($handle);
            }
	?>
</div>
<div>
		<form method="post" action="#">
		<input type="hidden" id="imgUrl" name="imgUrl">
		<input type="hidden" id="sURL" name="sURL">
		<label>Caption</label><br />
		<input type="text" name="caption" id="caption">
		<input type="submit" class="btn btn-primary postP" id="postP" onclick="saveImg()">POST PICTURE</button>
</form>
	</div>
<script type="text/javascript">
	<?php 
		require_once "camera.js";
	?>
</script>
</div>
<?php
    require_once "camtodb.php";
?>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>