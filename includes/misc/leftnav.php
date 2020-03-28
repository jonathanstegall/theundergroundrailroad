<?php // begin left div - <div>

// create navigation depending on which category is defined
include("category.php");
// open database file in order to get navigation names
include("db_connect.php");

switch ($category) {
	// main navigation
	case "main":
	// loop through database, get main navigation names
	//select database
	mysql_select_db($db_main) or die(mysql_error());
	$navquery="SELECT * FROM tbl_navigation WHERE category_placement='$category'";
	$navresult=mysql_query($navquery);
	$navnum=mysql_num_rows($navresult);
	

	$i=0;
?>
	<div id="leftmainsection"><span class="hidden">main</span></div>
	<ul id="nav">
<?php
	 for ($i = 0; $i < $navnum; $i++) {
			$id=mysql_result($navresult,$i,"category_id");
			$fullname=mysql_result($navresult,$i,"category_fullname");
			$categoryname=mysql_result($navresult,$i,"category_name");
			$url=mysql_result($navresult,$i,"category_url");
			$table=mysql_result($navresult,$i,"category_table");
			$navid=rtrim($url, '.php');
			echo "<li id='mainLink_$navid'>";
				echo "<a href='$url' title='$fullname'>$categoryname</a>";				
			echo "</li>\n";
	}
	echo "</ul>\n";
	break;
	// ministries navigation
	case "ministries":
	// loop through database, get main navigation names
?>
	<div id="leftmainsection"><span class="hidden">main</span></div>
	<ul id="nav">
	  <li<?php if ($thisPage=="home") echo " class=\"current_left\""; ?>><a href="../index.php" title="home">home</a></li>
	  <li<?php if ($thisPage=="about") echo " class=\"current_left\""; ?>><a href="#" title="about">about</a></li>
	  <li<?php if ($thisPage=="events") echo " class=\"current_left\""; ?>><a href="#" title="events">events</a></li>
	  <li<?php if ($thisPage=="thearts") echo " class=\"current_left\""; ?>><a href="#" title="the arts">the arts</a></li>
	  <li<?php if ($thisPage=="forum") echo " class=\"current_left\""; ?>><a href="#" title="forum">forum</a></li>
	  <li<?php if ($thisPage=="links") echo " class=\"current_left\""; ?>><a href="#" title="links">links</a></li>
	  <li<?php if ($thisPage=="contact") echo " class=\"current_left\""; ?>><a href="#" title="contact">contact</a></li>
	</ul>
<?php
	break;
	// handbook navigation
	case "handbook":
	// loop through database, get main navigation names
		//select database
	mysql_select_db($db_main) or die(mysql_error());
	$navquery="SELECT * FROM tbl_navigation WHERE category_placement='$category'";
	$navresult=mysql_query($navquery);
	$navnum=mysql_num_rows($navresult);

	$i=0;
?>
	<div id="lefthandbooksection"><span class="hidden">handbook</span></div>
	<ul id="nav">
<?php
	 for ($i = 0; $i < $navnum; $i++) {
			$id=mysql_result($navresult,$i,"category_id");
			$fullname=mysql_result($navresult,$i,"category_fullname");
			$categoryname=mysql_result($navresult,$i,"category_name");
			$url=mysql_result($navresult,$i,"category_url");
			$navid=rtrim($url,'.php');
			echo "<li id='handbookLink_$navid'>";
				echo "<a href='$url' title='$fullname'>$categoryname</a>";
			echo "</li>";
	}
	echo '</ul>';
	break;
}
mysql_close();
// end left div - </div>
?>