<h2>News &amp; Updates</h2>
<?php

include("../includes/db_connect.php");
//select database
mysql_select_db($db_main) or die(mysql_error());

// number of results per page
$max_results = 5;

$newsquery="SELECT * FROM tbl_news ORDER BY newsDate LIMIT 0, $max_results";
$newsresult=mysql_query($newsquery);
$newsnum=mysql_num_rows($newsresult);

if ($newsnum == 0) {
	echo '<dl class="newsList"><dt>no news to display</dt></dl>';
	return;
}

mysql_close();

// create definition list
echo '<dl class="newsList clearfix">';

$i=0;

// with the news in it
while ($i < $newsnum) {
	$author=mysql_result($newsresult,$i,"newsAuthor");
	$title=mysql_result($newsresult,$i,"newsTitle");
	$newsitem=mysql_result($newsresult,$i,"newsItem");
	$date=mysql_result($newsresult,$i,"newsDate");
	
	$datetimestamp = strtotime($date);
	$datedisplay = date ("F j, Y \@ g:i A", $datetimestamp);
?>

<dt><?php echo $title; ?></dt>
<dd><?php echo $newsitem; ?><br />
  <span class="postedby">posted by <? echo "$author"; ?> on <? echo "$datedisplay"; ?></span></dd>
<?php
	++$i;
}
echo '</dl>';
?>