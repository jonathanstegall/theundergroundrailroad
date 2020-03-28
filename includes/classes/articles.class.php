<?php
class articles {
	function articles($page,$pageid,$contentType,$subpage) {
		/*
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/loginconstants.php';
		$sessionid = session_id();
		$userquery = "SELECT * FROM
			tbl_users
			INNER JOIN tbl_sessions
				ON tbl_users.username = tbl_sessions.username
		
			WHERE tbl_sessions.ses_id='$sessionid'
		";
		$userresult=mysql_query($userquery);
		$usernum = mysql_num_rows($userresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $usernum; $i++) {
			$getuserid=mysql_result($userresult,$i,"userID");
		}
		*/
		if (!$subpage) {
			$this->listArticles($page,$pageid,$contentType);
		} else {
			$this->writeArticle($subpage);
		}
	}
	function listArticles($page,$pageid,$contentType) {
		$listClass = $contentType.'Div';
		$subpagequery = "SELECT * FROM tbl_articles WHERE subPageMainID = ".$pageid."";
		$subpageresult=mysql_query($subpagequery);
		$subpagenum=mysql_num_rows($subpageresult);
		$i=0;
			for ($i = 0; $i < $subpagenum; $i++) {
				echo "<div class=\"$listClass\">\n";
				$subfilename=mysql_result($subpageresult,$i,"subPageName");
				$subnavname=mysql_result($subpageresult,$i,"subPageNavigationName");
				$subnavsummary=mysql_result($subpageresult,$i,"subPageSummary");
				$subnavname = ucfirst($subnavname);
				$subnavtitle = '"'.$subnavname.'"';
				$sublinkid = "$subfilename".'Link';
				$category = $_GET['category'];
				// edit this if the index prefix ever goes away
				$url = "\"/$category/$page/$subfilename/\"";
				echo "<h3><a href=$url title=$subnavtitle>$subnavname</a></h3>";
					echo "<p>$subnavsummary<br /><a href=$url title=$subnavtitle>Read More</a></p>";		
				echo "</div>\n";
			}
	}
	function writeArticle($subpage) {
		$subpageValue = $_GET['subpage'];
		$subpagequery = "SELECT * FROM
			tbl_articles
			INNER JOIN tbl_authors
				ON tbl_articles.articleAuthor = tbl_authors.authorID
					INNER JOIN tbl_ministries
						ON tbl_articles.articleMinistry = tbl_ministries.subPageID
			WHERE tbl_articles.subPageName='$subpageValue'
		";
		$subpageresult=mysql_query($subpagequery);
		$articlenum = mysql_num_rows($subpageresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $articlenum; $i++) {
			$articletitle=mysql_result($subpageresult,$i,"tbl_articles.subPageTitle");
			$authorname=mysql_result($subpageresult,$i,"authorName");
			$ministryname=mysql_result($subpageresult,$i,"tbl_ministries.subPageNavigationName");
			$body=mysql_result($subpageresult,$i,"articleBody");

		}
		echo '<h1>'.$articletitle.'</h1>';
		echo '<h2>'.$authorname.' - '.$ministryname.'</h2>';
		echo $body;
	}
	/*
	function addArticle($companyname,$userid) {
		$userid = $_POST['userid'];
		if ($getuserid == $posteduserid) {
			$companyname = $_POST['companyname'];
			$companytitle = str_replace(" ","", $companyname);
			$companytitle = strtolower($companytitle);
			$companyaddress = $_POST['companyaddress'];
			$companycity = $_POST['companycity'];
			$companystate = $_POST['companystate'];
			if ($companystate == "Choose a State") {
				echo '<p class="queryError">You did not choose a state. Please try again.</p>';
				return false;
			}
			$companyzip = $_POST['companyzip'];
			$companycategory = $_POST['companycategory'];
			if ($companycategory == "Choose a Category") {
				echo '<p class="queryError">You did not choose a category. Please try again.</p>';
				return false;
			}
			$categoryquery = "SELECT * from tbl_categories WHERE categoryName = '$companycategory'";
			$categoryresult = mysql_query($categoryquery);
			$categorynum = mysql_num_rows($categoryresult) or die(mysql_error());
			$x=0;
			for ($x = 0; $x < $categorynum; $x++) {
				$catid=mysql_result($categoryresult,$x,"categoryID");
			}
			$companydescription = $_POST['companydescription'];
			$expiredate = date("Y-m-d",$nopay);
			
			$companylatitude = 1000;
			$companylongitude = 2000;
			
			$addcompanyquery = "INSERT INTO tbl_companies (companyTitle, companyName, companyUser, companyCategory, companyAddress, companyCity, companyState, companyZip, companyDescription, companyLatitude, companyLongitude) VALUES('$companytitle', '$companyname', '$userid', '$catid', '$companyaddress', '$companycity', '$companystate', '$companyzip', '$companydescription', '$companylatitude', '$companylongitude')";
			$adduserresult = mysql_query($addcompanyquery) or die(mysql_error());
			echo "<p class=\"queryResult\">$companyname has been successfully added.</p>";
		} else {
			echo '<p class="queryError">You are not a recognized user.</p>';
		}
	}
	function editArticle($companyname) {
		// get hidden company name to make sure it's a valid form post, and hidden username to see what user's company is being deleted - this is necessary if it is the user's company
		$username = $_POST['companyusername'];
		$postedcompany = $_POST['companyname'];
		// match company to username
		if ($companyname == $postedcompany) {
			$userquery = "SELECT * FROM
				tbl_companies
				INNER JOIN tbl_users
					ON tbl_companies.companyUser = tbl_users.userID
			
				WHERE tbl_users.username='$username'
			";
			$userresult = mysql_query($userquery);
			$usernum = mysql_num_rows($userresult);
			//echo $usernum;
			$n=0;
			for ($n=0; $n < $usernum; $n++) {
				$companyuser=mysql_result($userresult,$n,"companyUser");
			}
			// get the form fields for the edit
			$newcompanyname = $_POST['newcompanyname'];
			$newcompanyaddress = $_POST['newcompanyaddress'];
			$newcompanycity = $_POST['newcompanycity'];
			$companystate = $_POST['companystate'];
			if ($companystate == "Choose a State") {
				echo '<p class="queryError">You did not choose a state. Please try again.</p>';
				return false;
			}
			$newcompanyzip = $_POST['newcompanyzip'];
			$companycategory = $_POST['companycategory'];
			if ($companycategory == "Choose a Category") {
				echo '<p class="queryError">You did not choose a category. Please try again.</p>';
				return false;
			}
			$newcompanydescription = $_POST['newcompanydescription'];
				// fill in the form fields
				$companytitlequery = "SELECT * FROM tbl_companies WHERE companyTitle = '$postedcompany' AND companyUser = '$companyuser' OR companyName = '$postedcompany' AND companyUser = '$companyuser'";
				$companytitleresult = mysql_query($companytitlequery);
				$companytitlenum = mysql_num_rows($companytitleresult);
					// get the category info for the edit form
					$categoryquery = "SELECT * from tbl_categories WHERE categoryName = '$companycategory'";
					$categoryresult = mysql_query($categoryquery);
					$categorynum = mysql_num_rows($categoryresult) or die(mysql_error());
					$x=0;
					for ($x = 0; $x < $categorynum; $x++) {
						$catid=mysql_result($categoryresult,$x,"categoryID");
					}
				// if it's a valid company
				if ($companytitlenum == 1) {
					// update it
					$editcompanyquery = "UPDATE tbl_companies, tbl_categories SET tbl_companies.companyName='$newcompanyname', tbl_companies.companyAddress='$newcompanyaddress', tbl_companies.companyCity='$newcompanycity', tbl_companies.companyState='$companystate', tbl_companies.companyZip='$newcompanyzip', tbl_companies.companyDescription='$newcompanydescription', tbl_companies.companyCategory='$catid' WHERE tbl_companies.companyName='$postedcompany'";
					$edituserresult = mysql_query($editcompanyquery) or die(mysql_error());
					// success message
					echo "<p class=\"queryResult\">$newcompanyname has been successfully edited</p>";
				} else {
					// companytitle is invalid query
					echo '<p class="queryError">Your entry was not a recognized company in our database.</p>';
				}
		} else {
			// form wasn't posted
			echo '<p class="queryError">Your entry was invalid.</p>';
		}
	}
	function deleteArticle($companyname) {
		$postedcompany = $_POST['companyname'];
		if ($companyname == $postedcompany) {
			$deletequery = "DELETE from tbl_companies WHERE companyName = '$companyname'";
			$deleteresult = mysql_query($deletequery) or die(mysql_error());
			echo "<p class=\"queryResult\">$companyname has been successfully deleted.</p>";
		} else {
			echo '<p class="queryError">Your entry was not a recognized company.</p>';
		}
	
	}
	*/
}
?>