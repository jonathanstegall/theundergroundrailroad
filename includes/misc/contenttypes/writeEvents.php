<?php
	function writeEvents() {
		$recordValue = $_GET['record'];
		$recordquery = "SELECT * FROM
			tbl_Events
			WHERE recordName='$recordValue'
		";
		$recordresult=mysql_query($recordquery);
		$eventnum = mysql_num_rows($recordresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $eventnum; $i++) {
			$eventtitle=mysql_result($recordresult,$i,"recordTitle");
			//$ministryname=mysql_result($recordresult,$i,"ministryName");
			$body=mysql_result($recordresult,$i,"recordBody");

		}
		echo '<h1>'.$eventtitle.'</h1>';
		//echo '<h2>'.$authorname.' - '.$ministryname.'</h2>';
		echo $body;
	}
?>