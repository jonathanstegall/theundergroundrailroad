<?php
	//echo $pageid;
	//echo $contentType;
	$tableName = 'tbl_'.$contentType;
	$listClass = $contentType.'List';
	$listFile = 'write'.$contentType.'.php';
	//echo $tableName;
	//echo $pageid;
	$subpagequery = "SELECT * FROM ".$tableName." WHERE subPageMainID = ".$pageid."";
	$subpageresult=mysql_query($subpagequery);
	
	// and make pages out of them
	if ($subpageresult) {
		$subpagenum=mysql_num_rows($subpageresult);
		badQuery($subpagenum);
		$i=0;
		echo '<ul class="'.$listClass.'">';
		for ($i = 0; $i < $subpagenum; $i++) {
			$subfilename=mysql_result($subpageresult,$i,"subPageName");
			$subnavname=mysql_result($subpageresult,$i,"subPageNavigationName");
			$subnavsummary=mysql_result($subpageresult,$i,"subPageSummary");
			$subnavname = ucfirst($subnavname);
			$subnavtitle = '"'.$subnavname.'"';
			$sublinkid = "$subfilename".'Link';
			// and the href for the link
			$page = $_GET['page'];
			// edit this if the index prefix ever goes away
			$url = '"/index/'."$category".'/'."$page".'/'."$subfilename".'/"';
			echo '<li><h4>';
				echo "<a href=$url title=$subnavtitle>$subnavname</a></h4>";		
				echo "<p>$subnavsummary<br /><a href=$url title=$subnavtitle>Read More</a></p>";		
			echo "</li>\n";
		}
		echo '</ul>';
	} else {
		//echo $tableName;
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/contenttypes/' . $listFile;
		$func = 'write'.$contentType;
			$func();
	}
?>