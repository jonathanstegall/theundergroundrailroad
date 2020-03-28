<?php
/* Credits - based on class_session.php by Troy Wolf [troy@troywolf.com] */

/* Description....: A session management and password protection class.
                   This class can be used to perform 2 major functinos:
                      1. Create and maintain session state between page hits.
                         This class does this using simple session cache files
                         into which the session is stored as a serialized array.
                         This is similar to how PHP's built-in sessions store
                         session data.  One big advantage of this class is that
                         you have full control over the session time-out.
                      2. Password protect PHP pages by requiring authentication.
                         Simply pass in "true" when creating a new session
                         object to use this functionality. You'll also need to
                         create your own login.php script. A sample login.php
                         is packaged with this class.
                   
look at the cleanAll() method in this class.
*/
class session {

	var $id;
	var $data;
	var $log;
	var $dir;
	var $filename;
	var $login_page;
 
	// construct the class
	function session($login_required=false) {
    	$this->log = "session() called<br />";
    	$ret = true;
    	// the data array holds all the session values
    	$this->data = array();
		// this is the page that people are redirected to if they are not logged in
		$this->login_page = "login.php";
		// store the sessions in this directory - it must always be above the root
   		$this->dir = $_SERVER['DOCUMENT_ROOT'] . '/../temp/';
		
		if ($this->exists()) {
			$this->log .= "sid: ".$this->id."<br />";
			if (!$this->load()) {
				// session needs to be restarted
				$this->log .= "Could not restore session.<br />";
				$ret = true;
			}
		} else {
			if (!$this->newId()) {
			$this->log .= "Could not create new session.<br />";
			$ret = false;
		  }
		  $this->log .= "sid: ".$this->id."<br />";
		}
		// if a login is required, run it and redirect them to the login page
		if ($login_required) {
			$this->log .= "Require login requested<br />";
			if (!$this->data['logged_in']) {
				$this->log .= "Not logged in, redirecting to "
				.$this->login_page."<br />"; 
				$this->data['page_destination'] = $_SERVER['SCRIPT_NAME'];
				$this->save();
				header("Location: ".$this->login_page);
			}
		}
			return $ret;
		}
  
	/* expire() is good for logging out - it empties the session data, deletes the session file, and expires the sid cookie */
	function expire() {
		$this->log .= "expire() called<br />";
		$ret = true;
		$this->data = array();
		if (!file_exists($this->filename)) {
			$this->log .= $this->filename." does not exist.<br />";
			$ret = false;
		} else {
			if (!@unlink($this->filename)) {
				$this->log .= "session file delete failed for "
				.$this->filename."<br />";
				$ret = false;
			}
		}
		if (!setcookie('sid' ,$this->id, time()-3600, "/")) {
			$this->log .= "sid cookie expire failed. This may be due to browser"
			." output started prior.<br />";
			$ret = false;
		}
		return $ret;
	}

	// checks for a cookie and sets one if it is found
	function exists() {
		$this->log .= "exists() called<br />";
		if (!isset($_COOKIE['sid'])) {
		  $this->log .= "sid cookie does not exist.<br />";
		  return false;
		}
		$this->id = $_COOKIE['sid'];
		$this->filename = $this->dir."sid_".$this->id;
		return true;
	}

	// generates the session id as a random 32 character string for the cookie to use
	function newId() {
		$this->log .= "newId() called<br />";
		$this->id = md5(uniqid(rand(), true));
		$this->filename = $this->dir."sid_".$this->id;
		if (!setcookie('sid' ,$this->id, null, "/")) {
			$this->log .= "sid cookie save failed. This may be due to browser"
			." output started prior or the user has disabled cookies.<br />";
			return false;
		}
			return true;
	}
  
	// loads the session data
	function load() {
		$this->log .= "load() called<br />";
		if (!file_exists($this->filename)) {
			$this->log .= $this->filename." does not exist.<br />";
			return false;
		}
		if (!$x = @file_get_contents($this->filename)) {
			$this->log .= "Could not read ".$this->filename."<br />";
			return false;
		}
		if (!$this->data = unserialize($x)) {
			$this->log .= "unserialize failed<br />";
			$this->data = array();
			return false;
		}
			return true;
		}

	// stores the session data
	function save() {
		$this->log .= "save() called<br />";
		if (count($this->data) < 1) {
			$this->log .= "Nothing to save.<br />";
			return false;
		}
		//create file pointer
		if (!$fp=@fopen($this->filename,"w")) {
			$this->log .= "Could not create or open ".$this->filename."<br />";
			return false;
		}
		//write to file
		if (!@fwrite($fp,serialize($this->data))) {
			$this->log .= "Could not write to ".$this->filename."<br />";
			fclose($fp);
			return false;
		}
		//close file pointer
		fclose($fp);
		return true;
	}
  /* cleanAll() will clean up the session dir removing all 'sid_' files with a 
  modified date older than the number of minutes passed in */
	function cleanAll($minutes) {
		$this->log .= "cleanAll() called to delete sessions older than "
		.$minutes." minutes<br />";
		chdir($this->dir);
		$ret = shell_exec("find -type f -name 'sid_*' -maxdepth 1 -mmin +".$minutes." -exec rm -f {} \;");
	} 
}
?>