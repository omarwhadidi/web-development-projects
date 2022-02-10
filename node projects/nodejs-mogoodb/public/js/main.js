function livesearch(){


	var search= document.getElementById("searchuser").value ;
	if (search == ''){
	  	document.getElementById("result").style.display='none' ;
	}
	else {
	  	document.getElementById("result").style.display='block' ;
	
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("result").innerHTML = this.responseText;
		} };
		xhttp.open("GET", "xhr_requests.php?searchuser="+search, true);
		xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
		xhttp.send(); 

	}

}