
<?php
	include 'header.inc';
	$fNameErr = $lNameErr = $fileErr = $discErr = $tagsErr = $copyRightErr = $privacyErr = "";
	$fNameValue = $lNameValue = $discValue = $tagsValue = $checked = $privacy = $fileholder = "";
	$errorDisplay = "none";
	$output = "test";
	$file = "galleryinfo.json";
	$currentpage = "form.inc";
				
	$target_dir = "uploadedimages/";
	$currentUID = str_pad(file_get_contents("identifier.txt"), 4, '0', STR_PAD_LEFT);
	
	
	include "createthumbnail.php";
	
	echo "<a href = '?content=form'>Form</a>&nbsp
	<a href = 'index.php'>Gallery View</a>&nbsp
	<hr>";
	
	/*if (!isset($_GET["content"])) {
		header("Location: http://10.49.31.251/~ethan/form/index.php");
		exit();
	}*/
	
	if (isset($_GET["content"]) && $_GET["content"] == "gallery") {
		$currentpage = 'gallery.inc';
	} else {
		$currentpage = "form.inc";
	}
	
	if (isset($_GET["content"]) && ($_GET["content"] == "delete" || $_GET["content"] == "deletetotal")) {
		@unlink(realpath($file));
	}
	
	if (isset($_GET["content"]) && $_GET["content"] == "deletetotal") {
		recursiveDelete($target_dir);
		recursiveDelete("thumbnails/");
		file_put_contents("identifier.txt", "1");
    }
	
	if (!is_dir("uploadedimages")) {
		mkdir("uploadedimages");
	}
	
	if (!is_dir("thumbnails")) {
		mkdir("thumbnails");
	}
	
	if ($currentpage != 'gallery.inc') {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (empty($_POST["fname"])) {
				$fNameErr = "* First name required";
			} else {
				$_POST["fname"]= " " . correct_input($_POST["fname"]);
				$fNameValue = correct_input($_POST["fname"]);
				// check if fname only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["fname"])) {
				  $fNameErr = "* Only letters and white space allowed";
				}
			}
			
			if (empty($_POST["lname"])) {
				$lNameErr = "* Last name required";
			} else {
				$_POST["lname"] = " " . correct_input($_POST["lname"]);
				$lNameValue = correct_input($_POST["lname"]);
				// check if lname only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["lname"])) {
				  $lNameErr = "* Only letters and white space allowed";
				}
			}

			if (empty($_POST["description"]) || $_POST["description"] == "") {
				$discErr = "* Description required"; 
			} else {
				$_POST["description"] = correct_input($_POST["description"]);
				$discValue = correct_input($_POST["description"]);
				// check if discription only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["description"])) {
				  //$discErr = "* Only letters and white space allowed";
				  //commented out because their are prefectly good reasons to have numbers
				  // in a description
				}
			}

			if (empty($_POST["tags"])) {
				$tagsErr = "* Tag(s) required"; 
			} else {
				$_POST["tags"] = correct_input($_POST["tags"]);
				$tagsValue = correct_input($_POST["tags"]);
			}
			
			if (empty($_POST["copyright"])) {
				$copyRightErr = "* Please confirm that you retain the copyright to this image and release it for use on this site.";
				$_POST["copyright"] = "";
			} else {
				$_POST["copyright"] = "I retain the copyright to this image and release it for use on this site.";
				$checked = "checked";
			}
			
			if (empty($_POST["access"])) {
				$privacyErr = "* Select either public or private access.";
			} else {
				$_POST["access"] = correct_input($_POST["access"]);
				$privacy = $_POST["access"];
			}
			
			if (!(file_exists($file))) {
				touch($file);
			}
	
			if (!is_dir("uploadedimages")) {
				mkdir("uploadedimages");
			}
				
			$uploadOk = 1;
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$check = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
			}
			// check file size
			if ($_FILES["fileToUpload"]["size"] > 4000000) {
				$fileErr = "Sorry, your file is too large.";
				$uploadOk = 0;
			}
		  
			//allowed formats
			if($imageFileType !== "jpg" && $imageFileType !== "png") {
				$fileErr = "Sorry, but you have to submit a JPG or PNG file.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is wasn't set to 0 by an error
			if ($uploadOk == 1) {
			  $newFileName = $currentUID . "." . $imageFileType;
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newFileName)) {
				console_log("test");
				//add uid to $_POST
				$_POST["UID"] = $currentUID;
				// then imagetype
				$_POST["imagetype"] = $imageFileType;
				// do thumbnail
				createThumbnail($target_dir . $newFileName, 'thumbnails/' . $newFileName, 150, 150);
				// set identifier to current valueasint + 1 as string
				file_put_contents("identifier.txt", strval(intval($currentUID) + 1));
			  } else {
				$fileErr =  "Sorry, there was an error uploading your file.";
			  }
			}
			
			if ($fileErr !== "") {
				$errorDisplay = "block";
				$currentpage = 'form.inc';	
			} else if ($_POST["fname"] == "" || $_POST["lname"] == "" || $_POST["description"] == "" || $_POST["tags"] == ""
			|| $_POST["copyright"] == "" || $_POST["access"] == "") {
				$errorDisplay = "block";
				$currentpage = 'form.inc';				
			} else {
				// read json file into array of strings
				$jsonstring = file_get_contents($file);

				//decode the string from json to PHP array
				$galleryarray = json_decode($jsonstring, true);
				
				// add form submission to data (this does NOT remove submit button)
				$galleryarray[] = $_POST;

				// encode the php array to formatted json 
				$jsoncode = json_encode($galleryarray, JSON_PRETTY_PRINT);
				 
				// write the json to the file
				file_put_contents($file, $jsoncode); 
					
				$currentpage = 'gallery.inc';
			}
		} else {
			$currentpage = 'form.inc';
		}
	}

	include $currentpage;
	
	function correct_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
	}
	
	function recursiveDelete($str) {
		if (is_file($str)) {
			return @unlink($str);
		}
		elseif (is_dir($str)) {
			$scan = glob(rtrim($str,'/').'/*');
			foreach($scan as $index=>$path) {
				recursiveDelete($path);
			}
			return @rmdir($str);
		}
	}
	

?>
</body>
</html>