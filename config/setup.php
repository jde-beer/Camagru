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
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(20) NOT NULL,
       password VARCHAR(255) NOT NULL,
       email VARCHAR(100) NOT NULL,
       verified VARCHAR(1) NOT NULL DEFAULT 'N')";
       $conn->exec($query);
       echo "<p style='padding: 20px; color:green;'> Table: users, created\n</p>";
   }
   catch (PDOException $err) {
       echo "<p style='padding:20px; color:red;'> Table: users, not created\n".$err->getMessage()."</p>";
}
?>