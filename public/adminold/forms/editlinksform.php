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
  <input type=hidden name="id" value="<?php echo $myrow["id"] ?>" />
    <label for="title">Title of Site: </label>
    <input type="text" name="title" id="title" value="<?php echo $myrow["title"] ?>" />
	<br />
    <label for="address">Address of Site: </label>
    <input type="text" name="address" id="address" value="<?php echo $myrow["address"] ?>" />
	<br />
	<label for="category">Category of Site: </label>
	<select name="category" id="category">
     <?php createCategories(); ?>
    </select>
    <label for="description">Description of Site: </label>
    <textarea name="description" id="description"><?php echo $myrow["description"] ?></textarea>
  <br />
  <input type="hidden" name="cmd" value="edit" />
  <input type="submit" name="submit_button" class="submit" value="Edit Link" />
  </fieldset>
</form>