<?php
include_once 'config/connect.php';

if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    try
    {
        $sqlInsert = "INSERT INTO users (`email`, `username`, `password`, `join_date`) VALUES (:email, :username, :password, now())";

        $statement = $DB_NAME->prepare($sqlInsert);
        $statement->execute(array(':email' => $email, ':username' => $username, ':password' => $hashed_password));

        if($statement->rowCount() == 1)
        {
            $result = "<p style='padding:20px; color: green;'> Registration Successful</p>";
        }
    }
    catch (PDOException $ex)
    {
        $result = "<p>An error occurred: ".$ex->getMessage()."</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Register Page</title>
</head>
<body>
<h2>User Authentication system </h2><hr>
<h3>Registration Form</h3>

<?php if(isset($result)) echo $result;?>

<form method="post" action="">
    <table>
    <tr><td>Email:</td> <td><input type="Email" value="" name="email" required oninvalid="this.setCustomValidity('Enter Valid Email address here')" oninput="this.setCustomValidity('')" ></td></tr>
    <tr><td>Username:</td> <td><input type="text" value="" name="username" required oninvalid="this.setCustomValidity('Username should be atleast 6 characters long')" oninput="this.setCustomValidity('')" ></td></tr>
    <tr><td>Password:</td> <td><input type="password" value="" name="password"required oninvalid="this.setCustomValidity('Password must contain one uppercase letter and special character')" oninput="this.setCustomValidity('')" ></td></tr>
    <tr><td></td><td><input style="float: right;" type="submit" value="Signup"></td></tr>
    </table>
</form>
<p><a href="login.php">Login</a></p>
<p><a href="index.php">Back</a></p>
</body>
</html>