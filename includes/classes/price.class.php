<?php
class price {
	var $task;
	var $price;
	function price() {
		$task = $_GET['task'];
	}
	function addprice($pricename) {
		$pricename = $_POST['pricename'];
		if ($pricename) {
			$pricetitle = str_replace(" ","", $pricename);
			$pricetitle = strtolower($pricetitle);
			$pricecategory = $_POST['pricecategory'];
			$categoryquery = "SELECT * from tbl_pricingCategories WHERE priceCategoryName = '$pricecategory'";
			$categoryresult = mysql_query($categoryquery);
			$categorynum = mysql_num_rows($categoryresult) or die(mysql_error());
			$x=0;
			for ($x = 0; $x < $categorynum; $x++) {
				$catid=mysql_result($categoryresult,$x,"priceCategoryID");
			}
			$priceamount = $_POST['priceamount'];
			$priceamount = str_replace("$","", $priceamount);
			$priceamount = str_replace(",","", $priceamount);
			$pricestartdate = $_POST['pricestartdate'];
			$priceenddate = $_POST['priceenddate'];
			$pricedescription = $_POST['pricedescription'];
			$addpricequery = "INSERT INTO tbl_pricing (priceTitle, priceName, priceCategory, priceAmount, priceStartDate, priceEndDate, priceDescription) VALUES('$pricetitle', '$pricename', '$catid', '$priceamount', '$pricestartdate', '$priceenddate', '$pricedescription')";
			$adduserresult = mysql_query($addpricequery) or die(mysql_error());
			echo "<p class=\"queryResult\">$pricename has been successfully added.</p>";
		} else {
			echo '<p class="queryError">The form was not correctly submitted.</p>';
		}
	}
	function editprice($pricename) {
		// get hidden company name to make sure it's a valid form post, and hidden username to see what user's company is being deleted - this is necessary if it is the user's company
		$newpricename = $_POST['newpricename'];
		// match company to username
		if ($newpricename) {
			// get the form fields for the edit
			$newpricetitle = str_replace(" ","", $newpricename);
			$newpricetitle = strtolower($newpricetitle);
			$pricecategory = $_POST['pricecategory'];
			if ($pricecategory == "Choose a Price Category") {
				echo '<p class="queryError">You did not choose a category. Please try again.</p>';
				return false;
			}
			$newpriceamount = $_POST['newpriceamount'];
			$newpriceamount = str_replace("$","", $newpriceamount);
			$newpriceamount = str_replace(",","", $newpriceamount);
			$newpricestartdate = $_POST['newpricestartdate'];
			$newpriceenddate = $_POST['newpriceenddate'];
			$newpricedescription = $_POST['newpricedescription'];
				// fill in the form fields
				$pricequery = "SELECT * FROM tbl_pricing WHERE priceName = '$pricename'";
				$priceresult = mysql_query($pricequery);
				$pricenum = mysql_num_rows($priceresult);
					// get the category info for the edit form
					$categoryquery = "SELECT * from tbl_pricingCategories WHERE priceCategoryName = '$pricecategory'";
					$categoryresult = mysql_query($categoryquery);
					$categorynum = mysql_num_rows($categoryresult) or die(mysql_error());
					$x=0;
					for ($x = 0; $x < $categorynum; $x++) {
						$catid=mysql_result($categoryresult,$x,"priceCategoryID");
					}
				// if it's a valid price
				if ($pricenum == 1) {
					// update it
					$editpricequery = "UPDATE tbl_pricing SET priceName='$newpricename', priceTitle='$newpricetitle', priceCategory='$catid', priceAmount='$newpriceamount', priceStartDate='$newpricestartdate', priceEndDate='$newpriceenddate', priceDescription='$newpricedescription' WHERE priceName='$newpricename'";
					$editpriceresult = mysql_query($editpricequery) or die(mysql_error());
					// success message
					echo "<p class=\"queryResult\">$newpricename has been successfully edited</p>";
				} else {
					// pricetitle is invalid query
					echo '<p class="queryError">Your entry was not a recognized price in our database.</p>';
				}
		} else {
			// form wasn't posted
			echo '<p class="queryError">Your entry was invalid.</p>';
		}
	}
}
?>