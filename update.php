<?php
include_once 'config/connect.php';
include_once 'config/utilities.php';
include_once 'config/session.php';

if(!isset($_SESSION['username'])){
    redirectTo("index");
}
else{
    $id = $_SESSION['id'];
    if(isset($_POST['ResetBtn'])){
        $username = htmlentities($_POST['new_username']);
        $password1 = htmlentities($_POST['new_password']);
        $password2 = htmlentities($_POST['retype_password']);
        $email = htmlentities($_POST['email']);
        if(isset($_POST['PrefBtn'])){
            $pref = htmlentities($_POST['PrefBtn']);
        }

        $form_errors = array();
        $form_success = array();
    }
    if(isset($email)){
        if(checkDuplicateUsername("users", "email", $email, $DB_NAME)){
        $form_errors[] = "Email address is already in use.";
        }
    }
    if(isset($username)){
        if(checkDuplicateUsername("users", "username", $username, $DB_NAME)){
        $form_errors[] = "Username is already in use";
        }
    }
    if(isset($password1)){
        if(!isset($password2)){
            $form_errors[] = "For password reset, both password fields are required";
        }
        if ($password1 != $password2){
            $form_errors[] = "Password and Retype password do not match.";
        }
    }
    if(!empty($username)){
        $form_errors = array_merge($form_errors, check_username($username));
        if(empty($form_errors)){ 
            try{        
                $queryupdate1 = "UPDATE users SET `username` = :username WHERE `id` = :id";
                $stmtupdate1 = $DB_NAME->prepare($queryupdate1);
                $stmtupdate1->execute(array(':username' => $username, ':id' => $id));
                $form_success[] = "Username reset was successful.";
                $_SESSION['username'] = $username;
            }
            catch (PDOException $err){
                $result = flashMessage("An error occured.".$err->getMessage());
            }
        }
        else{
                $result = flashMessage("Error(s): ".count($form_errors)."<br>");
        }
    }
    if(!empty($password1) && !empty($password2)){
        $form_errors = array_merge($form_errors, check_pass($password1));
        if(empty($form_errors)){ 
            try{
                $hased_password = password_hash($password1, PASSWORD_DEFAULT);
                $queryupdate2 = "UPDATE users SET `password` = :password WHERE `id` = :id";
                $stmtupdate2 = $DB_NAME->prepare($queryupdate2);
                $stmtupdate2->execute(array(':password' => $hased_password, ':id' => $id));
                $form_success[] = "Password reset was successful.";
            }
            catch (PDOException $err){
                $result = flashMessage("An error occured.".$err->getMessage());
            }
        }
        else{
            $result = flashMessage("Error(s): ".count($form_errors)."<br>");
        }
    }
    if(!empty($email)){
        $form_errors = array_merge($form_errors, check_email($_POST));      
        if(empty($form_errors)){ 
            try{
                $queryupdate3 = "UPDATE users SET `email` = :email WHERE `id` = :id";
                $stmtupdate3 = $DB_NAME->prepare($queryupdate3);
                $stmtupdate3->execute(array(':email' => $email, ':id' => $id));
                $form_success[] = "Email reset was successful.";
                $_SESSION['email'] = $email;
            }
            catch (PDOException $err){
                $result = flashMessage("An error occured.".$err->getMessage());
            }
        }
        else{
            $result = flashMessage("Error(s): ".count($form_errors)."<br>");
        }
    }
    // this is the preference php
    if(!empty($pref)){
        if(empty($form_errors)){ 
            try{
                $queryupdate4 = "UPDATE users SET `preference` = :preference WHERE `id` = :id";
                $stmtupdate4 = $DB_NAME->prepare($queryupdate4);
                $stmtupdate4->execute(array(':preference' => $pref, ':id' => $id));
                $form_success[] = "Notification preference was set to: ".$pref;
                $_SESSION['preference'] = $pref;
            }
            catch (PDOException $err){
                $result = flashMessage("An error occured.".$err->getMessage());
            }
        }
        else{
            $result = flashMessage("Error(s): ".count($form_errors)."<br>");
        }
    }
    if(isset($form_success) && !empty($form_success)){$result = flashMessage("Update(s): ".count($form_success)."<br>", "Pass");}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset Page</title>
</head>
<body>
    <h2>User Authentication System</h2><hr>
    <h3>Profile update</h3>

    <h4><?php echo $_SESSION['username']?></h4>
    <?PHP if(isset($result)) echo $result; ?>
    <?php if(!empty($form_errors)){echo show_errors($form_errors);}else{if(!empty($form_success))echo show_success($form_success);}?>
    <form action="" method="post">
        <table>
            <tr><td>Username:</td> <td><input type="text" value="" name="new_username" placeholder="New Username" ></td></tr>
            
            <tr><td>Email:</td> <td><input type="email" value="" name="email" placeholder="New Email" ></td></tr>
            <tr><td>Password:</td> <td><input type="password" value="" name="new_password" placeholder="New Password" ></td></tr>
            <tr><td>Re-type Password:</td> <td><input type="password" value="" name="retype_password" placeholder="Re-type Password" ></td></tr>
            <tr><td></td><td></td></tr>
            <!-- this is the preference html -->
            <tr><td>Notification preference:</td><td><?php echo $_SESSION['preference']?></td></tr>
            <tr><td>ON</td><td><input style='float:right'type="radio" name="PrefBtn" value="ON"></td></tr>
            <tr><td>OFF</td><td><input style='float:right'type="radio" name="PrefBtn" value="OFF"></td></tr>
            
            <tr><td></td><td><input style='float:right'type="submit" name="ResetBtn" value="Update profile"></td></tr>
        </table>
        </form>
    <p><a href="index.php">Back</a><br><a href="logout.php">Log out</a></p>
    
</body>
</html>
