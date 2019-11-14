<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if (isset($_POST['EmailResetBtn'])) 
{
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $username = htmlentities($_POST['username']);

    $sqlQuery = $DB_NAME->prepare("SELECT * FROM users WHERE username=:username");
    $sqlQuery->execute(array(':username'=>$username));
    $row = $sqlQuery->fetch();

   if($sqlQuery->rowCount() == 1)
   {
    $email = $row['email'];
    $username = $row['username'];
    $token = $row['token'];
    $verified = $row['verified'];
    $hashed_password = $row['password'];

       if($verified == 'Y' && password_verify($password, $hashed_password))
        {    
            $sqlUpdate = "UPDATE users SET  email=:email WHERE username =:username";
            $statement = $DB_NAME->prepare($sqlUpdate);
            $statement->execute(array(':password' => $hashed_password, ':email' => $email));

            $result = flashMessage( "First verify your email, The email verification was sent to the new email address.");
            sendVerificationEmail ($email, $token, $url);
            $query = $DB_NAME->prepare("UPDATE users SET verified='N' WHERE id = :id");
            $query->execute(array('id' => $row['id']));
        }
        else
        {
            $result = flashMessage( "First verify your email, The email verification was resent.");
            //sendVerificationEmail ($email, $token, $url);
        }
    }
    
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Email Reset page</title>
</head>
<body>
<h2>User Authentication system </h2><hr>

<h3>Email Reset page</h3>

<?PHP if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form method="post" action="">
    <table>
        <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
        <tr><td>Email:</td> <td><input type="Email" value="" name="email" required oninvalid="this.setCustomValidity('Enter Valid Email address here')" oninput="this.setCustomValidity('')" ></td></tr>
        <tr><td>New Email:</td> <td><input type="Email" value="" name="new email" required oninvalid="this.setCustomValidity('Enter Valid Email address here')" oninput="this.setCustomValidity('')" ></td></tr>
        <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
        <tr><td></td><td><input style="float: right;" type="submit" name="EmailResetBtn" value="Email Reset"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>

