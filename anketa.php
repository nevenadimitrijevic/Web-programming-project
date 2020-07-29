<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu3.inc.php");
session_start();
$porukaPitanje = $porukaOdg = $porukaAnketa = "";
if (isset($_POST["kreiraj"])) {
	if (!empty($_POST["anketa"]) && isset($_POST["tip"]) && !empty($_POST["pocetak"]) && !empty($_POST["kraj"])) {
		$upit = "SELECT * FROM ankete WHERE naziv='".$_POST["anketa"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == 0) {
			$datum1 = strtotime($_POST["pocetak"]);
			$datum2 = strtotime($_POST["kraj"]);
			if ($datum2 > $datum1) {
				$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_POST["anketa"]."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				if (mysqli_num_rows($rezultat) == 0) {
					$porukaAnketa = "Anketa mora imati bar jedno pitanje!";
				}
				else {
					$upit = "SELECT * FROM ankete";
					$rezultat = mysqli_query($konekcija, $upit)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
					$idAnkete = mysqli_num_rows($rezultat);
					$upit = "INSERT INTO ankete (idAnkete, naziv, pocetak, kraj, tip, kreator) VALUES (".++$idAnkete.", '".$_POST["anketa"]."', '".$_POST["pocetak"]."', '".$_POST["kraj"].
					"', '".$_POST["tip"]."', '".$_SESSION["username"]."')";
					$rezultat = mysqli_query($konekcija, $upit);
					if ($rezultat) 
						$porukaAnketa = "Anketa '".$_POST["anketa"]."' je uspešno kreirana.";
					else
						$porukaAnketa = "Došlo je do greške, pokušajte ponovo.";
				}
			}
			else
				$porukaAnketa = "Interval trajanja ankete nije validan!";
		}
		else 
			$porukaAnketa = "Već postoji anketa sa datim imenom!";
	}
	else 
		$porukaAnketa = "Niste uneli potrebne podatke!";
}
if (isset($_POST["addQuestion"]) && !empty($_POST['anketa'])) {
	if (!empty($_POST["pitanje"]) && $_POST["tipoviOdg"]!="0" && !empty($_POST["brOdg"])) {
		$upit = "SELECT * FROM pitanja WHERE pitanje='".$_POST["pitanje"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == "1") {
			$porukaPitanje = "Pitanje je uspešno dodato (već postoji u bazi).";
		}
		else {
			$upit = "INSERT INTO pitanja (pitanje, broj_odgovora, tip_odgovora, anketa_test) VALUES ('".$_POST["pitanje"]."', ".$_POST["brOdg"].", '".$_POST["tipoviOdg"]."', '".$_POST["anketa"]."')";
			$rezultat = mysqli_query($konekcija, $upit);
			if ($rezultat) {
				$porukaPitanje = "Pitanje je uspešno dodato.";
			}
			else
				$porukaPitanje = "Došlo je do greške, pokušajte ponovo.";
		}
	}
	else
		$porukaPitanje = "Niste uneli potrebne podatke!";
}
	
if (isset($_POST["dodajOdg"]) && !empty($_POST["brOdg"])) {
	$br = $_POST["brOdg"];
	for ($i = 0; $i < $_POST["brOdg"]; $i++) {
		$upit = "SELECT idPitanja FROM pitanja WHERE pitanje='".$_POST["pitanje"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		$niz = mysqli_fetch_array($rezultat);
		$idPitanja = $niz["idPitanja"];
		$upit = "SELECT * FROM odgovori WHERE odgovor='".$_POST["odgovor".$br]."' AND idPitanja=".$idPitanja;
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == 0) {
			$upit = "INSERT INTO odgovori (odgovor, idPitanja, anketa_test) VALUES ('".$_POST["odgovor".$br--]."', ".$idPitanja.", '".$_POST["anketa"]."')";
			$rezultat = mysqli_query($konekcija, $upit);
			if ($rezultat)
				$porukaOdg = "Odgovori su uspešno dodati.";
			else
				$porukaOdg = "Došlo je do greške, pokušajte ponovo.";
		}
		else 
			$porukaOdg = "Podaci koje ste uneli nisu ispravni (odgovori glase isto ili već postoje u bazi), pokušajte ponovo.";
	}
}
?>
<html>
	<head>
		<title>Nova anketa</title>
		<link type = "text/css" rel = "stylesheet" href = "anketa.css">
	</head>
	<body>
		<form method = "POST" id = "mojaforma" action = "<?php echo $_SERVER["PHP_SELF"];?>">
		<h1><center>NOVA ANKETA</center></h1>
		<br/><hr>
		<?php
		echo "<span style = \"font-weight: bold;\">".$porukaAnketa."</span>";
		?>
		<br/>
			<table id = "tb1">
				<tr>
					<td>Naziv ankete:</td>
					<td><input type = "text" name = "anketa" value = "<?php if (isset($_POST["anketa"])) echo $_POST["anketa"];?>"></td>
				</tr>
				<tr>
					<td>Tip:</td>
					<td><input type = "radio" name = "tip" value = "A" <?php if (isset($_POST["tip"]) && $_POST["tip"] == "A") echo "checked";?>>Anonimna <br/><input type = "radio" name = "tip" value = "P" <?php if (isset($_POST["tip"]) && $_POST["tip"] == "P") echo "checked";?>>Personalizovana</td>
				</tr>
				<tr>
					<td>Vreme pocetka ankete:</td>
					<td><input type = "date" name = "pocetak" value = "<?php if (isset($_POST["pocetak"])) echo $_POST["pocetak"];?>"></td>
				</tr>
				<tr>
					<td>Vreme kraja ankete:</td>
					<td><input type = "date" name = "kraj" value = "<?php if (isset($_POST["kraj"])) echo $_POST["kraj"];?>"></td>
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
						<td>Broj odgovora:</td>
						<td><input type = "number" name = "brOdg" min = "1" value = "<?php if (isset($_POST["brOdg"])) echo $_POST["brOdg"];?>"></td>
					</tr>
					<tr>
						<td>Tip odgovora:</td>
						<td>
							<select name = "tipoviOdg">
								<option value = "0" hidden>Izaberi</option>
								<option value = "1" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "1") echo "selected";?>>Slobodan unos numericke vrednosti</option>
								<option value = "2" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "2") echo "selected";?>>Slobodan unos kratkog teksta</option>
								<option value = "3" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "3") echo "selected";?>>Slobodan unos dugackog teksta</option>
								<option value = "4" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "4") echo "selected";?>>Izbor jednog odgovora od vise ponudjenih</option>
								<option value = "5" <?php if (isset($_POST["tipoviOdg"]) && $_POST["tipoviOdg"] == "5") echo "selected";?>>Izbor vise odgovora od vise ponudjenih</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan = "2"><input type = "submit" name = "addQuestion" value = "Dodaj pitanje"></td>
					</tr>
				</table>
				<table>
				<?php
				if (isset($_POST["addQuestion"]) && $porukaPitanje != "Došlo je do greške, pokušajte ponovo." && ($_POST["tipoviOdg"] == "4" || ($_POST["tipoviOdg"]) == "5")) {
					$br = $_POST["brOdg"];
					echo "Odgovori na pitanje:";
					for ($i = 1; $i <= $_POST["brOdg"]; $i++) {
					?>
					<tr>
						<td colspan = "2"><?php echo "<br/>Odgovor broj ".$i;?> <input type = "text" name = "odgovor<?php echo $br--;?>" required></td>
					</tr>
					<?php
					}
					?>
					<br/>
					<tr>
						<td colspan = "2"><input type = "submit" name = "dodajOdg" value = "Dodaj odgovore"></td>
					</tr>
				<?php
				}
				else if (isset($_POST["dodajOdg"])) {
					?>
					<tr>
						<td colspan = "2"><?php echo "<span style = \"font-weight: bold;\">".$porukaOdg."</span>";?></td>
					</tr>
				<?php
				}
				?>
				</table>
				</div>
				<br/>
				<input type = "submit" class = "btn" name = "kreiraj" value = "Kreiraj anketu">
		</form>
	</body>
	<?php
	include_once("footer.inc.php");
	?>
</html>
