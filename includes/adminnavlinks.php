<?php
	$i=0;
	for ($i = 0; $i < $navnum; $i++) {
		// get all the main pages
		$filename=mysql_result($navresult,$i,"pageName");
		$navname=mysql_result($navresult,$i,"adminPageNavigationName");
		// create the href for the link
		$url = '"/admin/?page='."$filename".'"';
		// and the title
		$navtitle='"'.$navname.'"';
		if ($currentPage == $filename) {
			echo '<li class="current">';
			echo "<a href=$url title=$navtitle>$navname</a>";				
			echo "</li>\n";
		} else {
			echo '<li>';
			echo "<a href=$url title=$navtitle>$navname</a>";				
			echo "</li>\n";
		}
	}
?>