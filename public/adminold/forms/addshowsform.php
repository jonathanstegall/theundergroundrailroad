<?php

function createYears() {
	$i = 0;
	$size = 5;
	$years["$i"] = 2006;
		echo '<option>2006</option';
}
?>

<form action="<?=$PHP_SELF?>" method="post" class="form showform">
  <fieldset>
  <legend>add shows</legend>
    <label for="date">Date: </label>
    <select name="dayname" id="dayname">
      <option>Sunday</option>
      <option>Monday</option>
      <option>Tuesday</option>
      <option>Wednesday</option>
      <option>Thursday</option>
      <option>Friday</option>
      <option>Saturday</option>
    </select> 
	
    <select name="month" id="month">
      <option value="01">January</option>
      <option value="02">February</option>
      <option value="03">March</option>
      <option value="04">April</option>
      <option value="05">May</option>
      <option value="06">June</option>
      <option value="07">July</option>
      <option value="08">August</option>
      <option value="09">September</option>
      <option value="10">October</option>
      <option value="11">November</option>
      <option value="12">December</option>
    </select>
	<br />
	<label for="day">&nbsp;</label>
    <select name="daynumber" id="daynumber">
      <option value="01">1st</option>
      <option value="02">2nd</option>
      <option value="03">3rd</option>
      <option value="04">4th</option>
      <option value="05">5th</option>
      <option value="06">6th</option>
      <option value="07">7th</option>
      <option value="08">8th</option>
      <option value="09">9th</option>
      <option value="10">10th</option>
      <option value="11">11th</option>
      <option value="12">12th</option>
      <option value="13">13th</option>
      <option value="14">14th</option>
      <option value="15">15th</option>
      <option value="16">16th</option>
      <option value="17">17th</option>
      <option value="18">18th</option>
      <option value="19">19th</option>
      <option value="20">20th</option>
      <option value="21">21st</option>
      <option value="22">22nd</option>
      <option value="23">23rd</option>
      <option value="24">24th</option>
      <option value="25">25th</option>
      <option value="26">26th</option>
      <option value="27">27th</option>
      <option value="28">28th</option>
      <option value="29">29th</option>
      <option value="30">30th</option>
      <option value="31">31st</option>
    </select>
	
	<select name="year" id="year">
     <?php createYears(); ?>
    </select>
  <br />
    <label for="time">Time: </label>
    <input type="text" name="time" id="time" />
  <br />
  <input type="radio" name="ampm" id="ampm" value="am" class="radio" />
  <label for="am" class="radiolabel">am</label>
  <input type="radio" name="ampm" id="ampm" value="pm" class="radio lastradio" />
  <label for="pm" class="radiolabel">pm</label>
  <br />

  <label for="price">Price: </label>
  <input type="text" name="price" id="price" value="$" />
  <br />
  <label for="bands">Bands: </label>
  <textarea name="bands"></textarea>
  <br />
  <input type="submit" name="submit_button" id="submit_button" value="Add Show" class="submit" />
  </fieldset>
</form>