<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu2.inc.php");
$poruka = "";
if (isset($_POST["azuriranje"])) {
	$upit = "SELECT * FROM korisnik WHERE username='".$_POST["user"]."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat) == 1) {
	$upit = "DELETE FROM korisnik WHERE username='".$_POST["user"]."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	$upit = "INSERT INTO korisnik (username, password, ime, prezime, datumrodj, mestorodj, jmbg, kontakt, eposta, tip, registrovan) 
	VALUES('".$_POST['user']."', '".$_POST['pass']."', '".$_POST['ime']."', '".$_POST['prezime']."', '".$_POST['datumrodj']."', '".$_POST['mestorodj']."', '"
	.$_POST['jmbg']."', '".$_POST['kontakt']."', '".$_POST['eposta']."', '".$_POST['tip']."', 1)";
	$rezultat = mysqli_query($konekcija, $upit);
	if ($rezultat)
		$poruka = "Azuriranje je uspešno izvršeno.";
	else
		$poruka = "Došlo je do greške, pokušajte ponovo.";
	}
}
?>
<html>
	<head>
		<style>
			body {
				font-size: 110%;
				margin: 0;
				padding: 0;
				background: url('pozadina1.jpg');
				font-family: Georgia, serif;
			}
			#azuriranje {
				width: 30%;
				margin: 30px auto 100px;
				padding: 10px;
				border: 1px solid #B0C4DE;
				background: white;
				border-radius: 10px 10px 10px 10px;
			}
			.btn {
				padding: 10px;
				font-size: 15px;
				color: white;
				background: #5F9EA0;
				border: none;
				border-radius: 5px;
			}
			a {
				text-decoration: none;
				color: black;
			}
		</style>
		<script>
			function provera() {
				var error = "";
				var jmbg = document.getElementById("jmbg").value;
				var dat = document.getElementById("datum").value;
				var dan1 = dat.split("-")[2];
				var dan2 = jmbg.substring(0, 2);
				var mesec1 = dat.split("-")[1];
				var mesec2 = jmbg.substring(2, 4);
				var god1 = dat.split(".")[0];
				var god1 = god1.substring(1, 4);
				var god2 = jmbg.substring(4, 7);
				var S = 7*jmbg[0] + 6*jmbg[1] + 5*jmbg[2] + 4*jmbg[3] + 3*jmbg[4] + 2*jmbg[5] + 7*jmbg[6] + 6*jmbg[7] + 5*jmbg[8] + 4*jmbg[9] + 3*jmbg[10] + 2*jmbg[11];
				var patt = /^\d{13}$/;
				if ((dan1 != dan2) || (mesec1 != mesec2) || (god1 != god2) || !jmbg.match(patt)) {
					error += "JMBG nije validan.";
					document.getElementById("jmbg").value = "";
				}
				var lozinka = document.getElementById("pass").value;
				var patt_pass = /^[A-Z](?=.*\d)(?=.*\W)[0-9a-zA-Z\W]{7,}$|[a-z](?=.*[A-Z])(?=.*\d)(?=.*\W)[0-9a-zA-Z\W]{7,}/;
				if (!lozinka.match(patt_pass)) {
					error += "\nLozinka mora imati minimalno 8 karaktera, od toga bar jedno veliko slovo, jedan broj i jedan specijalni karakter, i mora pocinjati slovom.";
					document.getElementById("pass").value = "";
				}
				if (error != "")
					alert(error);
			}
		</script>
	</head>
	<body>
		<div id = "azuriranje">
		<?php
		if (!$poruka) {
		?>
			<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
				<table>
					<?php
					$upit = "SELECT * FROM korisnik WHERE username='".$_GET['user']."'";
					$rezultat = mysqli_query($konekcija, $upit)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
					while ($niz = mysqli_fetch_array($rezultat)) {
					?>
						<tr>
							<td>Korisnicko ime:</td>
							<td><input type = "text" name = "user" value = "<?php if (isset($_POST['user'])) echo $_POST["user"];
							else echo $niz["username"];?>" required></td>
						</tr>
						<tr>
							<td>Sifra:</td>
							<td><input type = "pass" id = "pass" name = "pass" value = "<?php if (isset($_POST['pass'])) echo $_POST["pass"];
							else echo $niz["password"];?>" required></td>
						</tr>
						<tr>
							<td>Ime:</td>
							<td><input type = "text" name = "ime" value = "<?php if (isset($_POST['ime'])) echo $_POST["ime"];
							else echo $niz["ime"];?>" required></td>
						</tr>
						<tr>
							<td>Prezime:</td>
							<td><input type = "text" name = "prezime" value = "<?php if (isset($_POST['prezime'])) echo $_POST["prezime"];
							else echo $niz["prezime"];?>" required></td>
						</tr>
						<tr>
							<td>Datum rodjenja:</td>
							<td><input type = "date" name = "datumrodj" id = "datum" value = "<?php if (isset($_POST['datumrodj'])) echo $_POST["datumrodj"];
							else echo $niz["datumrodj"];?>" required></td>
						</tr>
						<tr>
							<td>Mesto rodjenja:</td>
							<td><input type = "text" name = "mestorodj" value = "<?php if (isset($_POST['mestorodj'])) echo $_POST["mestorodj"];
							else echo $niz["mestorodj"];?>" required></td>
						</tr>
						<tr>
							<td>JMBG:</td>
							<td><input type = "text" id = "jmbg" name = "jmbg" value = "<?php if (isset($_POST['jmbg'])) echo $_POST["jmbg"];
							else echo $niz["jmbg"];?>" required></td>
						</tr>
						<tr>
							<td>Kontakt:</td>
							<td><input type = "number" name = "kontakt" value = "<?php if (isset($_POST['kontakt'])) echo $_POST["kontakt"];
							else echo $niz["kontakt"];?>" required></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><input type = "text" name = "eposta" value = "<?php if (isset($_POST['eposta'])) echo $_POST["eposta"];
							else echo $niz["eposta"];?>" required></td>
						</tr>
						<tr>
							<td>Tip:</td>
							<td>
							<input type = "radio" name = "tip" value = "I" <?php if ($niz['tip'] == "I" || (isset($_POST['tip']) && $_POST['tip'] == "I")) echo "checked";?>>Ispitanik
							<input type = "radio" name = "tip" value = "K" <?php if ($niz['tip'] == "K" || (isset($_POST['tip']) && $_POST['tip'] == "K")) echo "checked";?>>Kreator
							<input type = "radio" name = "tip" value = "A" <?php if ($niz['tip'] == "A" || (isset($_POST['tip']) && $_POST['tip'] == "A")) echo "checked";?>>Administrator
							</td>
						</tr>
						<tr>
							<td colspan = "2">
							<button type = "submit" name = "azuriranje" class = "btn" onClick = "provera();">Azuriraj</button>
							</td>
						</tr>
					<?php
					}
					?>
				</table>
			</form>
		<?php
		}
		else {
			echo $poruka;
		}
		?>
		</div>
	</body>
</html>