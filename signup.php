<?php
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(isset($_POST['Signup']))
{
    $form_errors = array();

    $required_fields = array('email', 'username', 'password', 'confirm_password');

    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
   
    $field_to_check_length = array('username' => 4, 'password' => 6);

    $form_errors = array_merge($form_errors, check_min_length($field_to_check_length));

    $form_errors = array_merge($form_errors, check_email($_POST));

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $url = $_SERVER['HTTP_HOST'].str_replace("signup.php", "", $_SERVER['REQUEST_URI']);

    if(checkDuplicateUsername("users", "email", $email, $DB_NAME))
    {
        $result = flashMessage("Email in use already.");
    }
    if(checkDuplicateUsername("users", "username", $username, $DB_NAME))
    {
        $result = flashMessage("Username in use already.");
    }

    if($password != $confirm_password)
    {
        $result = flashMessage("Password Does Not Match");
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
    }</style>
</head>
<body>
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