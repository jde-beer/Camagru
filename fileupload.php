<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(isset($_POST['upload']))
{
    
    $file = $_FILES['file'];
    $filename = $_FILES['file']['name'];
    $filetempname = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $filesize = $_FILES['file']['size'];
    $filetype = $_FILES['file']['type'];

    $fileExt = explode('.', $filename);
    $fileactuallyExt = strtolower(end($fileExt));

    $allow = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileactuallyExt, $allow))
    {
        if($fileError === 0)
        {
            if($filesize < 100000)
            {
                $fileNewName = uniqid('', true).".".$fileactuallyExt."png";
                $fileDestination = 'uploads/'.$fileNewName;
                move_uploaded_file($filetempname, $fileDestination);
                //header("Location: index.php?uploadsuccesss");
            }
            else{
                $result = flashMessage("The file was to big!");
            }

        }
        else 
        {
            $result = flashMessage("There was a error!");
        }

    }
    else
    {
        $result = flashMessage("This imagine cannot be uploaded!");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Imagine uploader</title>
</head>
<body>
<!-- <?PHP 
    // if (isset($_SESSION['id']))
    // {
    //     if($_SESSION['id'] == 1)
    //     {
    //         $esult = flashMessage("You are logged is as user #1");
    //     }
    //     echo "<form action='' method='POST' enctype='multipart/form-data'>
    //     <table>
    //         <input type='file' name='file'>
    //         <button type='submit' name='upload'>upload</button>
    //     </table>
    //     </form>";
    // }
    // else
    // {
    //     $result = flashMessage("You are not logged in.");
    //     $result = flashMessage("Not yet a member? <a href='signup.php'>signup</a>");
    // }

    // if(isset($result)) echo $result;
    // if(!empty($form_errors)) echo show_errors($form_errors);
    ?> -->
<h2>User Authentication System</h2><hr>
    <h3>Imagine uploader</h3>
<form action="" method="post" enctype="multipart/form-data">
        <table>
            <input type="file" name="file">
            <button type="submit" name="upload">upload</button>
        </table>
        </form>
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>