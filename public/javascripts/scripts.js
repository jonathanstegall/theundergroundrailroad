// main javascript document
// open links with window class in a new window
function externalLinks() {
 if (!document.getElementsByTagName) return;
 var anchors = document.getElementsByTagName("a");
 for (var i=0; i<anchors.length; i++) {
   var anchor = anchors[i];
   if (anchor.getAttribute("href") &&
       anchor.getAttribute("class") == "window")
     anchor.target = "_blank";	 
 }
}
//window.onload = externalLinks;

// use multiple occurences of window.onload by calling them after this function
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}
// stuff that should happen when the page loads
addLoadEvent(externalLinks);
addLoadEvent(function() {
  /* more code to run on page load */ 
});

