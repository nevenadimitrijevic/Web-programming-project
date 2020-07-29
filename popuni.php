<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu.inc.php");
session_start();
$poruka = "";
if (isset($_POST["snimi"])) {
	header("Location: snimi.php");
}
if (isset($_POST["zakljucaj"])) {
	header("Location: zakljucaj.php");
}
if (isset($_POST["potvrdi"])) {
	$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["anketa"]."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	$brojPitanja = mysqli_num_rows($rezultat);
	$odgovoreno = 0;
	$pitanje = 0;
	$odgovor = 0;
	while ($niz = mysqli_fetch_array($rezultat)) {
		$_SESSION["pitanja"][$pitanje++] = $niz["pitanje"];
		$_SESSION["odgovori"][$odgovor] = "";
		$fleg = false;
		if ($niz["tip_odgovora"] == "4") {
			if (isset($_POST["pitanje".$niz['idPitanja']])) {
				//echo $_POST["pitanje".$niz['idPitanja']];
				$fleg = true;
				$_SESSION["odgovori"][$odgovor++] = $_POST["pitanje".$niz['idPitanja']];
				
			}
		}
		else if ($niz["tip_odgovora"] == "5") { 
			for ($i=1; $i<=$niz["broj_odgovora"]; $i++) {
				if (isset($_POST["odgovor".$i."pitanje".$niz['idPitanja']])) {
					//echo $_POST["odgovor".$i."pitanje".$niz['idPitanja']];
					$answer = $_POST["odgovor".$i."pitanje".$niz['idPitanja']];
					$fleg = true;
					$_SESSION["odgovori"][$odgovor] = $_SESSION["odgovori"][$odgovor]." ".$answer;
				}
			}
			if ($fleg == false) {
				$_SESSION["odgovori"][$odgovor] = "nema odgovora";
			}
			$odgovor++;
		}
		else {
			for ($i=1; $i<=$niz["broj_odgovora"]; $i++) { //kad se potvrdi forma tekstualna polja su automatski setovana pa moram da proveravam sa !empty
				if (!empty($_POST["odgovor".$i."pitanje".$niz['idPitanja']])) {
					//echo $_POST["odgovor".$i."pitanje".$niz['idPitanja']];
					$answer = $_POST["odgovor".$i."pitanje".$niz['idPitanja']];
					$fleg = true;
					$_SESSION["odgovori"][$odgovor] = $_SESSION["odgovori"][$odgovor]." ".$answer;
					
				}
			}
			if ($fleg == false) {
				$_SESSION["odgovori"][$odgovor] = "nema odgovora";
			}
			$odgovor++;
		}
		if ($fleg == true) 
			$odgovoreno = $odgovoreno + 1;
	}
	$poruka = "Odgovorili ste na: " .$odgovoreno."/".$brojPitanja." pitanja";
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
			form {
				width: 30%;
				margin: 50px auto 100px;
				padding: 10px;
				border: 1px solid #B0C4DE;
				background: white;
				border-radius: 10px 10px 10px 10px;
			}
			.btn {
				padding: 10px;
				font-size: 15px;
				color: white;
				background: #5F9EA0;
				border: none;
				border-radius: 5px;
			}
		</style>
	</head>
	<body>
		<form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
			<?php
			
			if ($poruka == "") {
				$upit = "SELECT * FROM ankete WHERE idAnkete=".$_GET["id"];
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$niz = mysqli_fetch_array($rezultat);
				$nazivAnkete = $niz["naziv"];
				$_SESSION["anketa"] = $nazivAnkete;
				if ($niz["tip"] == "A") {
					echo "Postovani, ova anketa je anonimna.";
				}
				else if ($niz["tip"] == "P") {
					echo "<h1>".$nazivAnkete."</h1>";
					echo "<br/>Postovani, ova anketa je personalizovana.";
					echo "<br/>Ime i prezime: ".$_SESSION["osoba"];
					echo "<br/>Datum rodjenja:".$_SESSION["datumrodj"];
				}
				$upit = "SELECT * FROM pitanja WHERE anketa_test='".$nazivAnkete."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$brojPitanja = 0;
				$i = 1;
				?>
				<table>
				<?php
				while ($niz = mysqli_fetch_array($rezultat)) {
					$upit3 = "SELECT * FROM snimi WHERE pitanje='".$niz["pitanje"]."' AND anketa_test='".$nazivAnkete."' AND korisnik='".$_SESSION["username"]."'";
					$rezultat3 = mysqli_query($konekcija, $upit3)
						or die("Greska u upitu: " .mysqli_errno($rezultat3));
					if (mysqli_num_rows($rezultat3) == 1)
						$niz3 = mysqli_fetch_array($rezultat3);
					?>
					<tr>
						<td><?php echo $i++.".";?></td>
						<td><?php echo $niz["pitanje"];?></td>
					</tr>
					<?php
					$tipOdg = $niz["tip_odgovora"];
					if ($tipOdg == "1")
						$tip0dg = "number";
					else if ($tipOdg == "2")
						$tipOdg = "text";
					else if ($tipOdg == "3")
						$tipOdg = "textarea";
					else if ($tipOdg == "4")
						$tipOdg = "radio";
					else if ($tipOdg == "5")
						$tipOdg = "checkbox";
					$br = $niz["broj_odgovora"];
					if ($niz["tip_odgovora"] == "1" || $niz["tip_odgovora"] == "2" || $niz["tip_odgovora"] == "3") {
						for ($x = 1; $x <= $br; $x++) {
							?>
							<tr>
								<td></td>
								<td>
								<?php
								if ($niz["tip_odgovora"] == "3") {
									?>
									<textarea cols = "30" rows = "3" name = "odgovor<?php echo $x;?>pitanje<?php echo $niz["idPitanja"];?>" 
									<?php if (mysqli_num_rows($rezultat3) == 1 && $niz3["odgovor"] != "nema odgovora") { 
									?>
										value = "<?php echo $niz3["odgovor"];?>"
									<?php
									}
									?>></textarea>
								<?php
								}
								else {
								?>
									<input type = "<?php echo $tipOdg;?>" name = "odgovor<?php echo $x;?>pitanje<?php echo $niz["idPitanja"];?>"
									<?php if (mysqli_num_rows($rezultat3) == 1 && $niz3["odgovor"] != "nema odgovora") { 
									?>
										value = "<?php echo $niz3["odgovor"];?>"
									<?php
									}
									?>>
								<?php
								}
								?>
								</td>
							</tr>
							<?php
						}
					}
					else {
						$br = 1;
						$upit2 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$nazivAnkete."'";
						$rezultat2 = mysqli_query($konekcija, $upit2)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
						while ($niz2 = mysqli_fetch_array($rezultat2)) {
							?>
								<tr>
									<td>
										<?php
										if ($niz["tip_odgovora"] == "4") {
											?>
											<input type = "radio" name = "pitanje<?php echo $niz["idPitanja"];?>" value = "<?php echo $niz2["odgovor"];?>" 
											<?php
											if (mysqli_num_rows($rezultat3) == 1 && $niz3["odgovor"] == $niz2["odgovor"]) {
												echo "checked";
											}
											?>> 
											<?php
										}
										else if ($niz["tip_odgovora"] == "5") {
										?>
											<input type = "checkbox" name = "odgovor<?php echo $br++;?>pitanje<?php echo $niz["idPitanja"];?>" value = "<?php echo $niz2["odgovor"];?>" 
											<?php
											if (mysqli_num_rows($rezultat3) == 1 && strpos($niz3["odgovor"], $niz2["odgovor"]) !== false) {
												echo "checked";
											}
											?>>
										<?php
										}
										?>
									</td>
									<td><?php echo $niz2["odgovor"];?></td>
								</tr>
							<?php
						}
					}
					$brojPitanja++;
				}
			?>
			</table>
			<br/>
			<input type = "submit" class = "btn" name = "potvrdi" value = "POTVRDI">
			<?php
			}
			else {
				echo "<h1><center>".$_SESSION["anketa"]."</center></h1>";
				echo "<br/><center><span style=\"font-size: 30px;\">".$poruka."</span></center>";
				echo "<br/>Možete snimiti svoje odgovore i naknadno nastaviti popunjavanje ankete ili predati sada odgovore i zaključati anketu.";
				//for ($x = 0; $x < $brojPitanja; $x++) {
					//echo "<br/>Pitanje: ".$_SESSION["pitanja"][$x];
					//echo "<br/>Odgovor: " .$_SESSION["odgovori"][$x];
				//}
				?>
				<form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
				<br/><br/>
				<center>
				<input type = "submit" class = "btn" name = "snimi" value = "Snimi odgvore"> <input type = "submit" class = "btn" name = "zakljucaj" value = "Zakljucaj anketu">
				</center>
				</form>
				<?php
			}
			?>
		</form>
	</body>
</html>
<?php
include("footer.inc.php");
?>