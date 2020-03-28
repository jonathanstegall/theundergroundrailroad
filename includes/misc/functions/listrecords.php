<?php
	$tableName = 'tbl_'.$subPageContentType;
	$listClass = $subPageContentType.'List';
	$listFile = 'write'.$subPageContentType.'.php';
	$recordquery = "SELECT * FROM ".$tableName." WHERE recordSubPageID = ".$subpageid."";
	$recordresult=mysql_query($recordquery);
	
	// and make pages out of them
	if ($recordresult) {
		$recordnum=mysql_num_rows($recordresult);
		badQuery($recordnum);
		$i=0;
		echo '<ul class="'.$listClass.'">';
		for ($i = 0; $i < $recordnum; $i++) {
			$recordfilename=mysql_result($recordresult,$i,"recordName");
			$recordnavname=mysql_result($recordresult,$i,"recordNavigationName");
			$recordnavtitle = '"'.$subnavname.'"';
			$recordlinkid = "$recordfilename".'Link';
			// and the href for the link
			$page = $_GET['page'];
			// edit this if the index prefix ever goes away
			$url = '"/index/'."$category".'/'."$page".'/'."$subfilename".'/'."$recordfilename".'/"';
			echo '<li>';
				echo "<a href=$url title=$recordnavtitle>$recordnavname</a>";				
			echo "</li>\n";
		}
		echo '</ul>';
	} else {
		//echo $tableName;
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/contenttypes/' . $listFile;
		$func = 'write'.$subPageContentType;
			$func();
		//echo $recordquery;
	}
?>