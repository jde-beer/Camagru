<?php
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if (isset($_POST['passwordResetBtn'])) 
{
    $email = htmlentities($_POST['email']);

    $sqlQuery = $DB_NAME->prepare("SELECT * FROM users WHERE email=:email");
    $sqlQuery->execute(array(':email'=>$email));
    $row = $sqlQuery->fetch();

   if($sqlQuery->rowCount() == 1)
   {
    $email = $row['email'];
    $username = $row['username'];
    $token = $row['token'];
    $verified = $row['verified'];
       if($verified == 'Y')
        {
            $pass = uniqid('');
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            sendForgotPasswordEmail ($email, $pass);

            $sqlUpdate = "UPDATE users SET password =:password WHERE email =:email";
            $statement = $DB_NAME->prepare($sqlUpdate);
            $statement->execute(array(':password' => $hashed_password, ':email' => $email));
        }
        else
        {
            sendVerificationEmail ($email, $token, $url);
        }
    }
    
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Forgot password page</title>
</head>
<body>
<h2>User Authentication system </h2><hr>

<h3>Forgot password page</h3>

<?PHP if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
    <table>
        <tr><td>Email:</td> <td><input type="Email" value="" name="email" required oninvalid="this.setCustomValidity('Enter Valid Email address here')" oninput="this.setCustomValidity('')" ></td></tr>
        <tr><td></td><td><input style="float: right;" type="submit" name="passwordResetBtn" value="reset Password"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>