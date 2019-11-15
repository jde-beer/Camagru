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

            $sqlSelect = "SELECT * FROM gallery WHERE titleGallery=:titleGallery";
            $statement2 = $DB_NAME->prepare($sqlSelect);
            $statement2->execute(array(':titleGallery' => $img));
            $row = $statement2->fetch();
            $rowUserId = $row['userid'];

            $sqlQuery2 = "SELECT * FROM users WHERE username=:username";
            $statement3 = $DB_NAME->prepare($sqlQuery2);
            $statement3->execute(array(':username' => $rowUserId));
            $Row = $statement3->fetch();
            $RowUserName = $Row['username'];
            $RowEmail = $Row['email'];

            if(isset($_POST['like'])) 
            {
                $counter++;
                // $sqlQuerylike = "SELECT * FROM likes WHERE likes=:likes";
                // $statementlike = $DB_NAME->prepare($sqlQuerylike);
                // $statementlike->execute(array(':likes' => $like));
                // $Row = $statement3->fetch();

            }
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
$counter = 0;


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


</style>

</head>
<body>

<?php


$img = htmlentities($_GET['img']);
echo '<img src="uploads/'.$img.'">';
if (isset($_SESSION['id'])) {
    echo "<form method='POST' action='".setComment($DB_NAME)."'>
    <input type='hidden' name='uid' value='".$_SESSION['username']."'>
    <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
    <p style='text-align: center;'>$counter</p>
    <button type='submit' name='like'>like</button>
    <textarea name='comment' placeholder='Comment'></textarea><br>   
    <button type='submit' name='commentSubmit'>Comment</button>
</form>";
}

getComments($DB_NAME);
?>
