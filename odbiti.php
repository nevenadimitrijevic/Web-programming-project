<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu.inc.php");
$upit = "SELECT * FROM korisnik WHERE username='".$_GET['user']."' AND registrovan=0";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat)==1) {
	$upit = "DELETE FROM korisnik WHERE username='".$_GET['user']."' AND registrovan=0";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	header("Location: admin.php");
}
?>