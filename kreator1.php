<?php
require("header.inc.php");
include_once("DB.inc.php");
session_start();
$poruka = "";
if (!isset($_SESSION["username"])) 
	header("Location: index.php");
if (isset($_POST["anketa"])) {
	if (isset($_POST["aNaziv"]) && isset($_POST["aPoc"]) && isset($_POST["aKraj"]) && isset($_POST["aBrPitanja"]) && isset($_POST["aTip"]) 
	&& strtotime($_POST["aPoc"])<strtotime($_POST["aKraj"])) {
		$upit = "SELECT * FROM ankete WHERE naziv='".$_POST["aNaziv"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == 0) {
			$upit = "INSERT INTO ankete(naziv, pocetak, kraj, broj_pitanja, tip, kreator) 
			VALUES('".$_POST["aNaziv"]."', '".$_POST["aPoc"]."', '".$_POST["aKraj"]."', ".$_POST["aBrPitanja"].", '".$_POST["aTip"]."', '".$_SESSION["username"]."')";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			if ($rezultat)
				$poruka = "Anketa je uspesno dodata!";
			else
				$poruka = "Doslo je do greske, pokusajte ponovo!";
		}
		else
			$poruka = "Vec postoji anketa sa ovim imenom!";
	}
	else
		$poruka = "Neispravni podaci!";
}
$poruka2 = "";
if (isset($_POST["test"])) {
	if (isset($_POST["tNaziv"]) && isset($_POST["tPoc"]) && isset($_POST["tKraj"]) && isset($_POST["tBrPitanja"]) && isset($_POST["trajanje"]) 
	&& strtotime($_POST["tPoc"])<strtotime($_POST["tKraj"])) {
		$upit = "SELECT * FROM testovi WHERE naziv='".$_POST["tNaziv"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == 0) {
			$upit = "INSERT INTO testovi(naziv, pocetak, kraj, broj_pitanja, trajanje, kreator) 
			VALUES('".$_POST["tNaziv"]."', '".$_POST["tPoc"]."', '".$_POST["tKraj"]."', ".$_POST["tBrPitanja"].", ".$_POST["trajanje"].", '".$_SESSION["username"]."')";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			if ($rezultat)
				$poruka = "Test je uspesno dodat!";
			else
				$poruka = "Doslo je do greske, pokusajte ponovo!";
		}
		else
			$poruka2 = "Vec postoji test sa ovim imenom!";
	}
	else
		$poruka2 = "Neispravni podaci!";
}
?>
<html>
	<head>
	</head>
	<body>
		<form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
			<h1>Nova anketa:</h1>
			<div>
				<table>
					<tr>
						<td>Naziv ankete:</td>
						<td><input type = "text" name = "aNaziv"></td>
					</tr>
					<tr>
						<td>Vreme početka ankete:</td>
						<td><input type = "date" name = "aPoc"></td>
					</tr>
					<tr>
						<td>Vreme kraja ankete:</td>
						<td><input type = "date" name = "aKraj"></td>
					</tr>
					<tr>
						<td>Broj pitanja:</td>
						<td><input type = "number" name = "aBrPitanja"></td>
					</tr>
					<tr>
						<td>Tip ankete:</td>
						<td><input type = "radio" name = "aTip" value = "A">Anonimna <input type = "radio" name = "aTip" value = "P">Personalizovana</td>
					</tr>
					<tr>
						<td colspan = "2"><input type = "submit" name = "anketa" value = "Kreiraj anketu"></td>
					</tr>
				</table>
				<?php echo $poruka;?>
			</div>
			<br/>
			<div>
			<h1>Novi test:</h1>
				<form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
					<table>
						<tr>
							<td>Naziv testa:</td>
							<td><input type = "text" name = "tNaziv"></td>
						</tr>
						<tr>
							<td>Vreme početka testa:</td>
							<td><input type = "date" name = "tPoc"></td>
						</tr>
						<tr>
							<td>Vreme kraja testa:</td>
							<td><input type = "date" name = "tKraj"></td>
						</tr>
						<tr>
							<td>Broj pitanja:</td>
							<td><input type = "number" name = "tBrPitanja"></td>
						</tr>
						<tr>
							<td>Trajanje:</td>
							<td><input type = "number" name = "trajanje"></td>
						</tr>
						<tr>
							<td colspan = "2"><input type = "submit" name = "test" value = "Kreiraj test"></td>
						</tr>
					</table>
			</form>
			</div>
			<div>
			<h2>Pitanja i odgovori</h2>
				<form method = "POST" name = "<?php echo $_SERVER["PHP_SELF"];?>">
				<table>
					<tr>
						<td>Tekst pitanja:</td>
						<td><input type = "text" name = "pitanje"></td>
					</tr>
					<tr>
						<td>Za:</td>
						<td><input type = "radio" name = "tip" value = "A">anketu <input type = "radio" name = "tip" value = "T">test</td>
					</tr>
					<tr>
						<td>Naziv ankete/testa:</td>
						<td><input type = "text" name = "naziv"></td>
					</tr>
					<tr>
						<td>Broj odgovora:</td>
						<td><input type = "number" name = "brOdg"></td>
					</tr>
					<?php
					if (isset($_POST["dodajPitanje"]) && isset($_POST["pitanje"]) && isset($_POST["tip"]) && isset($_POST["naziv"]) && isset($_POST["brOdg"]))  {
							if ($_POST["tip"] == "A") {
								$upit = "SELECT * FROM ankete WHERE naziv='".$_POST["naziv"]."'";
								$rezultat = mysqli_query($konekcija, $upit)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
								if (mysqli_num_rows($rezultat) == 1) {
									for ($i = 0; $i < $_POST["brOdg"]; $i++) {
									?>
										<tr>
											<td>Vrsta odgovora:</td>
											<td>
												<select>
													<option hidden>Izaberi</option>
													<option value = "1">Slobodan unos numericke vrednosti</option>
													<option value = "2">Slobodan unos kratkog teksta</option>
													<option value = "3">Slobodan unos dugackog teksta</option>
													<option value = "4">Izbor jednog odgovora od vise ponudjenih</option>
													<option value = "5">Izbor vise odgovora od vise ponudjenih</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Odgovor:</td>
											<td><input type = "text" name = "odgovor<?php echo $i;?>"></td>
											</tr>
										<tr>
											<td colspan = "2">
												<input type = "submit" name = "dodajOdgovor" value = "dodaj Odgovor">
											</td>
										</tr>
									<?php
									}
								}
								else
									$aERR = "Ne postoji anketa sa datim imenom!";
							}
							else if ($_POST["tip"] == "T") {
								$upit = "SELECT * FROM testovi WHERE naziv='".$_POST["naziv"]."'";
								$rezultat = mysqli_query($konekcija, $upit)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
								if (mysqli_num_rows($rezultat) == 1) {
									?>
									<tr>
										<td>Broj poena koje nosi pitanje:</td>
										<td><input type = "number" name = "poeni"></td>
									</tr>
									<?php
									for ($i = 0; $i < $_POST["brOdg"]; $i++) {
									?>
										<tr>
											<td>Vrsta odgovora:</td>
											<td>
												<select>
													<option hidden>Izaberi</option>
													<option value = "1">Slobodan unos numericke vrednosti</option>
													<option value = "4">Izbor jednog odgovora od vise ponudjenih</option>
													<option value = "5">Izbor vise odgovora od vise ponudjenih</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Odgovor:</td>
											<td><input type = "text" name = "odgovor<?php echo $i;?>"></td>
											</tr>
										<tr>
											<td colspan = "2">
												<input type = "submit" name = "dodajOdgovor" value = "dodaj Odgovor">
											</td>
										</tr>
									<?php
									}
								}
								else 
									 "Ne postoji test sa datim imenom!";
							}
					}
					else {
					?>
						<tr>
							<td colspan = "2"><input type = "submit" name = "dodajPitanje" value = "Dodaj pitanje"></td>
						</tr>
					<?php
					}
					?>
				</table>
				</form>
			</div>
		</form>
	</body>
</html>