<?PHP

function check_empty_fields($required_fields_array)
{
    $form_errors = array();

    foreach($required_fields_array as $name_of_field)
    {
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL)
        {
            $form_errors[] = $name_of_field . " is a required field";
        }
    }
    return $form_errors;
}

function check_username($username)
{
    $form_errors = array();

    if(preg_match('/\\s/',$username))
    {
        $form_errors[] = "username must not contain spaces.";
    }
    if(!preg_match('/^(?=.*\d)[a-zA-Z\d]{5,20}$/', $username))
    {
        $form_errors[] = "username must be between 5-20 characters long <br> and contain at least one number.";   
    }
    return $form_errors;
}

function check_min_length($field_to_check_length)
{
    $form_errors = array();

    foreach($field_to_check_length as $name_of_field => $minimum_length_required)
    {
        if(strlen(trim($_POST[$name_of_field])) < $minimum_length_required)
        {
            $form_errors[] = $name_of_field . " is too short, must be {$minimum_length_required} characters long";
        }
    }
    return $form_errors;
}

function check_pass($password){
    $form_errors = array();

    if(preg_match('/\\s/',$password))
    {
        $form_errors[] = "password must not contain spaces.";
    }
    if(!preg_match('/^(?=.*\d)[a-zA-Z\d]{5,20}$/', $password))
    {
        $form_errors[] = "password must be between 5-20 characters long <br> and contain at least one number.";   
    }
    return $form_errors;
}
function check_email($data)
{
    $form_errors = array();
    $key = 'email';

    if(array_key_exists($key, $data))
    {
        if($_POST[$key] != null)
        {
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === FALSE)
                $form_errors[] = $key . " is not a valid email address";

        }
    }
    return $form_errors;
}
function show_success($form_success_array)
{
    $success = "<p><ul style='color:green;list-style-type:circle;'>";
    
    foreach($form_success_array as $the_success)
    {
        $success .="<li>{$the_success}<li>";
    }
    $success .= "</ul></p>";
    return $success;
}

function show_errors($form_errors_array)
{
    $errors = "<p><ul style='color: red;'>";

    foreach($form_errors_array as $the_error)
    {
        $errors .= "<li>{$the_error}</li>";
    }
    $errors .= "</ul></p>";
    return $errors;
}

function flashMessage($message, $passorfail = "Fail")
{
    if($passorfail === "Pass")
    {
        $data = "<p style='padding:20px; border: 1px solid gray; color green;'>{$message}</p>";
    }
    else
    {
        $data = "<p style='padding:20px; border: 1px solid gray; color red;'>{$message}</p>";
    }
    return $data;
}

function redirectTo($page)
{
    header("Location:{$page}.php");
}

function checkDuplicateUsername($table, $column_name, $value, $DB_NAME)
{
    try
    {
        $sqlQuery = "SELECT username FROM ".$table." WHERE ".$column_name."=:".$column_name;
        $statement = $DB_NAME->prepare($sqlQuery);
        $statement->execute(array(":".$column_name => $value));

        if($row = $statement->fetch())
            return true;
        return false;
    }
    catch (PDOException $ex)
    {

    }
}

function sendVerificationEmail ($email, $token, $url) {
    
    $subject = "[Meme(Me)] - Email Verification";

    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: <camagru@no-reply.co.za>'."\r\n";

    $message = '
    <html>
        <head>
            <title>'.$subject.'</title>
        </head>
        <body>
            Thanks for registering to Meme(Me)
            To finalize the registration process please click the link below <br>
            <a href="http://'.$url.'/verify.php?token='.$token.'">Verify my email</a>
            If this was not you, please ignore this email and the address will not be used.
        </body>
    </html>
    ';

    $retval = mail($email, $subject, $message, $headers);
    
    if ($retval == true) {
        echo "Message sent successfully...";
    } else {
        echo "Message could not be sent...";
    }
}

function sendForgotPasswordEmail ($email, $password) {
    
    $subject = "[Meme(Me)] - Password Reset";

    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: <camagru@no-reply.co.za>'."\r\n";

    $message = '
    <html>
        <head>
            <title>'.$subject.'</title>
        </head>
        <body>
            This is your new password, You can reset once logged in.<br>
            '.$password.'
        </body>
    </html>
    ';

    $retval = mail($email, $subject, $message, $headers);
    
    if ($retval == true) {
        echo "Message sent successfully...";
    } else {
        echo "Message could not be sent...";
    }
}

// function verify($token)
// {
//     try
//     {
//         if (isset($_GET['token']) && !empty($_GET['token'])) 
// {
//     $token = $_GET['token'];

//     $sqlQuery = $DB_NAME->prepare("SELECT id FROM users WHERE token='".$token."'");
//     $sqlQuery->execute();
//     $row = $sqlQuery->fetch();

//     if ($row > 0) 
//     {
//         $query = $DB_NAME->prepare("UPDATE users SET verified='Y' WHERE id = :id");
//         $query->execute(array('id' => $row['id']));
//         $result = flashMessage("Your acount has been verified, you can now login", "Pass");
//     } 
//     else 
//     {
//         $result = flashMessage("The url is either invalid or you already verified your account.");
//     }
// }
//     }
//     catch (PDOException $ex)
//     {

//     }
// }
?>