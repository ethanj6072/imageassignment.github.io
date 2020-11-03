<?php
if (isset($_GET["content"]) &&  $_GET["content"] == "deleteall") {
	recursiveDelete("uploadedimages/");
	recursiveDelete("thumbnails/");
	file_put_contents("identifier.txt", "1");
	@unlink(realpath("galleryinfo.json"));
}
// replace uploaded images and thumbnails if missing for some reason
if (!is_dir("uploadedimages")) {
	mkdir("uploadedimages");
}
if (!is_dir("thumbnails")) {
	mkdir("thumbnails");
}

include 'index.inc';

//can delete everything in a folder from the bottom up, or alternatively just the one file
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
//console.log for php, used in error checking
function console_log($output, $with_script_tags = true) {
	$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
	if ($with_script_tags) {
		$js_code = '<script>' . $js_code . '</script>';
	}
	echo $js_code;
}
?>
