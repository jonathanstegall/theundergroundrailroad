<?php
class contentPage {
	function contentPage($pageid,$subpage) {
		if (!$subpage) {
			$this->writePage($pageid);
		} else {
			return false;
		}
	}
	function writePage($pageid) {
		$writepagequery = "SELECT * FROM tbl_mainPages WHERE pageID = '$pageid'";
		$writepageresult=mysql_query($writepagequery);
		$writepagenum=mysql_num_rows($writepageresult);
		$i=0;
		for ($i = 0; $i < $writepagenum; $i++) {
			$pagename=mysql_result($writepageresult,$i,"pageName");
			$contentType=mysql_result($writepageresult,$i,"pageContentType");
			$h1=mysql_result($writepageresult,$i,"pageH1");
			$body=mysql_result($writepageresult,$i,"pageBody");
			$code=mysql_result($writepageresult,$i,"pagePHPCode");
			echo "<h1>$h1</h1>";
			echo $body;
			if ($code) {
				eval($code);
			}
		}
	}
}
?>