<?php 
include_once 'config/connect.php';
include_once 'config/session.php';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>
<body>
<h2>User Authentication system </h2><hr>

<?PHP if(!isset($_SESSION['username'])): ?>
<p>You are currently not signed in <a href="login.php">login</a> Not yet a member? <a href="signup.php">signup</a> </p>
<?PHP else: ?>
<p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">logout</a> </p>
<?php endif ?>
</body>
</html>