
	var validNums = /[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY\ ]/;

function validateKeyPress(e, validSet) 
{ 
    var key; 
    var keychar; 
         
    if(window.event || !e.which) // IE 
        key = e.keyCode; // IE 
    else if(e)  
        key = e.which;   // Netscape 
    else 
        return true;     // no validation 

    keychar = String.fromCharCode(key); 
    validSet += String.fromCharCode(8); 

    if (validSet.indexOf(keychar) < 0) 
      return false; 

    return true;  
} 