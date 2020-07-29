<?php
include_once("DB.inc.php");
session_start();
$upit = "SELECT * FROM ankete WHERE naziv='".$_GET['anketa']."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat)==1) {
	$upit = "DELETE FROM ankete WHERE naziv='".$_GET['anketa']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_GET['anketa']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat)>0) {
	$upit = "DELETE FROM pitanja WHERE anketa_test='".$_GET['anketa']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	}
	$upit = "SELECT * FROM odgovori WHERE anketa_test='".$_GET['anketa']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat)>0) {
	$upit = "DELETE FROM odgovori WHERE anketa_test='".$_GET['anketa']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	}
	header("Location: kreator.php");
}

$upit = "SELECT * FROM testovi WHERE naziv='".$_GET['test']."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
if (mysqli_num_rows($rezultat)==1) {
	$upit = "DELETE FROM testovi WHERE naziv='".$_GET['test']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_GET['test']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat)>0) {
	$upit = "DELETE FROM pitanja WHERE anketa_test='".$_GET['test']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	}
	$upit = "SELECT * FROM odgovori WHERE anketa_test='".$_GET['test']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat)>0) {
	$upit = "DELETE FROM odgovori WHERE anketa_test='".$_GET['test']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	}
	header("Location: kreator.php");
}
?>