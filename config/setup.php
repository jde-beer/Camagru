<?PHP
include "database.php";
echo "<h2>Camagru setup</h2>";

try {
   $conn = new PDO($DB_SERVER, $DB_USER, $DB_PASSWORD);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $query = "CREATE DATABASE ".$DB_NAME."";
   $conn->exec($query);
   echo "<p style='padding: 20px; color:green;'> Database created\n</p>";
}
catch (PDOException $err) {
   echo "<p style='padding:20px; color:red;'> Database not created\n".$err->getMessage()."</p>";
}

try {
   $conn = new PDO($DB_SERVER_DB, $DB_USER, $DB_PASSWORD);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $query = "CREATE TABLE users (
       `id` INT AUTO_INCREMENT PRIMARY KEY,
       `email` VARCHAR(100) NOT NULL UNIQUE,
       `username` VARCHAR(20) NOT NULL UNIQUE,
       `password` VARCHAR(255) NOT NULL,
       `verified` VARCHAR(100) NOT NULL DEFAULT 'N',
       `preference` VARCHAR(3) NOT NULL DEFAULT 'ON',
       `token` VARCHAR(100) NOT NULL,
       `join_date` TIMESTAMP)";
       $conn->exec($query);
       echo "<p style='padding: 20px; color:green;'> Table: users, created\n</p>";
   }
   catch (PDOException $err) 
   {
       echo "<p style='padding:20px; color:red;'> Table: users, not created\n".$err->getMessage()."</p>";
   }

try {
   // Connect to DATABASE previously created
   $conn = new PDO($DB_SERVER_DB, $DB_USER, $DB_PASSWORD);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $query = "CREATE TABLE  profileimg(
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `userid` INT(11) NOT NULL,
      `status` INT(11) NOT NULL
   )";
   $conn->exec($query);
   echo "<p style='padding: 20px; color:green;'> Table: profile, created\n</p>";
}
   catch (PDOException $err) 
   {
      echo "<p style='padding:20px; color:red;'> Table: profile, not created\n".$err->getMessage()."</p>";
   }

try {
      // Connect to DATABASE previously created
      $conn = new PDO($DB_SERVER_DB, $DB_USER, $DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "CREATE TABLE  gallery(
         `id` INT AUTO_INCREMENT PRIMARY KEY,
         `userid` LONGTEXT NOT NULL,
         `descGallery` LONGTEXT NOT NULL,
         `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
      )";
      $conn->exec($query);
      echo "<p style='padding: 20px; color:green;'> Table: Gallery, created\n</p>";
   }
      catch (PDOException $err) 
      {
         echo "<p style='padding:20px; color:red;'> Table: users, not created\n".$err->getMessage()."</p>";
      }
try {
      // Connect to DATABASE previously created
      $conn = new PDO($DB_SERVER_DB, $DB_USER, $DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "CREATE TABLE `comments` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `userid` VARCHAR(128) NOT NULL,
            `imgid` LONGTEXT NOT NULL,
            `date` datetime NOT NULL,
            `comment` LONGBLOB NOT NULL
         )";
         $conn->exec($query);
         echo "<p style='padding: 20px; color:green;'> Table: comments created successfully</p>";
     } 
     catch (PDOException $err) 
     {
         echo "<p style='padding:20px; color:red;'> Table: comments, not created\n".$err->getMessage()."</p>";
     }

     try {
      // Connect to DATABASE previously created
      $conn = new PDO($DB_SERVER_DB, $DB_USER, $DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query = "CREATE TABLE `likes` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `userid` VARCHAR(128) NOT NULL,
            `imgid` LONGTEXT NOT NULL,
            `likes` VARCHAR(100) NOT NULL DEFAULT 'N',
            `likecount` int(11)
         )";
         $conn->exec($query);
         echo "<p style='padding: 20px; color:green;'> Table: Likes created successfully</p>";
     } 
     catch (PDOException $err) 
     {
         echo "<p style='padding:20px; color:red;'> Table: Likes, not created\n".$err->getMessage()."</p>";
     }
?>