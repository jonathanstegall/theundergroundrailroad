/* javascript to validate any form */
// based on Form error messages at http://www.quirksmode.org/dom/error.html

// modified by Jonathan Stegall - http://www.jonathanstegall.com/ - to target required tags

// figure out if the browser is dom compliant
var W3CDOM = (document.getElementsByTagName && document.createElement);

// when the page loads and the form submits, return the value of the validate function
window.onload = function () {
	document.forms[0].onsubmit = function () {
		return validate()
	}
}

//	getElementsByClassName function written by
//		Jonathan Snook, http://www.snook.ca/jonathan
//    	Add-ons by Robert Nyman, http://www.robertnyman.com
function getElementsByClassName(oElm, strTagName, strClassName){
    var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
    var arrReturnElements = new Array();
    strClassName = strClassName.replace(/\-/g, "\\-");
    var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
    var oElement;
    for(var i=0; i<arrElements.length; i++){
        oElement = arrElements[i];      
        if(oRegExp.test(oElement.className)){
            arrReturnElements.push(oElement);
        }   
    }
    return (arrReturnElements)
}

// validate function
function validate() {
	// start off assuming the form is valid and no errors are present
	validForm = true;
	firstError = null;
	errorstring = '';
	// var x = document.forms[0].elements; - originally got all elements
	// var x = document.getElementsByTagName("input"); - then it was getting all input elements
	// get all elements with the required class
	var x = getElementsByClassName(document, "*", "required");
	// and loop through them
	for (var i=0;i<x.length;i++) {
		// if any of them are empty, 
		if (!x[i].value) {
			// display an error message
			writeError(x[i],'Required');
		}
	}
	// if all of them have been read, and there is at least one error present
	if (i = x.length && firstError != null) {
		// return a false value for validForm, and stop processing
		return false;
	}
	// if the email does not have an @
	if (x['email'].value.indexOf('@') == -1) {
		// it's invalid
		writeError(x['email'],'Invalid email');
	}
	// if the browser is not dom compliant, display some annoying alerts
	if (!W3CDOM)
		alert(errorstring);
	// put the cursor on the first error
	if (firstError)
		firstError.focus();
	// if there are no errors, the vallidate function is true and the form can go to the server for processing
	if (validForm)
		return true;
	return false;
}

// function to write the errors
function writeError(obj,message) {
	// if validForm is false
	validForm = false;
	if (obj.hasError) return;
	// if the browser is dom compliant
	if (W3CDOM) {
		// make an object with the error class
		obj.className += ' error';
		// when they change it, assume they fixed it and remove the error
		obj.onchange = removeError;
		// write a span with a class of error
		var sp = document.createElement('span');
		sp.className = 'error';
		// put the error message in it
		sp.appendChild(document.createTextNode(message));
		// then stick it in the html
		obj.parentNode.appendChild(sp);
		obj.hasError = sp;
	}
	else {
		// this creates the alert if the browser is not dom compliant
		errorstring += obj.name + ': ' + message + '\n';
		obj.hasError = true;
	}
	if (!firstError)
		firstError = obj;
}

// removes the error, assuming that they fixed it if they typed something in the box
function removeError() {
	this.className = this.className.substring(0,this.className.lastIndexOf(' '));
	this.parentNode.removeChild(this.hasError);
	this.hasError = null;
	this.onchange = null;
}