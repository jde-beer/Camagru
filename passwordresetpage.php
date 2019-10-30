<?php
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(isset($_POST['passwordResetBtn']))
{
    $form_errors = array();

    $required_field = array('email', 'new_password', 'confirm_password');

    $form_errors = array_merge($form_errors, check_empty_fields($required_field));

    $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    $form_errors = array_merge($form_errors, check_email($_POST));

    if(empty($form_errors))
    {
        $email = $_POST['email'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        if($password1 != $password2)
        {
            $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> New password and confirm password does not match</p>";
        }
        else
        {
            try
            {
                $sqlQuery = "SELECT email FROM users WHERE email =:email";

                $statement = $DB_NAME->prepare($sqlQuery);

                $statement->execute(array(':email' => $email));

                if($statement->rowCount() == 1)
                {
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                    $sqlUpdate = "UPDATE users SET password =:password WHERE email =:email";

                    $statement = $DB_NAME->prepare($sqlUpdate);

                    $statement->execute(array(':password' => $hashed_password, ':email' => $email));

                    $result = "<p style='padding:20px; border: 1px solid gray; color: greed;'> Password Reset Successful</p>";
                }
                else
                {
                    $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> The email address provided does not exist in our database, please try again</p>";
                }
            }
            catch (PDOExecption $ex)
            {
                $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> An error has occurred:".$ex->getMesssage()."</p>";
            }

        }
    }
    else
    {
        if(count($form_errors) == 1)
        {
            $result = "<p style='color: red;'> There was 1 error in the form<br>";
        }
        else
        {
            $result = "<p style='color: red;'> There were " .count($form_errors). "errors in the form </br>";
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Password reset page</title>
</head>
<body>
<h2>User Authentication system </h2><hr>

<h3>Password Reset Form</h3>

<?PHP if(!isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
    <table>
        <tr><td>Email:</td> <td><input type="text" value="" name="new_password"></td></tr>
        <tr><td>New Password:</td> <td><input type="password" value="" name="new_password"></td></tr>
        <tr><td>Comfirm Password:</td> <td><input type="password" value="" name="confirm_password"></td></tr>
        <tr><td></td><td><input style="float: right;" type="submit" name="passwordResetBtn" value="reset Password"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>