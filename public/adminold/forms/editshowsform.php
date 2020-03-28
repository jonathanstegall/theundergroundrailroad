<form action="<?=$PHP_SELF?>" method="post" class="form showform">
  <input type=hidden name="id" value="<?php echo $myrow["id"] ?>" />
  <input type="hidden" name="cmd" value="edit" />
  <fieldset>
  <legend>add shows</legend>
  <label for="date">Date: </label>
  <input type="text" name="date" id="date" value="<?php echo $myrow["showdate"] ?>" />
  <br />
  <label for="time">Time: </label>
  <input type="text" name="time" id="time" value="<?php echo $myrow["time"] ?> <?php echo $myrow["ampm"] ?>" />
  <br />
  <label for="price">Price: </label>
  <input type="text" name="price" id="price" value="$<?php echo $myrow["price"] ?>" />
  <br />
  <label for="bands">Bands: </label>
  <textarea name="bands"><?php echo $myrow["bands"] ?></textarea>
  <br />
  <input type="submit" name="submit_button" id="submit_button" value="Edit Show" class="submit" />
  </fieldset>
</form>