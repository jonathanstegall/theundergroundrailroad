<?php
	function writeArticles() {
		$subpageValue = $_GET['subpage'];
		$subpagequery = "SELECT * FROM
			tbl_articles
			INNER JOIN tbl_authors
				ON tbl_articles.articleAuthor = tbl_authors.authorID
					INNER JOIN tbl_ministries
						ON tbl_articles.articleMinistry = tbl_ministries.ministryID
			WHERE subPageName='$subpageValue'
		";
		$subpageresult=mysql_query($subpagequery);
		$articlenum = mysql_num_rows($subpageresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $articlenum; $i++) {
			$articletitle=mysql_result($subpageresult,$i,"subPageTitle");
			$authorname=mysql_result($subpageresult,$i,"authorName");
			$ministryname=mysql_result($subpageresult,$i,"ministryName");
			$body=mysql_result($subpageresult,$i,"articleBody");

		}
		echo '<h1>'.$articletitle.'</h1>';
		echo '<h2>'.$authorname.' - '.$ministryname.'</h2>';
		echo $body;
	}
?>