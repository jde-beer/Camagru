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

            if(password_verify($password, $hashed_password))
            {
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                header("location: index.php");
            }
            else
            {
                $result = "<p style='padding: 20px; color: red; border: 1 px solid gray;'> Invalid username or password";
            }
        }
    }
    else
    {
        if(count($form_errors) == 1)
        {
            $result = "<p style='color: red;'>There was one error in the form </p>";
        }
        else
        {
            $result = "<p style='color : red;'> There were " .count($form_errors). " errors in the form </p>";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>
<h2>User Authentication system </h2><hr>
<h3>Login form</h3>

<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
    <table>
    <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
    <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
    <tr><td></td><td><input style="float: right;" type="submit" name="loginBtn" value="Login"></td></tr>
    </table>
</form>
<p>Not yet a member? <a href="signup.php">signup</a> </p>
</body>
</html>