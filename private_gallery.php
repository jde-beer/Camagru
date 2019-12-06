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
                            $sql1 = "SELECT * FROM gallery";
                            $sql = $DB_NAME->prepare($sql1);
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
        footer{
        position: absolute;
        right:0; bottom:0;
    }
    .navbar {
        overflow: hidden;
        background-color: #333;
        }
    .navbar a {
        float: left;
        font-size: 16px;
        color: green;
        text-align: center;
        padding:: 14px 16px;
        text-decoration: none;
    }
    .dropdown{
        float: left;
        overflow: hidden;
    }
    .dropdown .dropbtn{
        font-size: 16px;
        border: none;
        outline: none;
        color: pink;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }
    .navbar a:hover, .dropdown:hover .dropbtn{
        background-color: grey;
    }
    .dropdown-content {
        display:none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a{
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }
    .dropdown-content a:hover{
        background-color: #ddd;
    }
    .dropdown:hover .dropdown-content{
        display: block;
    }
    a {
        text-decoration: none;   
    }
    </style>
</head>
<body>
<h1><i>Camagru</i></h1><hr>
    <div class="navbar">
        <a href="index.php">Home</a>
            <div class="dropdown">
                <?php if (isset($_SESSION['username'])): ?>
                <button class="dropbtn">Menu 
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                <a href="private_gallery.php">My Gallery</a>
                <a href="gallery.php">Public Gallery</a>
                <a href="camera.php">Photo Booth</a>
                  <a href="update.php">Update Profile</a>
                  <a href="logout.php">Logout</a>
                </div>
                <?php endif ?>
            </div> 
    </div>
    <section>
        <div >
            <h2>Gallery<h2>
            <header>
            <?PHP
            $sqlQuery = "SELECT * FROM gallery WHERE userid = :username";
            $statement = $DB_NAME->prepare($sqlQuery);
            $statement->execute(array(':username' => $_SESSION['username']));
            $all = $statement->rowCount();
            $total = 5;
            $page = '';
            if(!isset($_GET['page']))
            {
                $page = 1;
            }
            else
            {
                if (is_numeric($_GET['page']))
                {
                    $page = $_GET['page'];
                }
                else
                {
                    $page = 1;
                }
            }
            $all_pages = ceil($all/$total);

            $start = ($page-1) * $total;
            
            $sqlpage = "SELECT * FROM gallery WHERE userid = :username ORDER BY id DESC LIMIT $start, $total";
            $statement2 = $DB_NAME->prepare($sqlpage);
            $statement2->execute(array(':username' => $_SESSION['username']));
            while ($row = $statement2->fetch()) 
            {                               
                echo '<div>
                    <a href="comments.php?img='.$row["id"].'">
                    <img src="uploads/'.$row["descGallery"].'">
                    <a href=?delete='.$row["id"].'>Delete</a>
                    </a>
                    </div>';
            }
            echo "<br>";
            for ($i = 1; $i <= $all_pages; $i++)
            {
                echo "<a href='private_gallery.php?page=$i'> $i </a>";
            }
                       
            ?>
            </div>
            <?PHP        
            if(isset($_GET["delete"]))
            {
                $deleteimage = htmlentities($_GET["delete"]);

                $sqlquery = "DELETE FROM gallery where id = :id";
                $statement = $DB_NAME->prepare($sqlquery);
                $statement->execute(array(':id' => $deleteimage));
                unlink("uploads/".$deleteimage.".png");
                redirectTo("private_gallery");
            }
            
        ?>
         </header>
        
    </section>
    
</body>
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>