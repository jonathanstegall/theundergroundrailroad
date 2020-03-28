<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>test</title>
</head>

<script type="text/javascript">
window.onload = function () {
	document.forms[0].onsubmit = function () {
		return ajaxFunction()
	}
}

function ajaxFunction()
  {
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
    xmlHttp.onreadystatechange=function()
      {
      if(xmlHttp.readyState==4)
        {
        document.myForm.time.value=xmlHttp.responseText;
        }
      }
    xmlHttp.open("POST","formtest.php",true);
    xmlHttp.send(null);
  }
</script>	

<body>
<form class="form" id="myForm" name="myForm" action="formtest.php" method="post">
  <fieldset class="structure">
  <legend>Contact Us</legend>
  <p>
    <label for="name">Name: </label>
    <input type="text" name="name" id="name" class="required" size="20" />
  </p>
  <p>
    <label for="email">Email: </label>
    <input type="text" name="email" id="email" class="required" size="20" />
  </p>
  <p>
    <label for="pass1">Password: </label>
    <input type="password" name="pass1" id="pass1" size="10" />
  </p>
  <p>
    <label for="pass2">Repeat password: </label>
    <input type="password" name="pass2" id="pass2" size="10" />
  </p>
  <p>
    <label for="dob">DOB [dd/mm/yyyy]: </label>
    <input type="text" name="dob" id="dob" size="10" />
  </p>
  <p>
    <label for="comments">Comments: </label>
    <textarea name="comments" id="comments" class="required"></textarea>
  </p>
  <p class="submit">
    <input type="submit" name="submit" id="submit" value="Create Account" />
  </p>
  </fieldset>
</form>
</body>
</html>
