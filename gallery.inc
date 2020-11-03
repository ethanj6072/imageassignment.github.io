<a href = '?content=delete'>Delete JSON File</a>
<a href = '?content=deletetotal'>Delete All Entries</a>
<?php 
header("Location: index.php");
exit();
echo "<pre>";
if (!(isset($galleryarray))) { echo "No pictures have been submitted."; } else { var_dump($galleryarray); }
echo "</pre><br>";
if (is_dir($target_dir)){
  if ($dh = opendir($target_dir)){
    while (($file = readdir($dh)) !== false){
		if(!($file == '.' || $file == '..')) {
			echo "<img src='" . $target_dir . $file . "'><br>\n";
		}
    }
    closedir($dh);
  }
}
?>