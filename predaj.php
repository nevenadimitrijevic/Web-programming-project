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
$_SESSION['timer'] = "";
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
			#krajTesta {
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
		<div id = 'krajTesta'>
			<?php
			echo "<h1>".$_SESSION['test']."</h1>";
			echo "<br/><span style=\"font-size: 25px;\">".$_SESSION['poruka']."</span>";
			$_SESSION['poeni'] = 0;
			$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["test"]."'";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			$brojPitanja = mysqli_num_rows($rezultat);
			$upit12 = "SELECT * FROM zakljucaj WHERE korisnik='".$_SESSION['username']."' AND anketa_test='".$_SESSION['test']."'";
			$rezultat12 = mysqli_query($konekcija, $upit12)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			if (mysqli_num_rows($rezultat12)>0) {
				$upit12 = "DELETE FROM zakljucaj WHERE anketa_test='".$_SESSION["test"]."' AND korisnik='".$_SESSION["username"]."'";
				$rezultat12 = mysqli_query($konekcija, $upit12)
					or die("Greska u upitu: ".mysqli_errno($konekcija));
			}
			for ($br = 0; $br<$brojPitanja; $br++) { //brojac za $_SESSION["pitanja"][brojac] i $_SESSION["odgovori"][brojac] ide do broja pitanja u testu
				$upit1 = "SELECT o.odgovor AS odgovor, o.tacno AS tacno FROM odgovori o, pitanja p WHERE o.tacno=1 AND p.pitanje='".$_SESSION["pitanja"][$br]."' AND p.idPitanja=o.idPitanja AND p.anketa_test='".$_SESSION["test"]."'";
				$rezultat1 = mysqli_query($konekcija, $upit1)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$upit2 = "SELECT * FROM pitanja WHERE pitanje='".$_SESSION["pitanja"][$br]."' AND anketa_test='".$_SESSION["test"]."'";
				$rezultat2 = mysqli_query($konekcija, $upit2)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$niz2 = mysqli_fetch_array($rezultat2);
				if (mysqli_num_rows($rezultat1)>0) {
					while ($niz1 = mysqli_fetch_array($rezultat1)) {
						if (strpos($_SESSION["odgovori"][$br], $niz1['odgovor']) !== false && $niz1['tacno'] == 1) {
							$_SESSION['poeni'] += $niz2['broj_poena']/$niz2['broj_tacnih'];
						}
					}
				}
			}
			echo "<br/><span style=\"font-size: 25px;\">Broj osvojenih poena na testu: ".$_SESSION['poeni']."</span><br/>";
			?>
			<br/>
			<hr>
			<?php
			$br = 0;
			$brPitanja = 0;
			while ($niz = mysqli_fetch_array($rezultat)) {
				echo "<br/>".++$brPitanja.". ".$niz['pitanje']." [".$niz['broj_poena']."]";
				if ($_SESSION['odgovori'][$br] != 'nema odgovora') {
					if ($niz['tip_odgovora'] == 1 || $niz['tip_odgovora'] == 2) {
						$upit3 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$_SESSION['test']."'";
						$rezultat3 = mysqli_query($konekcija, $upit3)
							or die("Greska u upitu: ".mysqli_errno($konekcija));
						$niz3 = mysqli_fetch_array($rezultat3);
						if ($_SESSION['odgovori'][$br] == $niz3['odgovor']) {
							echo "<br/>".$_SESSION['odgovori'][$br]." <span style = \"color:green;\"> &#10004; </span>";
							$upit11 = "INSERT INTO zakljucaj (pitanje, odgovor, poeni, korisnik, anketa_test) VALUES ('".
							$niz['pitanje']."', '".$_SESSION['odgovori'][$br]."', ".$niz['broj_poena'].", '".$_SESSION['username']."', '".$_SESSION['test']."')";
							$rezultat11 = mysqli_query($konekcija, $upit11)
								or die("Greska u upitu: " .mysqli_errno($konekcija));
						}
						else {
							echo "<br/>".$_SESSION['odgovori'][$br]."<span style = \"color:red;\"> &#10060; </span>";
							$upit11 = "INSERT INTO zakljucaj (pitanje, odgovor, poeni, korisnik, anketa_test) VALUES ('".
							$niz['pitanje']."', '".$_SESSION['odgovori'][$br]."', 0, '".$_SESSION['username']."', '".$_SESSION['test']."')";
							$rezultat11 = mysqli_query($konekcija, $upit11)
								or die("Greska u upitu: " .mysqli_errno($konekcija));
						}
					}
					else if ($niz['tip_odgovora'] == 3) {
						$upit3 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$_SESSION['test']."'";
						$rezultat3 = mysqli_query($konekcija, $upit3)
							or die("Greska u upitu: ".mysqli_errno($konekcija));
						while ($niz3 = mysqli_fetch_array($rezultat3)) {
							if ($niz3['odgovor'] == $_SESSION['odgovori'][$br] && $niz3['tacno'] == 1) {
								echo "<br/>".$_SESSION['odgovori'][$br]." <span style = \"color:green;\"> &#10004; </span>";
								$upit11 = "INSERT INTO zakljucaj (pitanje, odgovor, poeni, korisnik, anketa_test) VALUES ('".
								$niz['pitanje']."', '".$_SESSION['odgovori'][$br]."', ".$niz['broj_poena'].", '".$_SESSION['username']."', '".$_SESSION['test']."')";
								$rezultat11 = mysqli_query($konekcija, $upit11)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
							}
							else if ($niz3['odgovor'] == $_SESSION['odgovori'][$br] && $niz3['tacno'] == 0) {
								echo "<br/>".$_SESSION['odgovori'][$br]."<span style = \"color:red;\"> &#10060; </span>";
								$upit11 = "INSERT INTO zakljucaj (pitanje, odgovor, poeni, korisnik, anketa_test) VALUES ('".
								$niz['pitanje']."', '".$_SESSION['odgovori'][$br]."', 0, '".$_SESSION['username']."', '".$_SESSION['test']."')";
								$rezultat11 = mysqli_query($konekcija, $upit11)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
							}
							else
								echo "<br/>".$niz3['odgovor'];
						}
					}
					else if ($niz['tip_odgovora'] == 4) {
						$poeni = 0;
						$upit3 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$_SESSION['test']."'";
						$rezultat3 = mysqli_query($konekcija, $upit3)
							or die("Greska u upitu: ".mysqli_errno($konekcija));
						while ($niz3 = mysqli_fetch_array($rezultat3)) {
							if (strpos($_SESSION['odgovori'][$br], $niz3['odgovor']) && $niz3['tacno'] == 1) {
								echo "<br/>".$niz3['odgovor']." <span style = \"color:green;\"> &#10004; </span>";
								$poeni += $niz['broj_poena']/$niz['broj_tacnih'];
							}
							else if (strpos($_SESSION['odgovori'][$br], $niz3['odgovor']) && $niz3['tacno'] == 0)
								echo "<br/>".$niz3['odgovor']."<span style = \"color:red;\"> &#10060; </span>";
							else
								echo "<br/>".$niz3['odgovor'];
						}
						$upit11 = "INSERT INTO zakljucaj (pitanje, odgovor, poeni, korisnik, anketa_test) VALUES ('".
						$niz['pitanje']."', '".$_SESSION['odgovori'][$br]."', ".$poeni.", '".$_SESSION['username']."', '".$_SESSION['test']."')";
						$rezultat11 = mysqli_query($konekcija, $upit11)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
				}
				else 
					echo "<br/>".$_SESSION['odgovori'][$br];
				$br++;
				?>
				<br/>
				<?php
			}
			$upit4 = "SELECT * FROM korisnik WHERE username='".$_SESSION['username']."'";
			$rezultat4 = mysqli_query($konekcija, $upit4)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			$niz4 = mysqli_fetch_array($rezultat4);
			$ime = $niz4['ime'];
			$prezime = $niz4['prezime'];
			$upit5 = "INSERT INTO testovi_izvestaj (ime, prezime, poeni, test) VALUES ('".$ime."', '".$prezime."', ".$_SESSION['poeni'].", '".$_SESSION['test']."')";
			$rezultat5 = mysqli_query($konekcija, $upit5)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			?>
			<br/>
			<hr>
			<br/>
			<?php
			$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["test"]."'";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			$brojPitanja = mysqli_num_rows($rezultat);
			for ($br = 0; $br<$brojPitanja; $br++) {
				$_SESSION["pitanja"][$br] = "";
				$_SESSION["odgovori"][$br] = "";
			}
			$_SESSION["test"] = "";
			$_SESSION["poeni"] = 0;
			?>
		</div>
	</body>
</html>