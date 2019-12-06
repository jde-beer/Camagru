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

    if ($statement->rowCount() > 0) {

        try {
            $query1 = "SELECT * FROM likes WHERE userid=:userid";
            $query = $DB_NAME->prepare($query1);
            $query->execute(array(':userid' => $_SESSION['username']));
            $Row = $query->fetch();
        } catch (PDOException $e) {
            echo "An error occurred: ".$e->getMessage();
        }
        
        if ($query->rowCount() > 0) {

            try {
                $delete = "DELETE FROM likes WHERE userid=:userid";
                $sqlDelete = $DB_NAME->prepare($delete);
                $sqlDelete->execute(array(':userid' => $_SESSION['username']));
                header('Location: '.$_SERVER['HTTP_REFERER']);
            } catch (PDOException $e) {
                echo "An error occurred: ".$e->getMessage();
            }
        }else {
            $like = "INSERT INTO likes (userid, imgid) VALUES (:userid, :imgid)";
            $sqlIn = $DB_NAME->prepare($like);
            $sqlIn->execute(array(':userid' => $_SESSION['username'], ':imgid' => $img));

            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }else { 
        try {
            $likes = "INSERT INTO likes (userid, imgid) VALUES (:userid, :imgid)";
            $sqlInsert = $DB_NAME->prepare($likes);
            $sqlInsert->execute(array(':userid' => $_SESSION['username'], ':imgid' => $img));
            
            header('Location: '.$_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            echo "An error occurred: ".$e->getMessage();
        }
    }
}

?>