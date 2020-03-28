<?php
	echo 'hello';
	if ($_GET['3']) {
		echo '1';
	}
	echo '<br /><br />';
	$docRoot = getenv("DOCUMENT_ROOT");
	echo $docRoot;
?>