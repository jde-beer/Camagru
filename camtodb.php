<?php
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

    //randomize image naming
    $nameofpic = uniqid(''. true).".png";
    // $filedesc = rand(1, 999);
    // $filetitle = rand(1, 999);


    //remove unnecessary info
    $image = explode(',', $_POST['baseimage']);


    //convert from base64 to image
    $test = base64_decode($image[1]);


    //PUT the contents where you want
    file_put_contents("uploads/".$nameofpic, $test);
    //echo $_POST['baseimage'];


    //save image path/name with users ID to database table (gallery)
    if((isset($_SESSION['username'])))
    {
        $sql = $DB_NAME->prepare("SELECT * FROM gallery");
        $sql->execute();
        $row = $sql->fetch();
        $rowCount = $sql->rowCount();
        $setImageOrder = $rowCount + 1;

        $sqlQuery = "INSERT INTO gallery (userid, titleGallery, descGallery, imgFullNameGallery, orderGallery) values (:userid, :filename, :filetitle, :filedesc, :orderGallery)";
        $statement = $DB_NAME->prepare($sqlQuery);
        $statement->execute(array(':userid' => $_SESSION['username'], ':filename' => $nameofpic, ':filetitle' => "default", ':filedesc' =>  "default", ':orderGallery' => $setImageOrder));
        echo "file was uploaded.";  
    }
    redirectTo("camera");
?>