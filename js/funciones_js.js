function cHoraCompleta() {
	var d = new Date();
	var $cTime = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds()+ "."+ d.getMilliseconds();
	return $cTime;
}