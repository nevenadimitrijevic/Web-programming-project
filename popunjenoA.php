<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu3.inc.php");
session_start();
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
			#popunjeno {
				width: 30%;
				margin: 30px auto 100px;
				padding: 10px;
				border: 1px solid #B0C4DE;
				background: white;
				border-radius: 10px 10px 10px 10px;
			}
			a {
				text-decoration: none;
				color: black;
			}
		</style>
	</head>
	<body>
		<div id = "popunjeno">
			<?php
			echo "<h1>".$_GET['naziv']."</h1>";
			$upit2 = "SELECT * FROM ankete WHERE naziv='".$_GET['naziv']."'";
			$rezultat2 = mysqli_query($konekcija, $upit2)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			$niz2 = mysqli_fetch_array($rezultat2);
			$anonimna = 0;
			if ($niz2['tip'] == 'A') {
				echo "<br/>Ova anketa je anonimna.";
			}
			else {
				$anonimna = 1;
				echo "<br/><span style=\"font-size: 25px;\">Ova anketa je personalizovana.</span>";
			}
			echo "<br/><br/><hr>";
			$upit = "SELECT * FROM zakljucaj WHERE anketa_test='".$_GET['naziv']."'";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($rezultat));
			if (mysqli_num_rows($rezultat)>0) {
				$upit = "SELECT * FROM korisnik";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($rezultat));
				if (mysqli_num_rows($rezultat)>0) {
					while ($niz = mysqli_fetch_array($rezultat)) {
						$upit1 = "SELECT * FROM zakljucaj WHERE korisnik='".$niz['username']."' AND anketa_test='".$_GET['naziv']."'";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
						if (mysqli_num_rows($rezultat1)>0) {
							$br = 0;
							if ($anonimna == 1) {
								echo "<span style=\"font-size: 25px;\">Ime i prezime: ".$niz['ime']." ".$niz['prezime'];
								echo "<br/>Datum rodjenja: ".$niz['datumrodj']."</span><br/><br/>";
							}
							while ($niz1 = mysqli_fetch_array($rezultat1)) {
								echo ++$br.".".$niz1['pitanje'];
								echo "<br/>&nbsp;&nbsp;&nbsp;".$niz1['odgovor']."<br/>";
							}
							echo "<br/><hr></br>";
						}
					}
				}
			}
			else
				echo "<span style = 'font-weight: bold;'><br/>Anketa još uvek nije rađena od strane korisnika.</span>";
			?>
		</div>
	</body>
</html>
<?php
include_once("footer.inc.php");
?>