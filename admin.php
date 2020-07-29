<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu2.inc.php");
$userErr = $emailErr = "";
$poruka = "";
if (isset($_POST['dodaj'])) {
	$upit = "SELECT * FROM korisnik WHERE username='".$_POST['user']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat) == 0) {
		$upit = "SELECT * FROM korisnik WHERE eposta='".$_POST["email"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) < 2) {
			$upit = "INSERT INTO korisnik(username, password, ime, prezime, datumrodj, mestorodj, jmbg, kontakt, eposta, tip, registrovan) 
			VALUES('".$_POST["user"]."', '".$_POST['lozinka1']."', '".$_POST['ime']."', '".$_POST['prezime']."', '".$_POST['datum']."', '".$_POST['mesto']."', 
			'".$_POST['jmbg']."', '".$_POST['telefon']."', '".$_POST["email"]."', '".$_POST['tip']."', 1)";
			$rezultat = mysqli_query($konekcija, $upit);
			if ($rezultat)
				$poruka = "&nbsp;&nbsp;Novi korisnik je uspešno dodat.";
			else
				$poruka = "&nbsp;&nbsp;Došlo je do greške, pokušajte ponovo.";
		}
		else 
			$emailErr = "Nalozi sa ovom email adresom već postoje!";
	}
	else 
		$userErr = "Nalog sa ovim korisničkim imenom već postoji!";
}
?>
<html>
	<head>
		<title>Administrator</title>
		<style>
			body {
				font-size: 110%;
				margin: 0;
				padding: 0;
				background: url('pozadina1.jpg');
				font-family: Georgia, serif;
			}
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			a {
				text-decoration: none;
				color: black;
			}
			.btn {
				padding: 10px;
				font-size: 15px;
				color: white;
				background: #5F9EA0;
				border: none;
				border-radius: 5px;
			}
			.novi td {
				border: none;
			}
			.novi table {
				border: none;
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
		</script>
	</head>
	<body>
		<br/>
		<h1>&nbsp;Zahtevi za registracijom</h1>
		<br/>
		<?php
		$upit = "SELECT * FROM korisnik WHERE registrovan=0";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat)==0) {
			echo "&nbsp;&nbsp;Trenutno nema zahteva za registracijom.";
		}
		else {
			?>
			<table style = "margin-left: 10px;">
				<tr>
					<th>Korisnicko ime</th>
					<th>Ime</th>
					<th>Prezime</th>
					<th>Datum rodjenja</th>
					<th>Mesto rodjenja</th>
					<th>JMBG</th>
					<th>Kontakt</th>
					<th>Email</th>
					<th>Zahtev za registracijom</th>
				</tr>
			<?php
			while ($niz = mysqli_fetch_array($rezultat)) {
				?>
				<tr>
					<td><?php echo $niz['username'];?></td>
					<td><?php echo $niz['ime'];?></td>
					<td><?php echo $niz['prezime'];?></td>
					<td><?php echo $niz['datumrodj'];?></td>
					<td><?php echo $niz['mestorodj'];?></td>
					<td><?php echo $niz['jmbg'];?></td>
					<td><?php echo $niz['kontakt'];?></td>
					<td><?php echo $niz['eposta'];?></td>
					<td align="center">
						<a href = "odobriti.php?user=<?php echo $niz['username'];?>">Odobri</a>/<a href = "odbiti.php?user=<?php echo $niz['username'];?>">Odbij</a>
					</td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
		}
		?>
		<br/><br/>
		<h1>&nbsp;Registrovani korisnici</h1>
		<br/>
		<?php
		$upit = "SELECT * FROM korisnik WHERE registrovan=1";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat)>0) {
			?>
			<table style = "margin-left: 10px;">
				<tr>
					<th>Korisnicko ime</th>
					<th>Sifra</th>
					<th>Ime</th>
					<th>Prezime</th>
					<th>Datum rodjenja</th>
					<th>Mesto rodjenja</th>
					<th>JMBG</th>
					<th>Kontakt</th>
					<th>Email</th>
					<th>Tip</th>
					<th>Azuriraj</th>
					<th>Obrisi</th>
				</tr>
			<?php
			while ($niz = mysqli_fetch_array($rezultat)) {
				?>
				<tr>
					<td><?php echo $niz["username"];?></td>
					<td><?php echo $niz["password"];?></td>
					<td><?php echo $niz["ime"];?></td>
					<td><?php echo $niz["prezime"];?></td>
					<td><?php echo $niz["datumrodj"];?></td>
					<td><?php echo $niz["mestorodj"];?></td>
					<td><?php echo $niz["jmbg"];?></td>
					<td><?php echo $niz["kontakt"];?></td>
					<td><?php echo $niz["eposta"];?></td>
					<td>
						<?php
						if ($niz["tip"] == "I") {
							echo "Ispitanik";
						}
						else if ($niz["tip"] == "K") {
							echo "Kreator";
						}
						else if ($niz["tip"] == "A") {
							echo "Administrator";
						}
						?>
					</td>
					<td><a href = "azuriraj.php?user=<?php echo $niz["username"];?>">Azuriraj</td>
					<td><a href = "brisanje.php?user=<?php echo $niz["username"];?>">Obrisi</td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
		}
		?>
		<br/><br/>
		<div class = "novi">
		<h1>&nbsp;Novi korisnik</h1>
		<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
			<?php echo $poruka;?>
			<table style = "margin-left: 10px;">
				<tr>
					<td>Ime:</td>
					<td>
						<input type = "text" name = "ime" value = "<?php if (isset($_POST["ime"]) && !empty($_POST["ime"])) echo $_POST["ime"];?>" required>
					</td>
				</tr>
				<tr>
					<td>Prezime:</td>
					<td>
						<input type = "text" name = "prezime" value = "<?php if (isset($_POST["prezime"]) && !empty($_POST["prezime"])) echo $_POST["prezime"];?>" required>
					</td>
				</tr>
				<tr>
					<td>Korisnicko ime:</td>
					<td>
						<input type = "text" name = "user" required>
						<span><?php echo $userErr;?></span>
					</td>
				</tr>
				<tr>
					<td>Lozinka:</td>
					<td>
						<input type = "password" name = "lozinka1" id = "lozinka1" value = "<?php if (isset($_POST["lozinka1"]) && !empty($_POST["lozinka1"])) echo $_POST["lozinka1"];?>" id = "lozinka1" required>
					</td>
				</tr>
				<tr>
					<td>Potvrdi lozinku:</td>
					<td>
						<input type = "password" name = "lozinka2" id = "lozinka2" value = "<?php if (isset($_POST["lozinka2"]) && !empty($_POST["lozinka2"])) echo $_POST["lozinka2"];?>" id = "lozinka2" required>
					</td>
				</tr>
				<tr>
					<td>Datum rodjenja:</td>
					<td>
						<input type = "date" style = "width:172px;" name = "datum" id = "datum" value = "<?php if (isset($_POST["datum"]) && !empty($_POST["datum"])) echo $_POST["datum"];?>" required>
					</td>
				</tr>
				<tr>
					<td>Mesto rodjenja:</td>
					<td>
						<input type = "text" name = "mesto" value = "<?php if (isset($_POST["mesto"]) && !empty($_POST["mesto"])) echo $_POST["mesto"];?>" required>
					</td>
				</tr>
				<tr>
					<td>JMBG:</td>
					<td>
						<input type = "text" name = "jmbg" id = "jmbg" value = "<?php if (isset($_POST["jmbg"]) && !empty($_POST["jmbg"])) echo $_POST["jmbg"];?>" required>
					</td>
				</tr>
				<tr>
					<td>Kontakt telefon:</td>
					<td>
						<input type = "text" name = "telefon" value = "<?php if (isset($_POST["telefon"]) && !empty($_POST["telefon"])) echo $_POST["telefon"];?>" required>
					</td>
				</tr>
				<tr>
					<td>Email adresa:</td>
					<td>
						<input type = "text" name = "email" value = "<?php if (isset($_POST["email"]) && !empty($_POST["email"])) echo $_POST["email"];?>" required>
						<span><?php echo $emailErr;?></span>
					</td>
				</tr>
				<tr>
					<td>Tip:</td>
					<td>
						<input type = "radio" name = "tip" value = "I" <?php if (isset($_POST['tip']) && $_POST['tip']=='I') echo "checked";?>>Ispitanik
						<input type = "radio" name = "tip" value = "K" <?php if (isset($_POST['tip']) && $_POST['tip']=='K') echo "checked";?>>Kreator
						<input type = "radio" name = "tip" value = "A" <?php if (isset($_POST['tip']) && $_POST['tip']=='A') echo "checked";?>>Administrator
					</td>
				</tr>
				<tr>
					<td colspan = '2'>
					<button type = 'submit' class = 'btn' name = 'dodaj' onClick = "provera();">Dodaj</button>
					</td>
				</tr>
			</table>
		</form>
		</div>
	</body>
</html>
<?php
include_once('footer.inc.php');
?>