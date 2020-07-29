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
			#anketa {
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
		<div id = "anketa">
		<form>
		<?php
			$upit = "SELECT * FROM ankete WHERE naziv='".$_GET["naziv"]."'";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			$niz = mysqli_fetch_array($rezultat);
			$nazivAnkete = $niz["naziv"];
			if ($niz["tip"] == "A") {
				echo "<h1>".$nazivAnkete."</h1>";
				echo "<br/>Ova anketa je anonimna.<br/><br/>";
				echo "<center><hr></center><br/>";
			}
			else if ($niz["tip"] == "P") {
				echo "<h1>".$nazivAnkete."</h1>";
				echo "<br/>Ova anketa je personalizovana.<br/><br/>";
				echo "<center><hr></center>";
			}
			$upit = "SELECT * FROM pitanja WHERE anketa_test='".$nazivAnkete."'";
			$rezultat = mysqli_query($konekcija, $upit)
				or die("Greska u upitu: " .mysqli_errno($konekcija));
			$i = 1;
			?>
			<table>
			<?php
			while ($niz = mysqli_fetch_array($rezultat)) { //prolazimo kroz sva pitanja iz ankete
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
								<textarea cols = "30" rows = "3"></textarea>
							<?php
							}
							else {
							?>
								<input type = "<?php echo $tipOdg;?>">
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
								<input type = "radio"> 
								<?php
								}
								else if ($niz["tip_odgovora"] == "5") {
								?>
								<input type = "checkbox">
								<?php
								}
								?>
							</td>
							<td><?php echo $niz2["odgovor"];?></td>
						</tr>
							<?php
					}
				}
			}
			?>
			</table>
		</form>
		</div>
	</body>
</html>
<?php
include_once("footer.inc.php");
?>