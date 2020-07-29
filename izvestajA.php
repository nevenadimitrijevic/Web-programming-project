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
			#izvestaj {
				width: 30%;
				margin: 30px auto 100px;
				padding: 10px;
				border: 1px solid #B0C4DE;
				background: white;
				border-radius: 10px 10px 10px 10px;
			}
		</style>
	</head>
	<body>
		<div id = 'izvestaj'>
		<table>
			<?php
			echo "<h1>".$_GET['naziv']."</h1>";
			echo "<br/><hr>";
			$upit = "SELECT * FROM zakljucaj WHERE anketa_test='".$_GET['naziv']."'";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($rezultat));
			if (mysqli_num_rows($rezultat)>0) {
				$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_GET['naziv']."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greška u upitu: " .mysqli_errno($konekcija));
				$i = 1;
				while ($niz = mysqli_fetch_array($rezultat)) {
					echo "<br/>";
					echo $i++.".";
					echo $niz["pitanje"];
					$upit1 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$_GET['naziv']."'";
					$rezultat1 = mysqli_query($konekcija, $upit1)
						or die('Greška u upitu: ' .mysqli_errno($konekcija));
					if ($niz['tip_odgovora'] == 4 || $niz['tip_odgovora'] == 5) {
						while ($niz1 = mysqli_fetch_array($rezultat1)) {
								if ($niz['tip_odgovora'] == 4) {
									$upit2 = "SELECT * FROM zakljucaj WHERE pitanje='".$niz['pitanje']."' AND odgovor='".$niz1['odgovor']."' AND anketa_test='".$_GET['naziv']."'";
									$rezultat2 = mysqli_query($konekcija, $upit2)
										or die("Greska u upitu: " .mysqli_errno($konekcija));
									$br = mysqli_num_rows($rezultat2);
									$upit3 = "SELECT * FROM zakljucaj WHERE pitanje='".$niz['pitanje']."' AND anketa_test='".$_GET['naziv']."'";	
									$rezultat3 = mysqli_query($konekcija, $upit3)
										or die("Greska u upitu: " .mysqli_errno($konekcija));
									$ukupno = mysqli_num_rows($rezultat3);
									$procenat = 100*$br/$ukupno;
									$sirina = 100*$br/$ukupno;
									echo "<br/>&nbsp;&nbsp;&nbsp;".$niz1['odgovor']." <img src='pink.jpg' style=\"height:10px;width:".$sirina."px;\">".$procenat."% ".$br;
								}
								else if ($niz['tip_odgovora'] == 5) {
									$upit3 = "SELECT * FROM zakljucaj WHERE pitanje='".$niz['pitanje']."' AND anketa_test='".$_GET['naziv']."'";	
									$rezultat3 = mysqli_query($konekcija, $upit3)
										or die("Greska u upitu: " .mysqli_errno($konekcija));
									$ukupno = mysqli_num_rows($rezultat3);
									$br = 0;
									while ($niz3 = mysqli_fetch_array($rezultat3)) {
										if (strpos($niz3['odgovor'], $niz1['odgovor']) !== false) {
											$br += 1;
										}
									}
									$procenat = 100*$br/$ukupno;
									$sirina = 100*$br/$ukupno;
									echo "<br/>&nbsp;&nbsp;&nbsp;".$niz1['odgovor']." <img src='pink.jpg' style=\"height:10px;width:".$sirina."px;\">".$procenat."% ".$br;
								}
						}
					}
					else if ($niz['tip_odgovora'] == 1 || $niz['tip_odgovora'] == 2 || $niz['tip_odgovora'] == 3) {
						$_SESSION['odgovor'] = "";
						$upit1 = "SELECT * FROM zakljucaj WHERE pitanje='".$niz['pitanje']."' AND anketa_test='".$_GET['naziv']."'";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
						while ($niz1 = mysqli_fetch_array($rezultat1)) {
							if ((strpos($_SESSION['odgovor'], $niz1['odgovor']) == false) && ($niz1['odgovor'] != "nema odgovora")) {
								$_SESSION['odgovor'] = $_SESSION['odgovor']." ".$niz1['odgovor'];
								$upit2 = "SELECT * FROM zakljucaj WHERE pitanje='".$niz['pitanje']."' AND odgovor='".$niz1['odgovor']."' AND anketa_test='".$_GET['naziv']."'";
								$rezultat2 = mysqli_query($konekcija, $upit2)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
								$br = mysqli_num_rows($rezultat2);
								$upit3 = "SELECT * FROM zakljucaj WHERE pitanje='".$niz['pitanje']."' AND anketa_test='".$_GET['naziv']."'";	
								$rezultat3 = mysqli_query($konekcija, $upit3)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
								$ukupno = mysqli_num_rows($rezultat3);
								$procenat = 100*$br/$ukupno;
								$sirina = 100*$br/$ukupno;
								echo "<br/>&nbsp;&nbsp;&nbsp;".$niz1['odgovor']." <img src='pink.jpg' style=\"height:10px;width:".$sirina."px;\">".$procenat."% ".$br;
							}
							$_SESSION['odgovor'] == "";
						}
					}
					echo "<br/>";
				}
			}
			else
				echo "<span style = 'font-weight: bold;'><br/>Anketa još uvek nije rađena od strane korisnika.</span>";
			?>
		</div>
	</body>
</html>