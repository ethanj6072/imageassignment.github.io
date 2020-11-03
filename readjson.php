<?php

 // read json file into array of strings
 $jsonstring = file_get_contents("galleryinfo.json");
 
 // save the json data as a PHP array
 $phparray = json_decode($jsonstring, true);
 
// Iterate loop to convert array 
// elements into lowercase and  
// overwriting the original array 
$j = 0;
$k = 0;
foreach( $phparray as $line ) {  
	foreach ($line as $word) {
		$line[$k] = strtolower($word); 
		//console_log($line[$k]);
		$k = $k + 1;
	}
	$k = 0;
    $phparray[$j] = $line;
	//console_log($phparray[$j]);
    $j = $j + 1; 
} 

 
 $returnData = [];
 
 if (isset($_GET["search"])) {
	//console_log("TEST");
	//console_log($_GET['search']);
	
	$search = strtolower($_GET["search"]);
	$searchArray = explode(' ', $search);
	console_log(strpos($phparray[0]['fname'], $word));
	foreach ($phparray as $entry) {
		$containsAllWords = true; //is set false if any terms are not found
		foreach ($searchArray as $word) {
			if (!(strpos($entry['fname'], $word) !== false || strpos($entry['lname'], $word) !== false 
			|| strpos($entry['description'], $word) !== false || strpos($entry['tags'], $word) !== false)) {
				$containsAllWords = false;
				//console_log($entry);
				//console_log("false");
			}
		}
		//console_log("cycle");
		if ($containsAllWords) {
			$returnData[] = $entry;
			//console_log($entry);
			//console_log("true");
		}
	}
	
	//console_log($returnData);
	
 } else {
	 //console_log("TEST2");
	// use GET to determine type of access
	 if (isset($_GET["access"])){
	  $access = $_GET["access"];
	 } else {
	  $access = "all"; 
	 }
	// pull public or private only or return all
	  // NOTE: to make this more secure, if $access == "private" or "all"
	  // you would also check that an editor is logged in.
	  if ($access != "all") { 
	   foreach($phparray as $entry) {
		// var_dump($entry);
		  if ($entry["access"] == $access) {
			 $returnData[] = $entry;  
		  }      
	   } // foreach
	  } else {
		 $returnData = $phparray;
	  }
	 
	 console_log($returnData);
 }

// encode the php array to json 
 $jsoncode = json_encode($returnData, JSON_PRETTY_PRINT);
 echo ($jsoncode);

function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
	}

?>