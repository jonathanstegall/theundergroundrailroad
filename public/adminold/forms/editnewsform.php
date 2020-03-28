<form action="<?=$PHP_SELF?>" method="post" class="form">
  <fieldset>
  <?php echo $message; ?>
  <input type=hidden name="id" value="<?php echo $myrow["id"] ?>" />
  <label for="author">Your Name: </label>
  <input type="text" name="author" id="author" value="<?php echo $myrow["author"] ?>" />
  <br />
  <label for="title">Title: </label>
  <input type="text" name="title" id="title" value="<?php echo $myrow["title"] ?>" />
  <br />
  <br />
  <label for="newsitem">News Item: </label>
  <textarea name="newsitem"><?php echo $myrow["newsitem"] ?></textarea>
  <br />
  <input type="hidden" name="cmd" value="edit" />
  <input type="submit" name="submit_button" id="submit_button" class="submit" value="Edit News" />
  </fieldset>
</form>
