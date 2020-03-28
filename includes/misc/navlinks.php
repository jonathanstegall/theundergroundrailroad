<?php
	$i=0;
	for ($i = 0; $i < $navnum; $i++) {
		$id=mysql_result($navresult,$i,"pageID");
		$filename=mysql_result($navresult,$i,"pageName");
		$navname=mysql_result($navresult,$i,"pageNavigationName");
		// create the link id
		$linkid = "$filename".'Link';
		// and the href for the link
		// remove index if that prefix goes away
		$url = '/index/'."$category".'/'."$filename".'/';
		$url = '"/index/'."$category".'/'."$filename".'/"';
		$navtitle='"'.$navname.'"';
		//$title=mysql_result($navresult,$i,"pageTitle");
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