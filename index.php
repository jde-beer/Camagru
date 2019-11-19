<?php 
include_once 'config/connect.php';
include_once 'config/session.php';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Homepage</title>
    <style>
    footer{
        position: absolute;
        right:0; bottom:0;
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
<!-- <h2>User Authentication system </h2><hr> -->

<?PHP if(!isset($_SESSION['username'])): ?>
<p>You are currently not signed in <a href="login.php">login</a> Not yet a member? <a href="signup.php">signup</a> </p>
<p>Public Gallery <a href="gallery.php">Click here</a></p>
<?PHP else: ?>
<p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> </p>
<?php endif ?>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>