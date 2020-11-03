<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Gallery</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type = "text/css" href="style.css">
		<!-- Load icon library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body><h1>Gallery</h1>
		<a href = "form.php?content=form">Upload Image</a>
		<a href = "?content=deleteall">Reset Gallery</a>
		<a href = "downloadall.php" download>Download All</a><br>
		<div class="dropdown">
		  <button class="dropbtn">Image Options</button>
		  <div class="dropdown-content">
			<div onclick="loadImages('all', 'true')">Show All Images</div>
			<div onclick="loadImages('Private', 'true')">Show Private Images Only</div>
			<div onclick="loadImages('Public', 'true')">Show Public Images Only</div>
		  </div>
		</div>
		<!--<form class="example" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" onsubmit=<?php if (isset($_GET["search"])) {echo '<div onload="loadImages(' . "'" . $_GET["search"] . "'" . ", false); return false" . '"' . '></div>';}?>
		  <label>Set Search Terms</label>
		  <input type="search" name="search">
		  <button type="submit" ><i class="fa fa-search"></i></button>
		</form>-->
		<?php //if (isset($_GET["search"])) {echo @'<div id = "execute" onclick="loadImages(' . "'" . $_GET["search"] . "'" . ", false)" . '"' . '>Execute Search for <span id = "term">' . $_GET["search"] . '</span></div>';}?>
		
		<input type="text" id="livesearch" placeholder="Search" onkeyup = "doLiveSearch()"/>
		
		<div id="grid-container">
		</div>
		
		<div id="lightbox" class = "hidden"></div>
		<!---->
		<div id="positionBigImage">
			<div id="boundaryBigImage" class = "hidden">
				<img id="x" src="images/x.png" alt="close" onclick="displayLightBox('','')">
				<img id="bigImage" src="" alt="">
				<div id="info">
				</div>
			</div>
		</div>
	</body>
	<script src="indexscript.js"></script>
</html>