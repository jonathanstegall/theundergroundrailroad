<?php
class record {
	function record($recordid,$subpageid,$subPageContentType) {
		if (!$recordid) {
			$this->listRecords($subpageid,$subPageContentType);
		} else {
			$this->writeRecord($recordid,$subPageContentType);
		}
	}
	function listRecords($subpageid,$subPageContentType) {
		$tableName = 'tbl_'.$subPageContentType;
		$listClass = $subPageContentType.'List';		
		$recordquery = "SELECT * FROM ".$tableName." WHERE recordSubPageID = ".$subpageid." ORDER BY recordID DESC";
		$recordresult = mysql_query($recordquery);
		$recordnum = mysql_num_rows($recordresult);
		$i=0;
		echo "<ul class=\"$listClass\">\n";
		for ($i = 0; $i < $recordnum; $i++) {
			$recordfilename=mysql_result($recordresult,$i,"recordName");
			$recordnavname=mysql_result($recordresult,$i,"recordNavigationName");
			$recordnavtitle = '"'.$subnavname.'"';
			$recordlinkid = "$recordfilename".'Link';
			$category = $_GET['category'];
			$page = $_GET['page'];
			$subpage = $_GET['subpage'];
			// url
			$url = "\"/$category/$page/$subpage/$recordfilename/\"";
			echo '<li>';
				echo "<a href=$url title=$recordnavtitle>$recordnavname</a>";				
			echo "</li>\n";
		}
		echo "</ul>\n";
	}
	
	function writeRecord($recordid,$subPageContentType) {
		$tableName = 'tbl_'.$subPageContentType;
		$listFile = 'write'.$subPageContentType.'.php';
		$writerecordquery = "SELECT * FROM ".$tableName." WHERE recordID = '$recordid'";
		$writerecordresult=mysql_query($writerecordquery);
		$writerecordnum=mysql_num_rows($writerecordresult);
		// if we're on a record, write it
		if ($writerecordnum) {
			$i=0;
			for ($i = 0; $i < $writerecordnum; $i++) {
				$h1=mysql_result($writerecordresult,$i,"recordH1");
				$body=mysql_result($writerecordresult,$i,"recordBody");
				$code=mysql_result($writerecordresult,$i,"recordPHPCode");
				echo "<h1>$h1</h1>";
				echo $body;
				if ($code) {
					eval($code);
				}
			}
		} else {
		// if not, use the function written for it
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/contenttypes/' . $listFile;
			$func = 'write'.$contentType;
			$func();
		}
	}
}
?>