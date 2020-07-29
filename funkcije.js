function provera() {
	var error = "";
	var jmbg = document.getElementById("jmbg").value;
	var dat = document.getElementById("datum").value;
	var dan1 = dat.split("-")[2];
	var dan2 = jmbg.substring(0, 2);
	var mesec1 = dat.split("-")[1];
	var mesec2 = jmbg.substring(2, 4);
	var god1 = dat.split("-")[0];
	var god1 = god1.substring(1, 4);
	var god2 = jmbg.substring(4, 7);
	var S = 7*jmbg[0] + 6*jmbg[1] + 5*jmbg[2] + 4*jmbg[3] + 3*jmbg[4] + 2*jmbg[5] + 7*jmbg[6] + 6*jmbg[7] + 5*jmbg[8] + 4*jmbg[9] + 3*jmbg[10] + 2*jmbg[11];
	var K = true;
	if (S%11 == 0 && jmbg[12] != 0)
		K = false;
	if (S%11 == 1)
		K = false;
	if (S%11>1 && jmbg[12]!=11-(S%11))
		K = false;
	var patt = /^\d{13}$/;
	if ((dan1 != dan2) || (mesec1 != mesec2) || (god1 != god2) || !jmbg.match(patt) || K!=true) {
		error += "JMBG nije validan.";
		document.getElementById("jmbg").value = "";
	}
	var lozinka = document.getElementById("lozinka1").value;
	var patt_pass = /^[A-Z](?=.*\d)(?=.*\W)[0-9a-zA-Z\W]{7,}$|^[a-z](?=.*[A-Z])(?=.*\d)(?=.*\W)[0-9a-zA-Z\W]{7,}$/;
	if (!lozinka.match(patt_pass)) {
		error += "\nLozinka mora imati minimalno 8 karaktera, od toga bar jedno veliko slovo, jedan broj i jedan specijalni karakter, i mora pocinjati slovom.";
		document.getElementById("lozinka1").value = "";
		document.getElementById("lozinka2").value = "";
	}		
	var lozinka1 = document.getElementById("lozinka1").value;
	var lozinka2 = document.getElementById("lozinka2").value;
	if (lozinka1 != lozinka2) {
		error += "\nLozinke se ne poklapaju.";
		document.getElementById("lozinka2").value = "";
	}
				
	if (error != "")
		alert(error);
}
