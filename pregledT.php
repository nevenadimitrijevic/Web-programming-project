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
			#test {
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
		<div id='test'>
		<form>
		<?php
		$upit = "SELECT * FROM testovi WHERE naziv='".$_GET["naziv"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		$niz = mysqli_fetch_array($rezultat);
		$nazivTesta = $niz["naziv"];
		echo "<h1>".$nazivTesta."</h1><br/><center><hr></center><br/>";
		$upit = "SELECT * FROM pitanja WHERE anketa_test='".$nazivTesta."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		$brojPitanja = 0;
		$i = 1;
		?>
		<table>
			<?php
			while ($niz = mysqli_fetch_array($rezultat)) {
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
					$upit2 = "SELECT * FROM odgovori WHERE idPitanja=".$niz['idPitanja']." AND anketa_test='".$nazivTesta."'";
					$rezultat2 = mysqli_query($konekcija, $upit2)
						or die("Greska u upitu: " .mysqli_errno($konekcija));
					while ($niz2 = mysqli_fetch_array($rezultat2)) {
					?>
						<tr>
							<td></td>
							<td>
								<input type = "<?php echo $tipOdg;?>" value = "<?php echo $niz2['odgovor'];?>"><span style = "color:green;"> &#10004; </span>
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
								<input type = "radio"> 
								<?php
								}
								else if ($niz["tip_odgovora"] == "4") {
								?>
									<input type = "checkbox">
								<?php
								}
								?>
								</td>
								<td><?php 
								echo $niz2["odgovor"]; 
								if ($niz2['tacno']==1)
									echo "<span style = \"color:green;\"> &#10004; </span>";
								else
									echo "<span style = \"color:red;\"> &#10060; </span>";
								?></td>
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