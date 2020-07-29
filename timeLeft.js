function timeout() {
	var minute = Math.floor(timeLeft/60);
	var second = timeLeft%60;
	var mint = checktime(minute);
	var sec = checktime(second);
	document.getElementById('time').innerHTML = mint + ':' + sec;
	if (timeLeft == 30) {
			alert('Ostalo vam je jos 30 sekundi do kraja testiranja.');
	}
	if (timeLeft==0) {
		document.getElementById('forma').submit();
	}
	else {
		timeLeft--;
		document.getElementById('trajanje').value = timeLeft;
	}
}
var tm = setTimeout('timeout()', 1000);
function checktime(msg) {
	if (msg<10) {
		msg = '0' + msg;
	}
	return msg;
	}
}