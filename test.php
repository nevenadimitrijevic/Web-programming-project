<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu3.inc.php");
session_start();
$porukaPitanje = $porukaOdg = $porukaTest = "";
if (isset($_POST["kreiraj"])) {
	if (!empty($_POST["test"]) && isset($_POST["pocetak"]) && isset($_POST["kraj"])) {
		$upit = "SELECT * FROM testovi WHERE naziv='".$_POST["test"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == 0) {
			$datum1 = strtotime($_POST["pocetak"]);
			$datum2 = strtotime($_POST["kraj"]);
			if ($datum2 > $datum1) {
				$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_POST["test"]."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				if (mysqli_num_rows($rezultat) == 0) {
					$porukaTest = "Test mora imati bar jedno pitanje!";
				}
				else {
					$upit = "SELECT * FROM testovi";
					$rezultat = mysqli_query($konekcija, $upit)
						or die("Greška u upitu: " .mysqli_errno($konekcija));
					$idTesta = mysqli_num_rows($rezultat);
					$upit = "INSERT INTO testovi (idTesta, naziv, pocetak, kraj, trajanje_sek, kreator) VALUES (".++$idTesta.", '".$_POST["test"]."', '".$_POST["pocetak"]."', '".$_POST["kraj"].
					"', ".$_POST['trajanje'].", '".$_SESSION["username"]."')";
					$rezultat = mysqli_query($konekcija, $upit);
					if ($rezultat) 
						$porukaTest = "Test '".$_POST["test"]."' je uspešno kreiran.";
					else
						$porukaTest = "Došlo je do greške, pokušajte ponovo.";
				}
			}
			else
				$porukaTest = "Interval trajanja testa nije validan!";
		}
		else
			$porukaTest = "Već postoji test sa datim imenom!";
	}
	else
		$porukaTest = "Niste uneli potrebne podatke!";
}
if (isset($_POST["addQuestion"]) && !empty($_POST['test'])) {
	if (!empty($_POST["pitanje"]) && $_POST["tipoviOdg"]!="0" && !empty($_POST["brPoena"]) && !empty($_POST["brOdg"]) && !empty($_POST["brTac"])) {
		$upit = "SELECT * FROM pitanja WHERE pitanje='".$_POST["pitanje"]."' AND anketa_test='".$_POST["test"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == "1") {
			$porukaPitanje = "Pitanje je uspešno dodato (već postoji u bazi).";
		}
		else {
			$upit = "INSERT INTO pitanja (pitanje, broj_poena, broj_odgovora, broj_tacnih, tip_odgovora, anketa_test) VALUES ('".$_POST["pitanje"]."', ".$_POST["brPoena"].", ".$_POST["brOdg"].", ".$_POST['brTac'].", '".$_POST["tipoviOdg"]."', '".$_POST["test"]."')";
			$rezultat = mysqli_query($konekcija, $upit);
			if ($rezultat) {
				$porukaPitanje = "Pitanje je uspešno dodato.";
			}
			else
				$porukaPitanje = "Došlo je do greške, pokušajte ponovo.";
		}
	}
}

if (isset($_POST["dodajOdg"]) && !empty($_POST["brOdg"])) {
	$br = $_POST["brOdg"];
	for ($i = 0; $i < $_POST["brOdg"]; $i++) {
		$upit = "SELECT idPitanja FROM pitanja WHERE pitanje='".$_POST["pitanje"]."' AND anketa_test='".$_POST["test"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greška u upitu: " .mysqli_errno($konekcija));
		$niz = mysqli_fetch_array($rezultat);
		$idPitanja = $niz["idPitanja"];
		if ($_POST["tipoviOdg"] == "1") {
			$upit = "INSERT INTO odgovori (odgovor, tacno, idPitanja, anketa_test) VALUES (".$_POST['odgovor'.$idPitanja].", 1, ".$idPitanja.", '".$_POST['test']."')";
		}
		else if ($_POST["tipoviOdg"] == "2") {
			$upit = "INSERT INTO odgovori (odgovor, tacno, idPitanja, anketa_test) VALUES ('".$_POST['odgovor'.$idPitanja]."', 1, ".$idPitanja.", '".$_POST['test']."')";
		}
		else if ($_POST["tipoviOdg"] == "3" || $_POST["tipoviOdg"] == "4") {
			$upit = "INSERT INTO odgovori (odgovor, tacno, idPitanja, anketa_test) VALUES ('".$_POST["odgovor".$br]."', ".$_POST["tacno".$br].", ".$idPitanja.", '".$_POST["test"]."')";
		}
		$rezultat = mysqli_query($konekcija, $upit);
		if ($rezultat)
			$porukaOdg = "Odgovori su uspešno dodati";
		else
			$porukaOdg = "Došlo je do greške, pokušajte ponovo.";
		$br--;
	}
}
?>
<html>
	<head>
		<title>Novi test</title>
		<link type = "text/css" rel = "stylesheet" href = "test.css">
	</head>
	<body>
		<form method = "POST" id = "mojaforma" action = "<?php echo $_SERVER["PHP_SELF"];?>">
		<h1>NOVI TEST</h1>
		<br/>
		<hr>
		<?php
		echo "<span style = \"font-weight: bold;\">".$porukaTest."</span>";
		?>
		</br/>
			<table id = "tb1">
				<tr>
					<td>Naziv testa:</td>
					<td><input type = "text" name = "test" value = "<?php if (isset($_POST["test"])) echo $_POST["test"];?>"></td>
				</tr>
				<tr>
					<td>Vreme pocetka testa:</td>
					<td><input type = "date" style = "width: 172px;" name = "pocetak" value = "<?php if (isset($_POST["pocetak"])) echo $_POST["pocetak"];?>"></td>
				</tr>
				<tr>
					<td>Vreme kraja testa:</td>
					<td><input type = "date" style = "width: 172px;" name = "kraj" value = "<?php if (isset($_POST["kraj"])) echo $_POST["kraj"];?>"></td>
				</tr>
				<tr>
					<td>Trajanje testa u sekundama (najviše tri minuta):</td>
					<td><input type = "number" name = "trajanje" value = "<?php if (isset($_POST["trajanje"])) echo $_POST["trajanje"];?>" max = "180"></td>
				</tr>
				</table>
				<br/>
				DODAVANJE PITANJA 
				<div id = "id1">
				<?php 
				echo "<span style = \"font-weight: bold;\">".$porukaPitanje."</span>";
				?>
				<table id = "tb2">
					<tr>
						<td>Tekst pitanja:</td>
						<td><input type = "text" rows = "2" cols = "30" name = "pitanje" value = "<?php if (isset($_POST["pitanje"])) echo $_POST["pitanje"];?>"></td>
					</tr>
					<tr>
						<td>Broj poena:</td>
						<td><input type = "number" name = "brPoena" value = "<?php if (isset($_POST["brPoena"])) echo $_POST["brPoena"];?>"></td>
					</tr>
					<tr>
						<td>Broj odgovora:</td>
						<td><input type = "number" name = "brOdg" min = "1" value = "<?php if (isset($_POST["brOdg"])) echo $_POST["brOdg"];?>"></td>
					</tr>
					<tr>
						<td>Broj tacnih odgovora:</td>
						<td><input type = "number" name = "brTac" min = "1" value = "<?php if (isset($_POST["brTac"])) echo $_POST["brTac"];?>"></td>
					</tr>
					<tr>
						<td>Tip odgovora:</td>
						<td>
							<select name = "tipoviOdg">
								<option value = "0" hidden>Izaberi</option>
								<option value = "1" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "1") echo "selected";?>>Slobodan unos numericke vrednosti</option>
								<option value = "2" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "2") echo "selected";?>>Slobodan unos kratkog teksta</option>
								<option value = "3" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "3") echo "selected";?>>Izbor jednog odgovora od vise ponudjenih</option>
								<option value = "4" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "4") echo "selected";?>>Izbor vise odgovora od vise ponudjenih</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan = "2"><input type = "submit" name = "addQuestion" value = "Dodaj pitanje"></td>
					</tr>
				</table>
				</div>
				<table>
				<?php
				if (isset($_POST["addQuestion"]) && $porukaPitanje != "Došlo je do greške, pokušajte ponovo." && ($_POST["tipoviOdg"] == "1" || $_POST["tipoviOdg"] == "2" || $_POST["tipoviOdg"] == "3" || $_POST["tipoviOdg"] == "4")) {
					$br = $_POST["brOdg"];
					if ($_POST["tipoviOdg"] == "1") {
						$upit = "SELECT idPitanja FROM pitanja WHERE pitanje='".$_POST['pitanje']."' AND anketa_test='".$_POST['test']."'";
						$rezultat = mysqli_query($konekcija, $upit)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
						$niz = mysqli_fetch_array($rezultat);
						echo "Odgovor na pitanje:";
						?>
						<tr>
							<td colspan="2"><?php echo "<br/>"?><input type = "number" name = "odgovor<?php echo $niz['idPitanja'];?>"></td>
						</tr>
						<tr>
							<td colspan="2"><input type = 'submit' name = 'dodajOdg' value = 'Dodaj odgovor'></td>
						</tr>
					<?php
					}
					else if ($_POST["tipoviOdg"] == "2") {
						$upit = "SELECT idPitanja FROM pitanja WHERE pitanje='".$_POST['pitanje']."' AND anketa_test='".$_POST['test']."'";
							$rezultat = mysqli_query($konekcija, $upit)
								or die("Greska u upitu: " .mysqli_errno($konekcija));
							$niz = mysqli_fetch_array($rezultat);
							echo "Odgovor na pitanje:";
							?>
							<tr>
								<td colspan="2"><?php echo "<br/>"?><input type = "text" name = "odgovor<?php echo $niz['idPitanja'];?>"></td>
							</tr>
							<tr>
								<td colspan="2"><input type = 'submit' name = 'dodajOdg' value = 'Dodaj odgovor'></td>
							</tr>
						<?php
					}
					else if ($_POST["tipoviOdg"] == "3" || $_POST["tipoviOdg"] == "4") {
							echo "Odgovori na pitanje:";
							for ($i = 1; $i <= $_POST["brOdg"]; $i++) {
								?>
								<tr>
									<td colspan = "2"><?php echo "<br/>Odgovor broj ".$i;?> <input type = "text" name = "odgovor<?php echo $br;?>" required></td>
								</tr>
								<tr>
									<td colspan = "2"><input type = "radio" name = "tacno<?php echo $br;?>" value = "1">Tacno <input type = "radio" name = "tacno<?php echo $br;?>" value = "0">Netacno</td>
								</tr>
								<?php
								$br--;
							}
							?>
							<br/>
							<tr>
								<td colspan = "2"><input type = "submit" name = "dodajOdg" value = "Dodaj odgovore"></td>
							</tr>
				<?php
					}
				}
				else if (isset($_POST["dodajOdg"])) {
					?>
					<tr>
						<td colspan = "2"><?php 
						echo "<span style = \"font-weight: bold;\">".$porukaOdg."</span>";
						?>
						</td>
					</tr>
				<?php
				}
				?>
				</table>
				</div>
				<br/>
				<input type = "submit" class = "btn" name = "kreiraj" value = "Kreiraj test">
		</form>
	</body>
</html>
<?php
include_once("footer.inc.php");
?>