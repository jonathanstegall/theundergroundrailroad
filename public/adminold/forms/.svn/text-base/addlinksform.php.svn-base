<?php

function createCategories() {
	$i = 0;
	$category["$i"] = $category;
		echo '<option>ministry</option';
}
?>

<form action="<?=$PHP_SELF?>" method="post" class="form">
<fieldset>
  <?php echo $message; ?>
    <label for="title">Title of Site: </label>
    <input type="text" name="title" id="title" />
	<br />
    <label for="address">Address of Site: </label>
    <input type="text" name="address" id="address" value="http://" />
	<br />
	<label for="category">Category of Site: </label>
	<select name="category" id="category">
     <?php createCategories(); ?>
    </select>
    <label for="description">Description of Site: </label>
    <textarea name="description" id="description"></textarea>
  <br />
  <input type="submit" name="submit_button" class="submit" value="Add Link" />
  </fieldset>
</form>