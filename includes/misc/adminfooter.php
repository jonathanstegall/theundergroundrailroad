<?php /* this is the interior of the footer div */ ?>

<ul id="foot">
  <li class="first">&copy; <?php echo date('Y'); ?></li>
  <li<?php if ('<body id="adminhome">') echo " class=\"current\""; ?>><a href="index.php" title="home">admin home</a></li>
  <li<?php if ($thisPage=="ministry") echo " class=\"current\""; ?>><a href="ministry.php" title="ministry">ministry</a></li>
  <li<?php if ($thisPage=="writings") echo " class=\"current\""; ?>><a href="writings.php" title="writings">writings</a></li>
  <li<?php if ($thisPage=="music") echo " class=\"current\""; ?>><a href="music.php" title="music">music</a></li>
  <li<?php if ($thisPage=="connect") echo " class=\"current\""; ?>><a href="connect.php" title="connect">connect</a></li>
  <li<?php if ($thisPage=="merchandise") echo " class=\"current\""; ?>><a href="merchandise.php" title="merchandise">merchandise</a></li>
  <li<?php if ($thisPage=="links") echo " class=\"current\""; ?>><a href="links.php" title="links">links</a></li>
</ul>
