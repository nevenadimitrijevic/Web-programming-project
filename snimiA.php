<?php
include("DB.inc.php");
session_start();
$upit1 = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["anketa"]."'";
$rezultat1 = mysqli_query($konekcija, $upit1)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
$brojPitanja = mysqli_num_rows($rezultat1);
$upit2 = "SELECT * FROM snimi";
$rezultat2 = mysqli_query($konekcija, $upit2)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
$upit = "SELECT * FROM snimi WHERE anketa_test='".$_SESSION["anketa"]."' AND korisnik ='".$_SESSION["username"]."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat)>0) {
	$upit = "DELETE FROM snimi WHERE anketa_test='".$_SESSION["anketa"]."' AND korisnik ='".$_SESSION["username"]."'"; 
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
}
for ($br = 0; $br<$brojPitanja; $br++) { //brojac za $_SESSION["pitanja"][brojac] i $_SESSION["odgovori"][brojac] ide do broja pitanja u anketi
	$upit3 = "INSERT INTO snimi (pitanje, odgovor, anketa_test, korisnik) 
	VALUES ('".$_SESSION["pitanja"][$br]."', '".$_SESSION["odgovori"][$br]."', '".$_SESSION["anketa"]."', '".$_SESSION["username"]."')";
	$rezultat3 = mysqli_query($konekcija, $upit3)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
}
header("Location: ispitanik.php");
?>