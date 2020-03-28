<?php

/* based on FormProcessor 0.3
   Simon Willison, 17th June 2003
   A work in progress
*/

/* modified by Jonathan Stegall - February, 2007 */

class FormProcessor {
    var $formML;
    var $rules = array();
    var $errormsgs = array();
    var $errors = array();
    var $output = '';
    
    var $errorClass = 'invalid';
    // Properties used during XML parsing for the form() method
    var $_parser;
    var $_copy = true; // Flag: should formML contents be copied to output?
    var $_saveForTemplate = false; // Flag: are we saving this for an erroritem template?
    var $_errorTemplate = '';
    var $_inTextArea = false;
	var $_inSelectBox = false;
    function FormProcessor($formML) {
        $this->formML = $formML;
        // Extract the validation rules
        $extractor =& new FormRuleExtractor($formML);
        $this->rules =& $extractor->rules;
        $this->errormsgs =& $extractor->errormsgs;
    }
    function validate() {
		// check to see if the form was posted - if not, stop processing due to spam
        function contains_bad_str($str_to_test) {
  			$bad_strings = array (
                "content-type:"
                ,"mime-version:"
                ,"multipart/mixed"
				,"Content-Transfer-Encoding:"
                ,"bcc:"
				,"cc:"
				,"to:"
  			);
		  foreach($bad_strings as $bad_string) {
			if(eregi($bad_string, strtolower($str_to_test))) {
			  echo "$bad_string found. Suspected injection attempt - form not submitted.";
			  exit;
			}
		  }
		}
		
		function contains_newlines($str_to_test) {
		   if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) {
			 echo "<p class=\"queryError\">newline found in $input. Suspected injection attempt - form not submitted.</p>";
			 exit;
		   }
		} 
		if (contains_bad_str($_POST[$name]) == true) {
			echo "<p class=\"queryError\">newline found in $input. Suspected injection attempt - form not submitted.</p>";
			exit;
		}
		if (contains_newlines($_POST[$name]) == true) {
			echo "<p class=\"queryError\">newline found in input. Suspected injection attempt - form not submitted.</p>";
			exit;
		}
		/*
		if($_SERVER['REQUEST_METHOD'] != "POST"){
		   return false;
		}
		if ($_POST) {
		   return false;
        }
		*/
        $this->errors = array();
        foreach ($this->rules as $name => $rules) {
            // Check if required field has not been filled
            if ($rules['required'] && (!isset($_POST[$name]) || trim($_POST[$name]) == '')) {
                $this->errors[$name] = $this->getErrorMsg($name, 'required');
                continue;
            }
            if (!isset($_POST[$name])) {
                // Field not set, and it's not required
                continue;
            }
            $value = $_POST[$name];
            // If a regular expression is specified, check using that
            if (isset($rules['regexp']) && !preg_match($rules['regexp'], $value)) {
                $this->errors[$name] = $this->getErrorMsg($name, 'regexp');
                continue;
            }
            // If there is a mustmatch rule, check using that
            if (isset($rules['mustmatch']) && $value != $_POST[$rules['mustmatch']]) {
                $this->errors[$name] = $this->getErrorMsg($name, 'mustmatch');
                continue;
            }
            // If there is a calback rule, run that function
            if (isset($rules['callback'])) {
                $callback = $rules['callback'];
                if (substr($callback, 0, 5) == 'this:') {
                    // It's actually a method on this class
                    $method = substr($callback, 5);
                    if (!$this->$method($value)) {
                        $this->errors[$name] = $this->getErrorMsg($name, 'callback');
                        continue;
                    }
                } else {
                    // It's just a normal function
                    if (!$callback($value)) {
                        $this->errors[$name] = $this->getErrorMsg($name, 'callback');
                        continue;
                    }
                }
            }
			if (isset($_POST['reset'])) {
				header("location: http://www.towngreeters.com/admin/index.php?page=home");
				return false;
			}
        }
        // All rules should now have been processed
        return count($this->errors) == 0;
    }
	function secureInput() {
		foreach ($_POST as $key => $value) {
			$value = htmlspecialchars($value);
			if (get_magic_quotes_gpc()) {
			 $value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
		}
	}
	//$this->secureInput();
	
    function display() {
        echo $this->form();
    }
    function form() {
        // Returns the XHTML for the form, after processing
        $this->output = '';
        $this->_parser = xml_parser_create();
        // Set XML parser to take the case of tags in to account
        xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
        // Set XML parser callback functions
        xml_set_object($this->_parser, $this);
        xml_set_element_handler($this->_parser, 'tag_open', 'tag_close');
        xml_set_character_data_handler($this->_parser, 'cdata');
        if (!xml_parse($this->_parser, $this->formML)) {
            die(sprintf('XML error: %s at line %d',
                xml_error_string(xml_get_error_code($this->_parser)),
                xml_get_current_line_number($this->_parser)));
        }
        xml_parser_free($this->_parser);
        return $this->output;
    }
    function tag_open($parser, $tag, $attr) {
        if (!$this->_copy) {
            return;
        }
        if ($this->_saveForTemplate) {
            if ($tag == 'message') {
                $this->_errorTemplate .= '%%%MESSAGE_HERE%%%';
            } else {
                $this->_errorTemplate .= '<'.$tag.$this->_makeAttr($attr);
                if (in_array($tag, array('br', 'img'))) {
                    $this->_errorTemplate .= ' />';
                } else {
                    $this->_errorTemplate .= '>';
                }
            }
            return;
        }
        $killattrs = array('required', 'validate', 'regexp', 'callback', 'mustmatch', 'errormsg');
        // Kill unrequired attributes
        foreach ($killattrs as $a) {
            unset($attr[$a]);
        }
        switch ($tag) {
            case 'error':
                if (!$_POST || !isset($this->errors[$attr['for']])) {
                    $this->_copy = false;
                }
                return;
            case 'errormsg':
                $this->_copy = false;
                return;
            case 'errorlist':
                if (!$_POST) {
                    // Stop copying
                    $this->_copy = false;
                    return;
                } else {
                    // We are going to be redisplaying, so keep copying
                    return;
                }
            case 'erroritem':
                $this->_saveForTemplate = true;
                return;
            case 'img':
            case 'br':
                // Empty tags
                $this->output .= '<'.$tag.$this->_makeAttr($attr).' />';
                return;
            case 'input':
                // Add the value attribute, if redisplaying
                if (isset($_POST[$attr['name']]) && $attr['type'] != 'password') {
                    $attr['value'] = htmlentities(stripslashes($_POST[$attr['name']]));
                }
                // Add an error class if an error occured
                if (isset($this->errors[$attr['name']])) {
                    $attr['class'] = isset($attr['class']) ? $attr['class'].' '.$this->errorClass : $this->errorClass;
                }
                $this->output .= '<'.$tag.$this->_makeAttr($attr).' />';
                return;
			case 'select': 
				// Would be nice to set this to false if value not set in $_POST
				// but would mess up validation if field was compulsory
				$this->_inSelectBox = $attr['name']; 
				// Add an error class if an error occured
				if (isset($this->errors[$attr['name']])) {
					$attr['class'] = isset($attr['class']) ? $attr['class'] . ' ' . $this->errorClass : $this->errorClass;
				} 
            break;
            case 'textarea':
                $this->_inTextArea = $attr['name'];
				break;
			case 'option': 
				if (isset($_POST[$attr['name']]) && $attr['type'] != 'password') {
					if ($attr['value'] == '') {
						$attr['class'] = isset($attr['class']) ? $attr['class'].' '.$this->errorClass : $this->errorClass;
					}
					//$this->_inSelectBox = $attr['name']; 
				}
        }
        // Add tag to the output
        $this->output .= '<'.$tag.$this->_makeAttr($attr).'>';
    }
    function cdata($parser, $data) {
        if ($this->_saveForTemplate) {
            $this->_errorTemplate .= $data;
            return;
        }
        if ($this->_copy) {
            $this->output.= $data;
        }
    }
    function tag_close($parser, $tag) {
        if ($this->_saveForTemplate && $tag != 'erroritem' && !in_array($tag, array('br', 'img', 'message'))) {
            $this->_errorTemplate .= '</'.$tag.'>';
            return;
        }
        switch ($tag) {
            case 'error':
            case 'errormsg':
            case 'errorlist':
                $this->_copy = true;
                break;
            case 'erroritem':
                // Stop saving this in the template
                $this->_saveForTemplate = false;
                // Now output all error messages using that template
                foreach ($this->errors as $name => $error) {
                    $this->output .= str_replace('%%%MESSAGE_HERE%%%', $error, $this->_errorTemplate);
                }
                return;
            case 'textarea':
                if (isset($_POST[$this->_inTextArea])) {
                    $this->output .= htmlentities(stripslashes($_POST[$this->_inTextArea]));
                }
                $this->output .= '</textarea>';
                $this->_inTextArea = false;
                break;
			case 'select':
                $this->output .= '</select>';
                $this->_inSelectBox = false;
                break;
            case 'img':
            case 'br':
            case 'input':
            case 'message':
                // Empty tags
                break;
            default:
                if ($this->_copy) {
                    $this->output.= '</'.$tag.'>';
                }
        }
    }
    function _makeAttr($attr) {
        $html = ' ';
        foreach ($attr as $name => $value) {
            $html .= $name.'="'.$value.'" ';
        }
        return substr($html, 0, -1); // Remove trailing space
    }
    function getErrorMsg($field, $test) {
        if (isset($this->errormsgs["$field:$test"])) {
            return $this->errormsgs["$field:$test"];
        }
        // No error message has been specified - generate one based on the $test
        switch ($test) {
            case 'regexp':
                return "Field '$field' contained invalid data";
            case 'required':
                return "Field '$field' must be filled in ";
            case 'mustmatch':
                return "'$field' must match '{$this->rules[$field]['mustmatch']}'";
            case 'callback':
            default:
                return "Field '$field' was not valid";
        }
    }
    function checkEmail($email) {
        // Used as callback or validate="email" shortcut
        return preg_match(
            '#^([a-zA-Z0-9_\\-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([a-zA-Z0-9\\-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)$#',
            $email
        );
        // Regexp from http://www.regexplib.com/REDetails.aspx?regexp_id=26
    }
}

class FormRuleExtractor {
    // Extracts the validation rules from the formML.
    // Implementation note: the 'validate' attribute is a convenience, it is converted in 
    // to either a regular expression rule or a callback
    var $rules = array();
    var $errormsgs;
    // Following variables used during XML parsing
    var $_parser;
    var $_errorMsgName;
    var $_errorMsgValue;
    var $_collectErrorMsg = false;
    function FormRuleExtractor($formML) {
        $this->_parser = xml_parser_create();
        // Set XML parser to take the case of tags in to account
        xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
        // Set XML parser callback functions
        xml_set_object($this->_parser, $this);
        xml_set_element_handler($this->_parser, 'tag_open', 'tag_close');
        xml_set_character_data_handler($this->_parser, 'cdata');
        if (!xml_parse($this->_parser, $formML)) {
            die(sprintf('XML error: %s at line %d',
                xml_error_string(xml_get_error_code($this->_parser)),
                xml_get_current_line_number($this->_parser)));
        }
        xml_parser_free($this->_parser);
    }
    function tag_open($parser, $tag, $attr) {
        // First, the stuff to deal with the errormsg tag and contents
        if ($tag == 'errormsg') {
            if (!isset($attr['field']) || !isset($attr['test'])) {
                // Die noisily
                die('FormML error: errormsg tag needs field and test attributes');
            }
            $this->_errorMsgName = $attr['field'].':'.$attr['test'];
            $this->_errorMsgValue = '';
            $this->_collectErrorMsg = true;
            return;
        }
        if ($this->_collectErrorMsg) {
            $this->_errorMsgValue .= '<'.$tag.$this->_makeAttr($attr);
            if (in_array($tag, array('br', 'img'))) {
                $this->_errorMsgValue .= ' />';
            } else {
                $this->_errorMsgValue .= '>';
            }
        }
        // Now the stuff to deal with everything else
        if (!in_array($tag, array('input', 'select', 'textarea'))) {
            return;
        }
        // Skip submit, image and reset fields
        if (isset($attr['type']) && in_array($attr['type'], array('submit', 'reset', 'image'))) {
            return;
        }
        $rules = array();
        if (isset($attr['type'])) {
            $rules['type'] = $attr['type'];
        } else {
            $rules['type'] = $tag;
        }
        $name = $attr['name'];
        // required="yes"
        if (isset($attr['required']) && $attr['required'] == 'yes') {
            $rules['required'] = true;
        }
        // validate="something"
        if (isset($attr['validate'])) {
            switch ($attr['validate']) {
                case 'alpha':
                    $rules['regexp'] = '|^([a-zA-z\s]{2,})$|';
                    break;
                case 'alphanumeric':
                    $rules['regexp'] = '|^[a-zA-Z0-9\s.\-_.,?!]+$|';
                    break;
                case 'numeric':
                    $rules['regexp'] = '|^[0-9]*$|';
                    break;
				case 'currency':
                    $rules['regexp'] = '|^[0-9\s.\-.,$]*$|';
                    break;
                case 'email':
                    $rules['callback'] = 'this:checkEmail';
                    break;
				case 'mysqldate':
                    $rules['regexp'] = '|^(\d{1,4})-(\d\d)-(\d\d)$|';
                    break;
            }
        }
        // callback="someFunction"
        if (isset($attr['callback'])) {
            $rules['callback'] = $attr['callback'];
        }
        // regexp="someregexp"
        if (isset($attr['regexp'])) {
            $rules['regexp'] = $attr['regexp'];
        }
        // mustmatch="something"
        if (isset($attr['mustmatch'])) {
            $rules['mustmatch'] = $attr['mustmatch'];
        }
        // Save the rules to $this->rules
        $this->rules[$name] = $rules;
    }
    function cdata($parser, $data) {
        if ($this->_collectErrorMsg) {
            $this->_errorMsgValue .= $data;
        }
    }
    function tag_close($parser, $tag) {
        if ($tag == 'errormsg') {
            $this->errormsgs[$this->_errorMsgName] = $this->_errorMsgValue;
            $this->_collectErrorMsg = false;
        }
        if ($this->_collectErrorMsg && !in_array($tag, array('br', 'img'))) {
            $this->_errorMsgValue .= '</'.$tag.'>';
        }
    }
    function _makeAttr($attr) {
        $html = ' ';
        foreach ($attr as $name => $value) {
            $html .= $name.'="'.$value.'" ';
        }
        return substr($html, 0, -1); // Remove trailing space
    }
}

?>