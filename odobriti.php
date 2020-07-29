<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu.inc.php");
$upit = "UPDATE korisnik SET registrovan=1 WHERE username='".$_GET['user']."'";
$rezultat = mysqli_query($konekcija, $upit)
	or die("Greska u upitu: " .mysqli_errno($konekcija));
if ($rezultat)
	header("Location: admin.php");
else 
	echo "Doslo je do greske, pokusajte ponovo.";
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
			a {
				text-decoration: none;
				color: black;
			}
		</style>
	</head>
	<body>
	</body>
</html>