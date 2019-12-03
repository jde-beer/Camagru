<?php
	include_once 'config/session.php';
	include_once 'config/connect.php';
	include_once 'config/utilities.php';

	//$usrname = $_SESSION['username'];
	$base = $_POST['imgUrl'];
	$sticker = $_POST['sURL'];
	

	if (!empty($base)){
		
		$imgName = "cameraEdit.".uniqid().".png";
		$imgPath = "uploads/".$imgName;
		$imgUrl = str_replace("data:image/png;base64,", "", $base);
		$imgUrl = str_replace(" ", "+", $imgUrl);
		$imgDecoded = base64_decode($imgUrl);
		file_put_contents($imgPath, $imgDecoded);

		if (isset($sticker) && !empty($sticker)) {

			$overLayImage = "OverLay".uniqid().".png";
			$overLayPath = "uploads/".$overLayImage;
			$sUrl = str_replace("data:image/png;base64,", "", $sticker);
			$sUrl = str_replace(" ", "+", $sUrl);
			echo $sUrl;
			$imgDecoded = base64_decode($sUrl);
			file_put_contents($overLayPath, $imgDecoded);
		}

		if (isset($base) && isset($sticker)) {

			$dst = imagecreatefrompng($imgPath);
			$src = imagecreatefrompng($overLayPath);

			imagecopy($dst, $src, 10, 9, 0, 0, 75, 75);
			imagepng($dst, $imgPath);

			imagedestroy($dst);
			imagedestroy($src);
			unlink($overLayPath);
		}

		try{
	        $query = $db->prepare("INSERT INTO gallery (userid, descGallery) VALUES (:userid, :descG)");
	        $query->execute(array(':userid' => $_SESSION['username'], ':desG' => $imgName));

	    } catch (PDOException $e){
	        echo "An error occurred: ".$e->getMessage();
	    }
	}
?>