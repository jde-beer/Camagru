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
                $fileNewName = uniqid('', true).".".$fileactuallyExt;
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
<h2>User Authentication System</h2><hr>
    <h3>Imagine uploader</h3>
<form action="" method="post" enctype="multipart/form-data">
        <table>
            <input type="file" name="file">
            <button type="submit" name="upload">upload</button>
        </table>
        </form>
</body>
</html>