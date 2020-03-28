<?php


// processURI(): 
// Takes the query string and extracts the vars by splitting on the '/'
// Returns an array $url_array containing keys argN for each variable.
function processURI() {
 global $REQUEST_URI;   // Define our global variables
 $array = explode("/",$REQUEST_URI);	// Explode the URI using '/'.
 $num = count($array);	// How many items in the array?
 $url_array = array();	// Init our new array	
	
 for ($i = 1 ; $i < $num ; $i++) {	         
	$url_array["arg".$i] = $array[$i];  
 }
// Insert each element from the
// request URI into $url_array
// with a key of argN. We start $i
// at 1 because exploding the URI
// gives us an empty ref in $array[0] 
// It's a hacky way of getting round it
// *:)
	
return $url_array;  // return our new shiny array
}

include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writepage.php'; 

if(!isset($_GET['id'])) {
	$page = 'links';
	writePage($page);
} else {
	$page = $_GET['id'];
	writePage($page);
}
	// call the write page function, and give it the value of the page to write
	
	
?>

<?php
	// see if an id is present, if not.. write the page for the specified category
	if(!isset($_GET['id'])) {

	// call the write category function, and give it the value of the category to write - writes the main body content of the landing page for the category
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writecategory.php'; 
		writeCategory($category);

		// lists all the articles
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/listarticles.php'; 
		listArticles($category);
	} else {
		// writes the article corresponding to the id
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writearticle.php'; 
		writeArticle();
	}
?>