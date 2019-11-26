<?PHP 
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(isset($_POST['loginBtn']))
{
    $form_errors = array();

    $required_field = array('username', 'password');

    $form_errors = array_merge($form_errors, check_empty_fields($required_field));

    if(empty($form_errors))
    {
        $user = $_POST['username'];
        $password = $_POST['password'];

        $sqlQuery = "SELECT * FROM users WHERE username = :username";
        $statement = $DB_NAME->prepare($sqlQuery);
        $statement->execute(array(':username' => $user));

        while($row = $statement->fetch())
        {
            $id = $row['id'];
            $hashed_password = $row['password'];
            $username = $row['username'];
            $verified = $row['verified'];
            $preference = $row['preference'];

            if(password_verify($password, $hashed_password))
            {
                if($verified == 'Y')
                {
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['preference'] = $preference;
                    redirectTo('index');
                }
                else
                {
                    $result = flashMessage("Your account needs to be verified first");
                }
                
            }
            else
            {
                $result = flashMessage("Invalid username or password");
            }
        }
    }
    else
    {
        if(count($form_errors) == 1)
        {
            $result = flashMessage("There was one error in the form");
        }
        else
        {
            $result = flashmessage("There were " .count($form_errors). " errors in the form");
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
    footer{
        position: absolute;
        right:0; bottom:0;}

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
<h2>User Authentication system </h2><hr>
<h3>Login form</h3>

<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
    <table>
    <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
    <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
    <tr><td><a href="forgotpassword.php">Forgot password</a></td><td><input style="float: right;" type="submit" name="loginBtn" value="Login"></td></tr>
    </table>
</form>

<p>Not yet a member? <a href="signup.php">signup</a> </p>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>