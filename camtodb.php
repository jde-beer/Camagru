<?php
include_once 'config/session.php';
include_once 'config/connect.php';
include_once 'config/utilities.php';

//     //randomize image naming
//     $nameofpic = uniqid(''. true).".png";
//     // $filedesc = rand(1, 999);
//     // $filetitle = rand(1, 999);


//     //remove unnecessary info
//     $image = explode(',', $_POST['baseimage']);


//     //convert from base64 to image
//     $test = base64_decode($image[1]);


//     //PUT the contents where you want
//     file_put_contents("uploads/".$nameofpic, $test);
//     //echo $_POST['baseimage'];


//     //save image path/name with users ID to database table (gallery)
//     if((isset($_SESSION['username'])))
//     {
//         $sql = $DB_NAME->prepare("SELECT * FROM gallery");
//         $sql->execute();
//         $row = $sql->fetch();
//         $rowCount = $sql->rowCount();
//         $setImageOrder = $rowCount + 1;

//         $sqlQuery = "INSERT INTO gallery (userid, titleGallery, descGallery, imgFullNameGallery, orderGallery) values (:userid, :filename, :filetitle, :filedesc, :orderGallery)";
//         $statement = $DB_NAME->prepare($sqlQuery);
//         $statement->execute(array(':userid' => $_SESSION['username'], ':filename' => $nameofpic, ':filetitle' => "default", ':filedesc' =>  "default", ':orderGallery' => $setImageOrder));
//         echo "file was uploaded.";  
//     }
//     redirectTo("camera");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER["REQUEST_METHOD"] === "POST")
		{
			// this puts everything in to array.
            $pAr = ['caption' => $_POST['caption'], 'user'=>$_SESSION["id"]];
            try
			{
				// this inserts into the gallery.
				$sql = "INSERT INTO `gallery`(`userid`, `descGallery`, `imgFullNameGallery`) VALUES (:u,:p, 'DEFAULT')";
				$req = $DB_NAME->prepare($sql);
				$req->execute([
					'u' => $pAr['user'],
					'p' => $pAr['caption']
				]);
			}
			catch(PDOException $e)
			{
				echo "A thing went wrong: ".$e->getMessage();
			}
			try
			{
				//this finds the id of the image row that you just inserted into.
				$sql = "SELECT `id` FROM `gallery` WHERE `userid`=:u ORDER BY `time` DESC LIMIT 1;";
				$req = $DB_NAME->prepare($sql);
				$req->execute([
					'u' => $pAr['user']
				]);
				$ret = $req->fetch();
				$picID = $ret['id']; 
			}
			catch(PDOException $e)
			{
				echo "A thing went wrong: ".$e->getMessage();
			}
			//the image url
			$img = $_POST['imgUrl'];
			//sticker url
			$sti = $_POST['sURL'];
			//this allows php to understand the url.
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$sti = str_replace('data:image/png;base64,', '', $sti);
			$sti = str_replace(' ', '+', $sti);
			//this creates a image from the url.
			$imgData = base64_decode($img);
			$imgIMG = imagecreatefromstring($imgData);
			// this creates a image from the sticker
			$stiData = base64_decode($sti);
			$stiIMG = imagecreatefromstring($stiData);
			//this gets the height and width of the image.
			$w = imagesx ($imgData);
			$h = imagesy ($imgData);
			//this sets where you want to upload and the name of it.
			$file = "uploads/" . $picID .'.png';
			//prepares both images.
			imagealphablending($imgIMG, true);
			imagesavealpha($imgIMG, true);
			imagesavealpha($stiIMG, true);
			//this merges the two images.
			imagecopy($imgIMG, $stiIMG, 0, 0, 0, 0, $w, $h);
			//this just saves the image.
			imagePng($imgIMG, $file);
			redirectTo("index");
		}

?>