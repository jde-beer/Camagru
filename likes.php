<?php 
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

if (htmlentities($_GET['img'])) {
		
    $img = htmlentities($_GET['img']);
    $sqlQuery = "SELECT * FROM likes WHERE imgid=:img";
    $statement = $DB_NAME->prepare($sqlQuery);
    $statement->execute(array(':img' => $img));
    $row = $statement->fetch();
    $imageOwner = $row['userid'];

    $query = "SELECT * FROM users WHERE username=:userid";
    $statement2 = $DB_NAME->prepare($query);
    $statement2->execute(array(':userid' => $row['userid']));
    $Row = $statement2->fetch();
    $RowEmail = $Row['email'];


    if ($statement->rowCount() > 0) {

        try {
            $query = $DB_NAME->prepare("SELECT * FROM likes WHERE userid=:userid");
            $query->execute(array(':userid' => $_SESSION['username']));
            $Row = $query->fetch();
        } catch (PDOException $e) {
            echo "An error occurred: ".$e->getMessage();
        }
        
        if ($query->rowCount() > 0) {

            try {
                $sqlDelete = $DB_NAME->prepare("DELETE FROM likes WHERE userid=:userid");
                $sqlDelete->execute(array(':userid' => $_SESSION['username']));
                header('Location: '.$_SERVER['HTTP_REFERER']);
            } catch (PDOException $e) {
                echo "An error occurred: ".$e->getMessage();
            }
        }else {
            $sqlIn = $DB_NAME->prepare("INSERT INTO likes (userid, imgid) VALUES (:userid, :imgid)");
            $sqlIn->execute(array(':userid' => $_SESSION['username'], ':imgid' => $img));

            if ($Row['preference'] == 'ON') {
                sendLikeEmail($RowEmail, $imageOwner, $_SESSION['username']);
            }

            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }else { 
        try {
            $sqlInsert = $DB_NAME->prepare("INSERT INTO likes (`userid`, `imgid`) VALUES (:userid, :imgid)");
            $sqlInsert->execute(array(':userid' => $_SESSION['username'], ':imgid' => $img));

            if ($Row['preference'] == 'ON') {
                sendLikeEmail($RowEmail, $imageOwner, $_SESSION['username']);
            }
            
            header('Location: '.$_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            echo "An error occurred: ".$e->getMessage();
        }
    }
}

?>