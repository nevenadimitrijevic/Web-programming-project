<?php
include_once("DB.inc.php");
include_once("header.inc.php");
session_start();
$upit = "SELECT * FROM korisnik WHERE username='".$_SESSION["username"]."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greška u upitu: " .mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat) == 1) {
	$niz = mysqli_fetch_array($rezultat);
	if ($niz['tip'] == "K")
		include_once("menu3.inc.php");
	else if ($niz['tip'] == "I")
		include_once("menu1.inc.php");
}
$poruka = "";
if (isset($_POST["izmeni"])) {
	header("Location: snimiT.php");
}
if (isset($_POST["predaj"])) {
	header("Location: predaj.php");
}
$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["test"]."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
$brojPitanja = mysqli_num_rows($rezultat);
$odgovoreno = 0;
$pitanje = 0;
$odgovor = 0;
while ($niz = mysqli_fetch_array($rezultat)) {
	$_SESSION["pitanja"][$pitanje++] = $niz["pitanje"];
	$_SESSION["odgovori"][$odgovor] = "";
	$fleg = false;
	if ($niz["tip_odgovora"] == "3") {
		if (isset($_POST["pitanje".$niz['idPitanja']])) {
			$fleg = true;
			$_SESSION["odgovori"][$odgovor] = $_POST["pitanje".$niz['idPitanja']];	
		}
		if ($fleg == false) {
			$_SESSION["odgovori"][$odgovor] = "nema odgovora";
		}
		$odgovor++;
	}
	else if ($niz["tip_odgovora"] == "4") { 
		for ($i=1; $i<=$niz["broj_odgovora"]; $i++) {
			if (isset($_POST["odgovor".$i."pitanje".$niz['idPitanja']])) {
				$answer = $_POST["odgovor".$i."pitanje".$niz['idPitanja']];
				$fleg = true;
				$_SESSION["odgovori"][$odgovor] = $_SESSION["odgovori"][$odgovor]." ".$answer;
			}
		}
		if ($fleg == false) {
			$_SESSION["odgovori"][$odgovor] = "nema odgovora";
		}
		$odgovor++;
	}
	else {
	for ($i=1; $i<=$niz["broj_odgovora"]; $i++) { //kad se potvrdi forma tekstualna polja su automatski setovana pa moram da proveravam sa !empty
		if (!empty($_POST["odgovor".$i."pitanje".$niz['idPitanja']])) {
			$answer = $_POST["odgovor".$i."pitanje".$niz['idPitanja']];
			$fleg = true;
			$_SESSION["odgovori"][$odgovor] = $answer;	
			}
		}
		if ($fleg == false) {
			$_SESSION["odgovori"][$odgovor] = "nema odgovora";
		}
		$odgovor++;
	}
	if ($fleg == true) 
		$odgovoreno = $odgovoreno + 1;
}
$poruka = "Odgovorili ste na: " .$odgovoreno."/".$brojPitanja." pitanja";
$_SESSION["poruka"] = $poruka;
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
			#blok {
				width: 30%;
				margin: 50px auto 100px;
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
		</style>
	</head>
	<body>
		<div id = 'blok'>
			<?php
			$_SESSION['preostalo'] = $_POST['trajanje'];
			echo "<h1><center>".$_SESSION["test"]."</center></h1>";
			echo "<br/><center><span style=\"font-size: 30px;\">".$poruka."</span></center>";
			?>
			<form method = "POST" action = "popuniTest.php">
			<br/><br/>
			<center>
			<input type = "submit" class = "btn" name = "izmeni" value = "Izmeni odgovore"> <input type = "submit" class = "btn" name = "predaj" value = "Predaj odgvore">
			</center>
			</form>
		</div>
	</body>
</html>
<?php
if ($_SESSION['preostalo'] == 0 || $_POST['trajanje'] == 0) {
	header("Location: predaj.php");
}
?>