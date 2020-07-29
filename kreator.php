<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu3.inc.php");
session_start();
?>
<html>
	<head>
		<link type = 'text/css' rel = 'stylesheet' href = 'ispitanik.css'>
	</head>
	<body>
		<!-- ANKETE -->
		<br/><br/>
		<h1 style = "margin-left: 10px;">ANKETE:</h1>
		<br/>
		<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
		<select name = "sortiranjeA" id = "sortiranjeA">
			<option value = "1" <?php if ((isset($_POST["sortirajA"]) && $_POST["sortiranjeA"] == "1") || !isset($_POST["sortirajA"])) echo "selected;"?>>Po nazivu ↑</option>
			<option value = "2"  <?php if (isset($_POST["sortirajA"]) && $_POST["sortiranjeA"] == "2") echo "selected"?>>Po nazivu ↓</option>
			<option value = "3" <?php if (isset($_POST["sortirajA"]) && $_POST["sortiranjeA"] == "3") echo "selected"?>>Po datumu početka ↑</option>
			<option value = "4" <?php if (isset($_POST["sortirajA"]) && $_POST["sortiranjeA"] == "4") echo "selected"?>>Po datumu početka ↓</option>
			<option value = "5" <?php if (isset($_POST["sortirajA"]) && $_POST["sortiranjeA"] == "5") echo "selected"?>>Po datumu kraja ↑</option>
			<option value = "6" <?php if (isset($_POST["sortirajA"]) && $_POST["sortiranjeA"] == "6") echo "selected"?>>Po datumu kraja ↓</option>
		</select>
		<input type = "submit" class = "btn" name = "sortirajA" value = "Sortiraj">
		<br/><br/>
		<div class = "ankete">
			<table style = "margin-left: 10px;">
				<tr>
					<th>Naziv</th>
					<th>Datum pocetka</th>
					<th>Datum kraja</th>
					<th>Tip</th>
					<th>Rezultat</th>
				</tr>
				<?php
				if (isset($_POST["sortirajA"])) {
					if ($_POST["sortiranjeA"] == "1") {
						$upit1 = "SELECT * FROM ankete ORDER BY naziv ASC";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
					else if ($_POST["sortiranjeA"] == "2") {
						$upit1 = "SELECT * FROM ankete ORDER BY naziv DESC";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
					else if ($_POST["sortiranjeA"] == "3") {
						$upit1 = "SELECT * FROM ankete ORDER BY pocetak ASC";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
					else if ($_POST["sortiranjeA"] == "4") {
						$upit1 = "SELECT * FROM ankete ORDER BY pocetak DESC";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
					else if ($_POST["sortiranjeA"] == "5") {
						$upit1 = "SELECT * FROM ankete ORDER BY kraj ASC";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
					else if ($_POST["sortiranjeA"] == "6") {
						$upit1 = "SELECT * FROM ankete ORDER BY kraj DESC";
						$rezultat1 = mysqli_query($konekcija, $upit1)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
					}
				}
				else {
					$upit1 = "SELECT * FROM ankete ORDER BY naziv ASC";
					$rezultat1 = mysqli_query($konekcija, $upit1)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
				if (mysqli_num_rows($rezultat1) > 0) {
					while ($niz1 = mysqli_fetch_array($rezultat1)) {
					?>
						<tr>
							<td><?php echo $niz1["naziv"];?></td>
							<td><?php echo $niz1["pocetak"];?></td>
							<td><?php echo $niz1["kraj"];?></td>
							<td>
								<?php
								if ($niz1["tip"] == "A")
									echo "Anonimna";
								else if ($niz1["tip"] == "P")
									echo "Personalizovana";
								?>
							</td>
							<td>
								<?php
								$upit = "SELECT * FROM zakljucaj WHERE korisnik='".$_SESSION["username"]."' AND anketa_test='".$niz1['naziv']."'";
								$rezultat = mysqli_query($konekcija, $upit)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
								if (mysqli_num_rows($rezultat) != 0) {
									echo "<center>Anketa je vec popunjena.</center>";
									?>
									<center><a href = 'detaljnijeA.php?anketa=<?php echo $niz1['naziv'];?>'>Detaljnije</a></center>
									<?php
								}
								else {
								$danas = strtotime(date('Y-m-d H:i:s'));
								if ($danas>=strtotime($niz1["pocetak"]) && $danas<=strtotime($niz1["kraj"])) {
								?>
								<center>
								<a href = "popuniAnketu.php?id=<?php echo $niz1["idAnkete"];?>">Popuni</a>
								</center>
								<?php
								}
								else
									echo "Interval trajanja ankete nije u toku.";
								}
								?>
							</td>
						</tr>
					<?php
					}
				}
				else {
					echo "&nbsp;&nbsp;Trenutno nema dostupnih anketa.";
				}
				?>
			</table>
		</div>
		
		<!-- TESTOVI -->
		<br/><br/>
		<h1 style = "margin-left: 10px;">TESTOVI:</h1>
		<br/>
		<select id = "sortiranjeT" name = "sortiranjeT">
			<option value = "1" <?php if ((isset($_POST["sortirajT"]) && $_POST["sortiranjeT"] == "1") || !isset($_POST["sortirajT"])) echo "selected;"?>>Po nazivu ↑</option>
			<option value = "2"  <?php if (isset($_POST["sortirajT"]) && $_POST["sortiranjeT"] == "2") echo "selected"?>>Po nazivu ↓</option>
			<option value = "3" <?php if (isset($_POST["sortirajT"]) && $_POST["sortiranjeT"] == "3") echo "selected"?>>Po datumu početka ↑</option>
			<option value = "4" <?php if (isset($_POST["sortirajT"]) && $_POST["sortiranjeT"] == "4") echo "selected"?>>Po datumu početka ↓</option>
			<option value = "5" <?php if (isset($_POST["sortirajT"]) && $_POST["sortiranjeT"] == "5") echo "selected"?>>Po datumu kraja ↑</option>
			<option value = "6" <?php if (isset($_POST["sortirajT"]) && $_POST["sortiranjeT"] == "6") echo "selected"?>>Po datumu kraja ↓</option>
		</select>
		<input type = "submit" class = "btn" name = "sortirajT" value = "Sortiraj">
		<br/><br/>
		<div class = "testovi">
			<table style = "margin-left: 10px;">
				<tr>
					<th>Naziv</th>
					<th>Datum pocetka</th>
					<th>Datum kraja</th>
					<th>Preostalo vreme za testiranje</th>
					<th>Rezultat</th>
				</tr>
				<?php
				if (isset($_POST["sortirajT"])) {
				if ($_POST["sortiranjeT"] == "1") {
					$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY naziv ASC";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
				else if ($_POST["sortiranjeT"] == "2") {
					$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY naziv DESC";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
				else if ($_POST["sortiranjeT"] == "3") {
					$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY pocetak ASC";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
				else if ($_POST["sortiranjeT"] == "4") {
					$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY pocetak DESC";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
				else if ($_POST["sortiranjeT"] == "5") {
					$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY kraj ASC";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
				else if ($_POST["sortiranjeT"] == "6") {
					$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY kraj DESC";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
				}
			}
			else {
				$upit2 = "SELECT * FROM testovi WHERE kreator!='".$_SESSION['username']."' ORDER BY naziv ASC";
				$rezultat2 = mysqli_query($konekcija, $upit2)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
			}
				if (mysqli_num_rows($rezultat2) > 0) {
					while ($niz2 = mysqli_fetch_array($rezultat2)) {
					?>
						<tr>
							<td><?php echo $niz2["naziv"];?></td>
							<td><?php echo $niz2["pocetak"];?></td>
							<td><?php echo $niz2["kraj"];?></td>
							<td><?php echo $niz2["trajanje_sek"];?></td>
							<td>
								<?php
								$upit = "SELECT * FROM testovi_izvestaj WHERE test='".$niz2['naziv']."' AND ime='".$_SESSION['ime']."' AND prezime='".$_SESSION['prezime']."'";
								$rezultat = mysqli_query($konekcija, $upit)
									or die("Greska u upitu: " .mysqli_errno($konekcija));
								if (mysqli_num_rows($rezultat) != 0) {
									echo "<br/><center>Test je popunjen.</center>";
									?>
									<br/>
									<center><a href = 'detaljnijeT.php?test=<?php echo $niz2['naziv'];?>'>Detaljnije</a></center>
									<?php
								}
								else {
								$danas = strtotime(date('Y-m-d H:i:s'));
								if ($danas>=strtotime($niz2["pocetak"]) && $danas<=strtotime($niz2["kraj"])) {
								?>
									<center><a href = "popuniTest.php?id=<?php echo $niz2["idTesta"];?>">Popuni</a></center>
								<?php
								}
								else
									echo "Interval trajanja testa nije u toku.";
								}
								?>
							</td>
						</tr>
					<?php
					}
				}
				else {
					echo "&nbsp;&nbsp;Trenutno nema dostupnih testova.";
				}
				?>
			</table>
		</div>
		</form>
		<br/><br/>
		<div class = 'ankete'>
			<h1 style = "margin-left: 10px;">ANKETE KOJE STE KREIRALI:</h1>
			<br/>
			<table style = "margin-left: 10px;">
				<tr>
					<th>Naziv</th>
					<th>Datum pocetka</th>
					<th>Datum kraja</th>
					<th>Tip</th>
					<th>Pregled</th>
					<th>Popunjeno</th>
					<th>Rezultat</th>
					<th>Brisanje</th>
				<tr/>
				<?php
				$upit = "SELECT * FROM ankete WHERE kreator='".$_SESSION['username']."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				if (mysqli_num_rows($rezultat)>0) {
					while ($niz = mysqli_fetch_array($rezultat)) {
					?>
						<tr>
							<td><?php echo $niz["naziv"];?></td>
							<td><?php echo $niz["pocetak"];?></td>
							<td><?php echo $niz["kraj"];?></td>
							<td>
								<?php
								if ($niz["tip"] == "A")
									echo "Anonimna";
								else if ($niz["tip"] == "P")
									echo "Personalizovana";
								?>
							</td>
							<td>
								<a href = "pregledA.php?naziv=<?php echo $niz['naziv'];?>">Pregled ankete</a>
							</td>
							<td>
								<a href = "popunjenoA.php?naziv=<?php echo $niz['naziv'];?>">Vidi</a>
							</td>
							<td>
								<a href = "izvestajA.php?naziv=<?php echo $niz['naziv'];?>">Izvestaj</a>
							</td>
							<td>
								<a href = 'obrisi.php?anketa=<?php echo $niz['naziv'];?>'>Obrisi anketu</a>
							</td>
						</tr>
					<?php
					}
				}
				else {
					echo "&nbsp;&nbsp;Jos uvek niste kreirali nijednu anketu.";
				}	
				?>
			</table>
		</div>
		<br/><br/>
		<div class = 'testovi'>
			<h1 style = "margin-left: 10px;">TESTOVI KOJE STE KREIRALI:</h1>
			<br/>
			<table style = "margin-left: 10px;">
				<tr>
					<th>Naziv</th>
					<th>Datum pocetka</th>
					<th>Datum kraja</th>
					<th>Trajanje</th>
					<th>Pregled</th>
					<th>Rezultat</th>
					<th>Brisanje</th>
				<tr/>
				<?php
				$upit = "SELECT * FROM testovi WHERE kreator='".$_SESSION['username']."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				if (mysqli_num_rows($rezultat)>0) {
					while ($niz = mysqli_fetch_array($rezultat)) {
					?>
						<tr>
							<td><?php echo $niz["naziv"];?></td>
							<td><?php echo $niz["pocetak"];?></td>
							<td><?php echo $niz["kraj"];?></td>
							<td><?php echo $niz["trajanje_sek"];?></td>
							<td>
								<a href = "pregledT.php?naziv=<?php echo $niz['naziv'];?>">Pregled testa</a>
							</td>
							<td>
								<a href = "rezultatT.php?naziv=<?php echo $niz['naziv'];?>">Izvestaj</a>
							</td>
							<td>
								<a href = 'obrisi.php?test=<?php echo $niz['naziv'];?>'>Obrisi test</a>
							</td>
						</tr>
					<?php
					}
				}
				else {
					echo "&nbsp;&nbsp;Jos uvek niste kreirali nijedan test.";
				}	
				?>
			</table>
		</div>
		<br/><br/>
		&nbsp;&nbsp;<a href = "anketa.php"><span style = "font-size: 20px;">Napravi anketu</span></a>
		<br/>
		&nbsp;&nbsp;<a href = "test.php"><span style = "font-size: 20px;">Napravi test</span></a>
		<br/><br/>
	</body>
</html>
<?php
include('footer.inc.php');
?>