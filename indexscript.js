"use strict"
//https://www.w3schools.com/jsref/met_node_appendchild.asp

var json = "";
var index;
let currentImages = [];

const init = {
	method: 'POST',
	body: JSON.stringify()
	
};

// gets content of livesearch box then runs loadImages with it
function doLiveSearch() {
	var searchTerm = document.getElementById("livesearch").value.toLowerCase();
	loadImages(searchTerm, false);
}

//fetch json
// load "all", "private", or "public" images only
function loadImages(access, notSearch){
	currentImages = [];
  if (notSearch){
	  fetch("./readjson.php?access=" + access, {
	  method: 'POST', 
	  headers: {
		'Content-Type': 'text/plain'
	  },
	  body: JSON.stringify()
	})
	
	.then(function(resp){
		  return resp.json();
		})
	.then(function(data){
	  let i;  // counter     
	  json = data;
	  let gridContainer = document.getElementById("grid-container");
		
	  // remove all existing children of gridContainer
	  while (gridContainer.firstChild) {
		gridContainer.removeChild(gridContainer.firstChild);
	  }
	  
	  // for every image, create a new image object and add to gridContainer
	  for (i in data){
		
		let img = new Image();
		img.src = "thumbnails/" + data[i].UID + "." + data[i].imagetype;
		img.alt = data[i].description;
		img.setAttribute('onclick', "displayLightBox('uploadedimages/" + data[i].UID + "." + data[i].imagetype + "', 'alt')");
		currentImages.push(data[i]);
		document.getElementById("grid-container").appendChild(img);       
	  }
	});
  } else {
	fetch("./readjson.php?search=" + access, {
	  method: 'POST', 
	  headers: {
		'Content-Type': 'text/plain'
	  },
	  body: JSON.stringify()
	})
	.then(function(resp){
		  return resp.json();
		})
	.then(function(data){
	  let i;  // counter     
	  json = data;
	  let gridContainer = document.getElementById("grid-container");
	  console.log(access);
	  // remove all existing children of gridContainer
	  while (gridContainer.firstChild) {
		gridContainer.removeChild(gridContainer.firstChild);
	  }
	  
	  // for every image, create a new image object and add to gridContainer
	  for (i in data){
		
		let img = new Image();
		img.src = "thumbnails/" + data[i].UID + "." + data[i].imagetype;
		img.alt = data[i].description;
		img.setAttribute('onclick', "displayLightBox('uploadedimages/" + data[i].UID + "." + data[i].imagetype + "', 'alt')");
		currentImages.push(data[i]);
		document.getElementById("grid-container").appendChild(img);       
	  }
	});
  }
	
	
  
} // loadImages*/

// change the visibility of divID
function changeVisibility (divId) {
	var element = document.getElementById(divId);
	
	// if element exists, toggle its class
	// between hidden and unhidden
	if (element) {
		element.className = (element.className == 'hidden')?'unhidden' : 'hidden';
	} // if
} // changeVisibility

// display light box with image in it
function displayLightBox(imageFile, alt) {
	var imageUID = imageFile.substring(15, 19);
	
	for (var i = 0; i < currentImages.length; i++) {
		if (imageUID == currentImages[i]['UID']) {
			index = i;
		}
	}
	
	setLightboxContents(imageFile, alt);
	
	changeVisibility("lightbox");
	changeVisibility("boundaryBigImage");
	
	
} // displayLightBox

function previous(imageFile, alt) {
	index -= 1;
	imageFile = "uploadedimages/" + currentImages[index]["UID"] + "." + currentImages[index]["imagetype"];
	setLightboxContents(imageFile, alt);
} // previous

function next(imageFile, alt) {
	index += 1;
	imageFile = "uploadedimages/" + currentImages[index]["UID"] + "." + currentImages[index]["imagetype"];
	setLightboxContents(imageFile, alt);
} // next

function setLightboxContents(imageFile, alt) {
	
	var image = new Image();
	var bigImage = document.getElementById("bigImage");
	
	image.src = imageFile;
	image.alt = alt;
	
	// set up correct download link
	var link = document.getElementById("downloadLink");
	try {
		//link.href = image.src;
	} catch (err) {
		
	}
	
	// look up anonymous functions for more
	// force big image to preload so we can have
	// access to its width so it will be centered
	image.onload = function() {
		var width = image.width;
		document.getElementById('boundaryBigImage').style.width = width + 'px';
	}
	
	bigImage.src = image.src;
	bigImage.alt = image.alt;
	
	var info = document.getElementById("info");
	
	// remove all existing children of info
    while (info.firstChild) {
        info.removeChild(info.firstChild);
    }
	
	try {
		
		
	} catch (err) {
		
	}
	info.innerHTML += "From: " + json[index]["fname"] + " " + json[index]["lname"]+ "<br>";
		info.innerHTML += "Description: " + json[index]["description"] + "<br>";
		info.innerHTML += "Tags: " + json[index]["tags"] + "<br>";
		info.innerHTML += "<a id = 'downloadLink' href='" + image.src + "' download><button>Download Image</button></a>"
	
	if (currentImages.length != 1) {
		if (index > 0) {
			info.innerHTML += "<button type='button' onclick = 'previous()'>Previous</button>"
		}
		if (index + 1 < currentImages.length) {
			info.innerHTML += "<button type='button' onclick = 'next()'>Next</button>";
		}
	}
}