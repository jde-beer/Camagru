<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if(!isset($_SESSION['username']))
{
    redirectTo("index");
}
else
{
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
        $filetitle = htmlentities($_POST['filetitle']); 
        $filedesc = htmlentities($_POST['filedesc']);

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
            if ($fileError === 0)
            {
                if($filesize < 50000000)
                {
                    $imagefullname = $newFileName.".".uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/'.$imagefullname;
                    move_uploaded_file($filetempname, $fileDestination);

                    if (empty($filetitle) || empty($filedesc))
                    {
                        header("Location: gallery.php?upload=empty");
                    }
                    else
                    {
                        try 
                        {
                            $sql = $DB_NAME->prepare("SELECT * FROM gallery");
                            $sql->execute();
                            $row = $sql->fetch();
                            $rowCount = $sql->rowCount();
                            $setImageOrder = $rowCount + 1;

                            $sqlQuery = "INSERT INTO gallery (userid, titleGallery, descGallery, imgFullNameGallery, orderGallery) values (:username, :filename, :filetitle, :filedesc, :orderGallery)";
                            $statement = $DB_NAME->prepare($sqlQuery);
                            $statement->execute(array(':username' => $_SESSION['username'], ':filename' => $imagefullname, ':filetitle' => $filetitle, ':filedesc' =>  $filedesc, ':orderGallery' => $setImageOrder));
                            echo "file was uploaded.";
                        } 
                        catch (PDOException $e) 
                        {
                            echo "An errorr occurred: ".$e->getMessage();
                        }
                    }
                
                }
                else
                {
                    echo "The file was to big!";
                }
            }
            else
            {
                echo "echo you had a error";
            }
        }
        else
        {
            echo "incorrect file type";
        }
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
    <style>
        body{
            margin: 20;
        }
        header{
            margin: .5vw;
            font-size: 20;
        }
        header div{
            flex: auto;
            display:inline-block;
            margin: 10px;
        }
        header div img{
            width: 250px;
            height: 200px;
            border: solid 2px black;
            margin: 2px;
        }
    </style>
</head>
<body>
    <section>
        <div >
            <h2>Gallery<h2>
            <header>
            <?PHP
            $sqlQuery = "SELECT * FROM gallery WHERE userid = :username ORDER BY id DESC";
            $statement = $DB_NAME->prepare($sqlQuery);
            $statement->execute(array(':username' => $_SESSION['username']));
            
            while ($row = $statement->fetch()) 
            {                               
                echo '<div>
                    <a href="#">
                    <img src="uploads/'.$row["titleGallery"].'">
                    <h3>'.$row["imgFullNameGallery"].'</h3>
                    <p>'.$row["descGallery"].'</p>
                    </a>
                    </div>';
            }
            ?>
            </div>
            <?PHP if(isset($_SESSION['username']))
            {
                echo'<div>                
                <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="filename" placeholder="file name">
                <input type="text" name="filetitle" placeholder="image title">
                <input type="text" name="filedesc" placeholder="file description">
                <input type="file" name="file">
                <button type="submit" name="submit">UPLOAD</button>
                </form>
                </div>';
            }
            
        ?>
        <p>Not yet a member? <a href="signup.php">signup</a> </p>
        <p><a href="login.php">Login</a></p>
        <p><a href="index.php">Back</a></p>
        </header>
        
    </section>
    
</body>
</html>