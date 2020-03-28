<?php
	$recordValue = $_GET['record'];
	// table, based on contenttype in database
	$tableName = 'tbl_'.$subPageContentType;
	// file to write the content
	$listFile = 'write'.$subPageContentType.'.php';
	$recordquery = "SELECT * FROM ".$tableName." WHERE recordName = '$recordValue'";
	$recordresult=mysql_query($recordquery);
	$recordnum=mysql_num_rows($recordresult);
	badQuery($recordnum);
	// and make pages out of them
	if ($recordnum != 0) {
		$i=0;
		for ($i = 0; $i < $recordnum; $i++) {
			$recordid=mysql_result($recordresult,$i,"recordID");
			$recordfilename=mysql_result($recordresult,$i,"recordName");
			// call the file and the function
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/contenttypes/' . $listFile;
			//write"$contentType"();
			$func = 'write'.$subPageContentType;
			$func();
			//writeArticle();
		}
	} else {
		echo 'no results';
	}
?>