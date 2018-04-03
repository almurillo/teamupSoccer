function playerlist(pgameid){
	var pList = _(pgameid).value;
	//alert (pList);
	_("playerlist"+pList).style.display = (_("playerlist"+pList).style.display == "block") ? "none" : "block";
	//alert("Working so far...");
}