<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu.inc.php");
session_start();
$poruka = "";
if (isset($_POST["izmeni"])) {
	header("Location: snimiT.php");
}
if (isset($_POST["predaj"])) {
	header("Location: predaj.php");
}
if (isset($_POST["potvrdi"])) {
	$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_SESSION["test"]."'";
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
		if ($niz["tip_odgovora"] == "3") {
			if (isset($_POST["pitanje".$niz['idPitanja']])) {
				//echo $_POST["pitanje".$niz['idPitanja']];
				$fleg = true;
				$_SESSION["odgovori"][$odgovor++] = $_POST["pitanje".$niz['idPitanja']];
				
			}
		}
		else if ($niz["tip_odgovora"] == "4") { 
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
					$_SESSION["odgovori"][$odgovor] = $answer;
					
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
	$_SESSION["poruka"] = $poruka;
	echo $poruka;
}
else {
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
			#popuni {
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
		<script type = "text/javascript"> 
			function timeout() {
				var minute = Math.floor(timeLeft/60);
				var second = timeLeft%60;
				var mint = checktime(minute);
				var sec = checktime(second);

				if (timeLeft<=0) {
					document.getElementById('forma').submit();
					window.open("predaj.php", "_self", false);
				}
				else {
					if (mint == 0 && sec == 29) {
						alert("Ostalo vam je jos 30 sekundi do kraja testiranja.");
					}
					document.getElementById("time").innerHTML = mint + ":" + sec;
				}
				timeLeft--;
				var tm = setTimeout("timeout()", 1000);
			}
			function checktime(msg) {
				if (msg<10) {
					msg = "0" + msg;
				}
				return msg;
			}
		</script>
	</head>
	<body onLoad = 'timeout();'>
		<div id = 'popuni'>
		<form method = "POST" id = "forma" action = "predaj.php">
		<?php
			if ($poruka == "") {
				$upit = "SELECT * FROM testovi WHERE idTesta=".$_GET["id"];
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$niz = mysqli_fetch_array($rezultat);
				$trajanje = $niz['trajanje_sek'];
				?>
				<input type = "hidden" id = "trajanje" value = "<?php echo $trajanje;?>">
				<script>
					var timeLeft = document.getElementById('trajanje').value;
				</script>
				<?php
				$nazivTesta = $niz["naziv"];
				$_SESSION["test"] = $nazivTesta;
				?>
				<h1><?php echo $nazivTesta;?>
				<div id = "time" style = "float:right">timeout</div></h1>
				<?php
				$upit = "SELECT * FROM pitanja WHERE anketa_test='".$nazivTesta."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$brojPitanja = 0;
				$i = 1;
				?>
				<table>
				<?php
				while ($niz = mysqli_fetch_array($rezultat)) {
					$upit3 = "SELECT * FROM snimi WHERE pitanje='".$niz["pitanje"]."' AND anketa_test='".$nazivTesta."' AND korisnik='".$_SESSION["username"]."'";
					$rezultat3 = mysqli_query($konekcija, $upit3)
						or die("Greska u upitu: " .mysqli_errno($rezultat3));
					if (mysqli_num_rows($rezultat3) == 1)
						$niz3 = mysqli_fetch_array($rezultat3);
					?>
					<tr>
						<td><?php echo $i++.".";?></td>
						<td><?php echo $niz["pitanje"]." [".$niz['broj_poena']."]";?></td>
					</tr>
					<?php
					$tipOdg = $niz["tip_odgovora"];
					if ($tipOdg == "1")
						$tip0dg = "number";
					else if ($tipOdg == "2")
						$tipOdg = "text";
					else if ($tipOdg == "3")
						$tipOdg = "radio";
					else if ($tipOdg == "4")
						$tipOdg = "checkbox";
					$br = $niz["broj_odgovora"];
					if ($niz["tip_odgovora"] == "1" || $niz["tip_odgovora"] == "2") {
						for ($x = 1; $x <= $br; $x++) {
							?>
							<tr>
								<td></td>
								<td>
									<input type = "<?php echo $tipOdg;?>" name = "odgovor<?php echo $x;?>pitanje<?php echo $niz["idPitanja"];?>"
									<?php if (mysqli_num_rows($rezultat3) == 1 && $niz3["odgovor"] != "nema odgovora") { 
									?>
										value = "<?php echo $niz3["odgovor"];?>"
									<?php
									}
									?>>
								</td>
							</tr>
							<?php
						}
					}
					else {
						$br = 1;
						$upit2 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$nazivTesta."'";
						$rezultat2 = mysqli_query($konekcija, $upit2)
							or die("Greska u upitu: " .mysqli_errno($konekcija));
						while ($niz2 = mysqli_fetch_array($rezultat2)) {
						?>
							<tr>
								<td>
									<?php
									if ($niz["tip_odgovora"] == "3") {
									?>
										<input type = "radio" name = "pitanje<?php echo $niz["idPitanja"];?>" value = "<?php echo $niz2["odgovor"];?>" 
										<?php
										if (mysqli_num_rows($rezultat3) == 1 && $niz3["odgovor"] == $niz2["odgovor"]) {
											echo "checked";
										}
										?>> 
										<?php
									}
									else if ($niz["tip_odgovora"] == "4") {
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
				</form>
				<?php
			}
			else {
				echo "<h1><center>".$_SESSION["test"]."</center></h1>";
				echo "<br/><center><span style=\"font-size: 30px;\">".$poruka."</span></center>";
				//for ($x = 0; $x < $brojPitanja; $x++) {
					//echo "<br/>Pitanje: ".$_SESSION["pitanja"][$x];
					//echo "<br/>Odgovor: " .$_SESSION["odgovori"][$x];
				//}
				?>
				<form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
				<br/><br/>
				<center>
				<input type = "submit" class = "btn" name = "izmeni" value = "Izmeni odgovore"> <input type = "submit" class = "btn" name = "predaj" value = "Predaj odgvore">
				</center>
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>
<?php
}
?>