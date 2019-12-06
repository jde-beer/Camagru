<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if (!isset($_SESSION['username']))
{
    redirectTo("login");
}
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
    .small{
        flex:auto;
        display:inline-block;
        margin-right: 5px;
    }
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
<div>
    <div>
        <video id="video" autoplay width="480" hieght="300"></video><br>
    </div>
	<div class=""> 
        <canvas id="viewS" width="480" height="300" style="position: absolute;"></canvas>
	    <canvas style="display:block" id="view" width="480" height="300"></canvas><br>
	</div>
	<button id="cap" class="btn btn-primary">Capture</button>
	<input type="file" name="u_pic" id="ftu">
    
</div>	
<div>
		<br><button id="postBtn">Post</button><br><br>
        <img src="stickers/bulbasaur.png" alt="" id="bul" width="75" height="75">
        <img src="stickers/pikachu.png" alt="" id="pika" width="75" height="75">
        <img src="stickers/squirtle.png" alt="" id="squ" width="75" height="75">
</div>
<?php
    $query1 = "SELECT * FROM gallery WHERE userid = :userid ORDER BY id DESC LIMIT 5";
    $query = $DB_NAME->prepare($query1);
    $query->execute(array(':userid' => $_SESSION['username']));
    while($row = $query->fetch()){
        if(preg_match('/cameraEdit/', $row['descGallery'])){
            echo    "<div class='small'>
                         <img width='75' height='75' src='uploads/".$row['descGallery']."' >
                        </a>
                    </div>";
        }
    }
?>
<script type="text/javascript">
	<?php 
		require_once "snap.js";
	?>
</script>
</div>
<?php
    require_once "camtodb.php";
?>
</body><br>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>