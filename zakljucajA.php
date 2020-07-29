<?php
include("DB.inc.php");
session_start();
$upit = "SELECT * FROM snimi WHERE anketa_test='".$_SESSION["anketa"]."' AND korisnik='".$_SESSION["username"]."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: ".mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat) != 0) {
	$upit = "DELETE FROM snimi WHERE anketa_test='".$_SESSION["anketa"]."' AND korisnik='".$_SESSION["username"]."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: ".mysqli_errno($konekcija));
}
$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["anketa"]."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
$brojPitanja = mysqli_num_rows($rezultat);
for ($br = 0; $br<$brojPitanja; $br++) { //brojac za $_SESSION["pitanja"][brojac] i $_SESSION["odgovori"][brojac] ide do broja pitanja u anketi
	$upit = "INSERT INTO zakljucaj (pitanje, odgovor, poeni, anketa_test, korisnik) VALUES ('".$_SESSION["pitanja"][$br]."', '".$_SESSION["odgovori"][$br]."', 0, '".$_SESSION["anketa"]."', '".$_SESSION["username"]."')";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
}
for ($br = 0; $br<$brojPitanja; $br++) {
	$_SESSION["pitanja"][$br] = "";
	$_SESSION["odgovori"][$br] = "";
	$_SESSION["anketa"] = "";
}
$upit = "SELECT * FROM korisnik WHERE username='".$_SESSION["username"]."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greška u upitu: " .mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat) == 1) {
	$niz = mysqli_fetch_array($rezultat);
	if ($niz['tip'] == "K")
		header("Location: kreator.php");
	else if ($niz['tip'] == "I")
		header("Location: ispitanik.php");
}
?>