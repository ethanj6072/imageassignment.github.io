<?php

// include thumbnail code
include  "createthumbnail.php";


// set source (create this folder and put this image there)
$src = "uploadedimages/0001.png";

// set destination (create this folder)
$dest = "thumbnails/dog.jpg";

// create a thumbnail of an image on the server
if (!file_exists($dest)) {
    createThumbnail($src, $dest, 100, 100);
}

if (!is_dir("thumbnails")) {
	mkdir("thumbnails");
}

// show original image
echo "<h1>The Original Image</h1>";
if (file_exists($src)) {
    echo "<body bgcolor='yellow'> <img src='" . $src . "' alt='horse'><br>";
} else {
    echo $src . " doesn't exist.<br>";
} // else   

// show thumbnail (refresh the thumbnail folder in WinSCP after 
// running this script, and a new image should appear)
echo "<h1>The Thumbnail</h1>";
if (file_exists($dest)) {
    echo "<img src='" . $dest . "' alt='horse'>";
} else {
    echo $dest . " did not get created. Check permissions on the folder.<br>";
} // else  
?>