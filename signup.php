<?php
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(isset($_POST['Signup']))
{
    $email = htmlentities($_POST['email']);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $confirm_password = htmlentities($_POST['confirm_password']);
    $form_errors = array();

    $required_fields = array('email', 'username', 'password', 'confirm_password');

    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
   
    $field_to_check_length = array('username' => 4, 'password' => 6);

    $form_errors = array_merge($form_errors, check_min_length($field_to_check_length));

    $form_errors = array_merge($form_errors, check_username($username));

    $form_errors = array_merge($form_errors, check_pass($password));
    
    $form_errors = array_merge($form_errors, check_email($_POST));

    $url = $_SERVER['HTTP_HOST'].str_replace("signup.php", "", $_SERVER['REQUEST_URI']);

    if(checkDuplicateUsername("users", "email", $email, $DB_NAME))
    {
        //$result = flashMessage("Email in use already.");
        $form_errors[] = "Email in use already.";
    }
    if(checkDuplicateUsername("users", "username", $username, $DB_NAME))
    {
        //$result = flashMessage("Username in use already.");
        $form_errors[] = "Username in use already.";
    }

    if($password != $confirm_password)
    {
        // $result = flashMessage("Password Does Not Match");
        $form_errors[] = "Password Does Not Match.";
    }

    if(empty($form_errors))
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50)); 
        try
        {
            $sqlInsert = "INSERT INTO users (`email`, `username`, `password`, `token`, `join_date`) VALUES (:email, :username, :password, :token, now())";
            $statement = $DB_NAME->prepare($sqlInsert);
            $statement->execute(array(':email' => $email, ':username' => $username, ':password' => $hashed_password, 'token' => $token));

            if($statement->rowCount() == 1)
            { 
                $result = flashMessage("Registration Successful", "Pass");
            }
            sendVerificationEmail ($email, $token, $url);
        }
        catch (PDOException $ex)
        {
            $result = flashMessage("An error occurred:".$ex->getMessage());
        }
    }
    else
    {
        if(count($form_errors) == 1)
        {
            $result = flashMessage("There was 1 error in the form<br>");
        }

        else
        {  
            $result = flashMessage("There were " .count($form_errors). "error s in the form<br>");
    
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Register Page</title>
    <style>
    footer{
        position: absolute;
        right:0; bottom:0;
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
<h2>User Authentication system </h2><hr>
<h3>Registration Form</h3>

<?php if(isset($result)) echo $result;?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

<form method="post" action="">
    <table>
    <tr><td>Email:</td> <td><input type="Email" value="" name="email" required oninvalid="this.setCustomValidity('Enter Valid Email address here')" oninput="this.setCustomValidity('')" ></td></tr>
    <tr><td>Username:</td> <td><input type="text" value="" name="username" required oninvalid="this.setCustomValidity('Username should be atleast 6 characters long')" oninput="this.setCustomValidity('')" ></td></tr>
    <tr><td>Password:</td> <td><input type="password" value="" name="password"required oninvalid="this.setCustomValidity('Password must contain one uppercase letter and special character')" oninput="this.setCustomValidity('')" ></td></tr>
    <tr><td>Confirm Password:</td> <td><input type="password" value="" name="confirm_password"required></td></tr>
    <tr><td></td><td><input style="float: right;" type="submit" name="Signup" value="Signup"></td></tr>
    </table>
</form>
<p><a href="login.php">Login</a></p>
<p><a href="index.php">Back</a></p>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>