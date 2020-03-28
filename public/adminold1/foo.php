<?php
if ($s->data['logged_in'] = true) {
	echo $s->data['username'];
	echo ' is logged in';
	echo ' <a href="logout.php">logout</a>';
} else {
	echo 'you are not logged in';
}
?>