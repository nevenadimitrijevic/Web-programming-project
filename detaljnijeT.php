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
			#rezultat {
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
			hr {
				width: 80%;
			}
		</style>
	</head>
	<body>
		<div id = 'rezultat'>
			<?php
				echo "<h1>".$_GET['test']."</h1>";
				echo "<br/><center><hr>";
				$upit = "SELECT * FROM testovi_izvestaj WHERE ime='".$_SESSION['ime']."' AND prezime='".$_SESSION['prezime']."' AND test='".$_GET['test']."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die('Greska u upitu: '.mysqli_errno($konekcija));
				$niz = mysqli_fetch_array($rezultat);
				echo "<br/><span style=\"font-size: 20px;\">Ime i prezime: " .$_SESSION['ime']." ".$_SESSION['prezime'];
				echo "<br/><br/><span style=\"margin-left: -70px;\">Broj osvojenih poena: ".$niz['poeni']."</span></span></br>";
				echo "<br/><hr></center>";
				$upit = "SELECT * FROM zakljucaj where korisnik='".$_SESSION['username']."' AND anketa_test='".$_GET['test']."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die('Greska u upitu: ' .mysqli_errno($konekcija));
				$br = 0;
				while ($niz = mysqli_fetch_array($rezultat)) {
					echo "<br/>".++$br.". ".$niz['pitanje'];
					echo "<br/>&nbsp;&nbsp;&nbsp;&nbsp;".$niz['odgovor'];
					if ($niz['poeni'] == 0)
						echo "<span style = \"color:red;\"> &#10060; </span>";
					else
						echo "<span style = \"color:green;\"> &#10004; </span>";
					echo "<br/>";
				}
			?>
			<br/>
		</div>
	</body>
</html>
<?php
include_once("footer.inc.php");
?>