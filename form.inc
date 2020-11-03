		<div id ="form">
			<span class = "error">All Fields Required</span>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
				<div class = "line">
					<label for="fname">First Name: </label>
					<input type="text" id="fname" name="fname" value = <?php echo $fNameValue?>> 
					<span class = "error"><?php echo $fNameErr;?></span>
				</div>
				
				<div class = "line">
					<label for="lname">Last Name: </label> 
					<input type="text" id="lname" name="lname" value = <?php echo $lNameValue?>> 
					<span class = "error"><?php echo $lNameErr;?></span>
				</div>
				
				<div class = "line">
					<label for="file">Submit File: </label>
					<input type="file" id ="fileToUpload" name = "fileToUpload" >
					<span class = "error"><?php echo $fileErr;?></span>
				</div>
				
				<div class = "line">
					<label for="description">Description</label> 
					<textarea type="text" rows="4" cols="40" id="description" name="description" class="textarea"><?php echo $discValue?></textarea>
					<span class = "error"><?php echo $discErr;?></span>
				</div>
				
				<div class = "line">
					<label for="tags">Tags (Separate Each With Comma)</label> 
					<textarea type="text" id="tags" name="tags" class="textarea" ><?php echo $tagsValue?></textarea>
					<span class = "error"><?php echo $tagsErr;?></span>
				</div>
				
				<div class = "line">
					<input type="checkbox" id="copyright" name="copyright" value="copyright" <?php echo $checked ?>>
					<label for="copyright">I retain the copyright to this image and release it for use on this site.</label> 
					<br><span class = "error"><?php echo $copyRightErr;?></span>
				</div>
				
				<div class = "line">
					<input type="radio" id="Public" name="access" value="Public" <?php echo ($privacy=='Public')?'checked':'' ?> >
					<label for="Public">Public</label>
					<input type="radio" id="Private" name="access" value="Private" <?php echo ($privacy=='Private')?'checked':'' ?>>
					<label for="Private">Private</label> 
					<span class = "error"><?php echo $privacyErr;?></span>
				</div>
				
				<div class = "line">
					<input type="submit" value="Submit">
				</div>
				
			</form>
		</div>