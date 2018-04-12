<?php
function tjekBillede($billede){
    if ($billede['size']>0) {
        return true;
    }else {
        return false;
    }
}

function visBillede($value, $dest){
    if (is_file($dest.$value)) {
        $img = '<img class="img-responsive" src="'.$dest.$value.'" alt="'.$value.'">';
    }else{
        $img = '<p style="color:red">INTET BILLEDE</p>';
    }
    return $img;
}
function haandterFil($fil, $dest, $gammelFil=null){
    if ($gammelFil !== null) {
        // Så slet den!
        if (is_file($dest.$gammelFil)) {
            unlink($dest.$gammelFil);
        }
    }
    if($fil['error'] === 0 && $fil['size'] > 0){
        $filnavn = $fil['name'];
        // Filen flyttes til server
        move_uploaded_file($fil['tmp_name'], $dest . $filnavn);
    }
    
    return $filnavn;
}

if ($_POST) {
	$target_dir = "prod_image/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$fileName = "";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$fileName = "";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$fileName = "";
		$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$fileName = "";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		$fileName = "";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			$fileName = basename( $_FILES["fileToUpload"]["name"]);
		} else {
			echo "Sorry, there was an error uploading your file.";
			$fileName = "";
		}
	}
}