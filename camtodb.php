<?php
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

    //randomize image naming
    $nameofpic = uniqid(''. true).".png";


    //remove unnecessary info
    $image = explode(',', $_POST['baseimage']);


    //convert from base64 to image
    $test = base64_decode($image[1]);


    //PUT the contents where you want
    file_put_contents("uploads/".$nameofpic, $test);
    //echo $_POST['baseimage'];


    //save image path/name with users ID to database table (gallery)


?>