//AJAX request για την βαθμολογια ου εδωσε ο χρηστης

function rates(rate,id) {
	if(window.XMLHttpRequest) {
		var xmlHttp = new XMLHttpRequest();
	}
	else {
		var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
			document.getElementById('rating'+id).innerHTML = xmlHttp.responseText;
		}
	};
	
	xmlHttp.open("GET","rate.php?value="+rate+"&movie_id="+id,true);
	xmlHttp.send();
}