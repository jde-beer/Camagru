<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(isset($_POST['submit']))
{
    $newFileName = $_POST['filename'];
    if(empty($_POST['filename']))
    {
        $newFileName = uniqid('');
    }
    else
    {
        $newFileName = strtolower(str_replace(" ", "-", $newFileName));
    }
    $filetitle = $_POST['filetitle']; 
    $filedesc = $_POST['filedesc'];

    $file = $_FILES['file'];

    $fileName = $file["name"];
    $filetype = $file["type"];
    $filetempname = $file['tmp_name'];
    $fileError = $file['error'];
    $filesize = $file['size'];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allow = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allow))
    {
        if ($file === 0)
        {
            if($filesize < 100000)
            {
                $imagefullname = $fileNewName.".".uniqid('', true).".".$fileactuallyExt;
                $fileDestination = 'uploads/'.$imagefullname;
                //move_uploaded_file($filetempname, $fileDestination);
                //header("Location: index.php?uploadsuccesss");

                if (empty($filetitle) || empty($filedesc))
                {
                    header("Location: ../gallery.php?upload=empty");
                    exit();
                }
                else
                {
                    $sqlQuery = "SELECT * FROM gallery";
                    $statement = $DB_NAME->prepare($sqlQuery);
                    $statement->execute(array());
                    // while($row = $statement->fetch())
                    // {
                    //         echo 
                    // }
                }
            }
            else
            {
                $result = flashMessage("The file was to big!");
            }
        }
        else{
            $result = flashMessage("echo you had a error");
        }
    }
    else
    {
        $result = flashMessage("incorrect file type");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
</head>
<body>
    <section class="gallery-links">
        <div class="wrapper">
            <h2>Gallery<h2>
            <div class="gallery-container">
                <a href="#">
                <div></div>
                <h3>Tile</h3>
                <p>Paragraph</p>
                </a>
                <a href="#">
                <div></div>
                <h3>Tile</h3>
                <p>Paragraph</p>
                </a>
                <a href="#">
                <div></div>
                <h3>Tile</h3>
                <p>Paragraph</p>
                </a>
                <a href="#">
                <div></div>
                <h3>Tile</h3>
                <p>Paragraph</p>
                </a>
                <a href="#">
                <div></div>
                <h3>Tile</h3>
                <p>Paragraph</p>
                </a>
            </div>
            <?PHP if(isset($_SESSION['username']))
            {
                echo'<div class="gallery-upload">                
                <form action="fileupload.php" method="post" enctype="multipart/form-data">
                <input type="text" name="filename" placeholder="file name">
                <input type="text" name="filetitle" placeholder="image title">
                <input type="text" name="filedesc" placeholder="file description">
                <input type="file" name="file">
                <button type="submit" name="submit>">UPLOAD</button>
                </form>
                </div>';
            }
        ?>
    </section>
    
</body>
</html>

