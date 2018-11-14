$(document).ready(function(){
    window.FindResults = function(x, y) {
    	if (x.length < 3) {
    		document.getElementById("Results").innerHTML= "Please enter at least 3 letters";
    		return;
    	}
    	
    	else {
    		var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange = function() {
    			if (this.readyState == 4 && this.status == 200) {
                	document.getElementById("Results").innerHTML = this.responseText;
            	}
       	 	};
       	
       	var url = "2018-NOX/search-results.php?s=";
       	url += y+"&q="+x
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        
        }
    }
});
