window.onload = function(){
	var btn = document.getElementsByClassName('glyphicon');
	while(btn.length >= 0){
		document.removeNode(btn[0].parentNode);
	}
}