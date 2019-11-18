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
    </style>
</head>
<body>
<h2>User Authentication system </h2><hr>

<?PHP if(!isset($_SESSION['username'])): ?>
<p>You are currently not signed in <a href="login.php">login</a> Not yet a member? <a href="signup.php">signup</a> </p>
<p>Public Gallery <a href="gallery.php">Click here</a></p>
<?PHP else: ?>
<p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">logout</a> </p>
<p>Would you like to reset your password <a href="update.php">update profile</a></p>
<p>Private gallery <a href="private_gallery.php">Click here</a></p>
<p>Public Gallery <a href="gallery.php">Click here</a></p>
<?php endif ?>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>