<?php
class ajaxTabs {
	function ajaxTabs($pageid) {
		$this->writeajaxTabs($pageid);
	}
	function writeajaxTabs ($pageid) {
		/*
		$subpageValue = $_GET['subpage'];
		if ($subPageValue) {
			echo 'this is a subpage';
		} else {
			$category = $_GET['category'];
			if (!$category) {
				$category = 'main';
			}
			// find the matching category in the database
			$categoryquery = "SELECT mainCategoryID from tbl_mainCategory WHERE mainCategoryName = '$category'";
			$categoryresult = mysql_query($categoryquery);
			$categorynum=mysql_num_rows($categoryresult);
			//badQuery($categorynum);
			// for the matching categories, get the id that matches the name
			$x=0;
			for ($x = 0; $x < $categorynum; $x++) {
				$catid=mysql_result($categoryresult,$x,"mainCategoryID");
			}
			$page = $_GET['page'];
			$pagequery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid' AND pageName = '$page'";
			$pageresult=mysql_query($pagequery);
			$pagenum=mysql_num_rows($pageresult);
			//badQuery($pagenum);
			// and make pages out of them
			$i=0;
			for ($i = 0; $i < $pagenum; $i++) {
				$pageid=mysql_result($pageresult,$i,"pageID");
			}
			$tabquery = "SELECT * FROM tbl_ajaxTabs WHERE tabMainID = $pageid";
			$tabresult=mysql_query($tabquery);
			$tabnum = mysql_num_rows($tabresult) or die(mysql_error());
			// create div holder and list the tabs, then put their contents into divs
			echo '<div class="domtab"><a name="tabtop"></a>';
				echo '<ul class="domtabs">';
				$y=0;
				for ($y = 0; $y < $tabnum; $y++) {
					$tablink=mysql_result($tabresult,$y,"tabLink");
					$tabname=mysql_result($tabresult,$y,"tabName");
					echo '<li><a href="#'.$tablink.'">'.$tabname.'</a></li>';
				};
				echo '</ul>';
				$z=0;
				for ($z = 0; $z < $tabnum; $z++) {
					$tabidentifier=mysql_result($tabresult,$z,"tabLink");
					$tabtitle=mysql_result($tabresult,$z,"tabTitle");
					$tabcontent=mysql_result($tabresult,$z,"tabContent");
					$tabTable=mysql_result($tabresult,$z,"tabTable");
					echo '<div class="clearfix">';
					echo '<h2><a name="'.$tabidentifier.'" id="'.$tabidentifier.'">'.$tabtitle.'</a></h2>';
					$tabcontentquery = "SELECT * FROM ".$tabTable."";
					$tabcontentresult = mysql_query($tabcontentquery);
					if ($tabTable) {
						$tabcontentnum=mysql_num_rows($tabcontentresult);
						$a=0;
						echo '<dl class="newsList">';
						for ($a = 0; $a < $tabcontentnum; $a++) {
							$author = mysql_result($tabcontentresult,$a,"itemAuthor");
							$title = mysql_result($tabcontentresult,$a,"itemTitle");
							$timestamp = mysql_result($tabcontentresult,$a,"itemTimestamp");
							$description = mysql_result($tabcontentresult,$a,"itemDescription");
							$content = mysql_result($tabcontentresult,$a,"itemContent");
							
								echo '<dt>'.$title.'</dt>';
								echo '<dd>'.$content.'</dd>';
								echo '<dd class="postedby">posted by '.$author.' on '.$timestamp.'</dd><br class="clear" />';
						}
						echo '</dl>';
						echo '<p><a href="#tabtop">return to top</a></p>';
					} else {
						echo 'no table';
					}
					echo '</div>';
				};
			echo '</div>';
		}
		*/
	}
}
?>