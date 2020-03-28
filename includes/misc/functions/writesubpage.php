<?php
	$subpageValue = $_GET['subpage'];
	// table, based on contenttype in database
	$tableName = 'tbl_'.$contentType;
	// file to write the content
	$listFile = 'write'.$contentType.'.php';
	$subpagequery = "SELECT * FROM ".$tableName." WHERE subPageName = '$subpageValue'";
	$subpageresult=mysql_query($subpagequery);
	$subpagenum=mysql_num_rows($subpageresult);
	badQuery($subpagenum);
	// and make pages out of them
	if ($subpagenum != 0) {
		$i=0;
		for ($i = 0; $i < $subpagenum; $i++) {
			$subpageid=mysql_result($subpageresult,$i,"subPageID");
			$subfilename=mysql_result($subpageresult,$i,"subPageName");
			$subPageContentType=mysql_result($subpageresult,$i,"subPageContentType");
			// call the file and the function
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/contenttypes/' . $listFile;
			//write"$contentType"();
			$func = 'write'.$contentType;
			$func();
			//writeArticle();
		}
	} else {
		echo 'no results';
	}
?>