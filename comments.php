<?PHP
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

date_default_timezone_set('Africa/Johannesburg');

function setComment($DB_NAME) 
{
    if (isset($_POST['commentSubmit'])) {
        $uid = htmlentities($_POST['uid']);
        $date = htmlentities($_POST['date']);
        $comment = htmlentities($_POST['comment']);
        $img = htmlentities($_GET['img']);

        try 
        {
            $sqlQuery = "INSERT INTO comments (userid, imgid, date, comment) VALUES (:uid, :imgid, :d, :comment)";
            $statement = $DB_NAME->prepare($sqlQuery);
            $statement->execute(array(':uid' => $uid, ':imgid' => $img, ':d' => $date, ':comment' => $comment));

            $sqlSelect = "SELECT * FROM gallery WHERE id=:descGallery";
            $statement2 = $DB_NAME->prepare($sqlSelect);
            $statement2->execute(array(':descGallery' => $img));
            $row = $statement2->fetch();
            $rowUserId = $row['descGallery'];

            $sqlQuery2 = "SELECT * FROM users WHERE username=:username";
            $statement3 = $DB_NAME->prepare($sqlQuery2);
            $statement3->execute(array(':username' => $rowUserId));
            $Row = $statement3->fetch();
            $RowUserName = $Row['username'];
            $RowEmail = $Row['email'];

            sendCommentEmail($RowEmail, $RowUserName, $uid, $comment);
        } catch (PDOException $err) {
            echo "An errorr occurred: ".$err->getMessage();
        }
    }
}

function getComments($DB_NAME) 
{

    $img = htmlentities($_GET['img']);
    $sql = "SELECT * FROM comments WHERE imgid=:imgid ORDER BY id DESC";
    $statement4 = $DB_NAME->prepare($sql);
    $statement4->execute(array(':imgid' => $img));
    
    while ($row = $statement4->fetch()) {
        echo "<div class='comment-box'><p>";
            echo $row['userid']."<br>";
            echo $row['date']."<br><br>";
            echo nl2br($row['comment']);
        echo "</p></div>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Comments Page</title>

<style type="text/css">
    
    body {
        background-color: #ddd;
    }

    iframe {
        width: 853px;
        height: 480px;
        border: 1px #999 solid;
    }

    textarea {
        width: 800px;
        height: 80px;
        background-color: #fff;
        resize: none;
        display:block;
        margin-left: auto;
        margin-right: auto;
    }

    button {
        width: 100px;
        height: 30px;
        background-color: #282828;
        border: none;
        color: #fff;
        font-family: arial;
        font-weight: 400;
        cursor: pointer;
        margin-bottom: 20px;
        display:block;
        margin-left: auto;
        margin-right: auto;
    }

    .comment-box {
        width: 768px;
        padding: 20px;
        margin-bottom: 4px;
        background-color: #fff;
        border-radius: 4px;
        display:block;
        margin-left: auto;
        margin-right: auto;
    }

    .comment-box p {
        font-family: arial;
        font-size: 14px;
        line-height: 16px;
        color: #282828;
        font-weight: 100;
    }

    img	{
        display:block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        height: 50%;
        margin-bottom: 20px;
    }
    footer{
        position: absolute;
        right:0; bottom:0;
    }
    .test{
        width: 100px;
        height: 30px;
        border: none;
        font-family: arial;
        font-weight: 400;
        cursor: pointer;
        margin-bottom: 20px;
        display:block;
        margin-left: auto;
        margin-right: auto;        
    }
    body {
        position: relative;
        min-height: 100%;
        min-height: 100vh;
        }
        footer {
        position: absolute;
        right: 0;bottom:0;
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
</div>

<?php


$img = htmlentities($_GET['img']);
try{
    $sqlcheck = "SELECT * FROM gallery where id = :id";
    $statementcheck = $DB_NAME->prepare($sqlcheck);
    $statementcheck->execute(array(':id' => $img));
    $Row = $statementcheck->fetch();
    
    if(isset($Row['id']))
    {
        echo '<img src="uploads/'.$img.'.png">';
    }
    else
    {
        redirectTo("gallery");
    }
}
catch (PDOException $err) 
     {
         echo "Error Page not found ".$err->getMessage();
     }

    $sqllikes = "SELECT * FROM likes where imgid = :img";
    $statmentlike = $DB_NAME->prepare($sqllikes);
    $statmentlike->execute(array(':img'=> $img));
    $counter = 0;
while($row = $statmentlike->fetch())
{
    $counter++;
}
// only shows if your logged in
if (isset($_SESSION['id'])) {
    echo "<form method='POST' action='".setComment($DB_NAME)."'>
    <input type='hidden' name='uid' value='".$_SESSION['username']."'>
    <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
    <p style='text-align: center;'>$counter</p>
    <a class='test' href ='likes.php?img=$img'>like</a>
    <textarea name='comment' placeholder='Comment'></textarea><br>   
    <button type='submit' name='commentSubmit'>Comment</button>
</form>";
}

getComments($DB_NAME);
?>

<!-- <p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">logout</a> </p> -->
<footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>