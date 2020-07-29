<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu3.inc.php");
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
			table, th, td, tr {
				border: 2px black solid;
				border-collapse: collapse;
			}
			a {
				text-decoration: none;
				color: black;
			}
		</style>
	</head>
	<body>
		<div id = 'tabela'>
				<?php
				echo "<h1>&nbsp;".$_GET['naziv']."</h1>";
				$br = 0;
				$ukupno = 0;
				$br1 = $br2 = $br3 = $br4 = $br5 = $br6 = $br7 = $br8 = $br9 = $br10 = 0;
				$upit = "SELECT * FROM pitanja WHERE anketa_test='".$_GET['naziv']."'";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				while ($niz = mysqli_fetch_array($rezultat)) {
					$ukupno += $niz['broj_poena'];
				}
				$upit = "SELECT * FROM testovi_izvestaj WHERE test='".$_GET['naziv']."' ORDER BY poeni DESC";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$brIspitanika = mysqli_num_rows($rezultat);
				if (mysqli_num_rows($rezultat)>0) {
					?>
					<table width="800px" style = "margin-left:10px;">
					<tr>
						<th>Redni broj</th>
						<th>Ime</th>
						<th>Prezime</th>
						<th>Ostvareni poeni</th>
						<th>Ukupno</th>
					</tr>
					<?php
					while ($niz = mysqli_fetch_array($rezultat)) {
						?>
						<tr>
							<td><?php echo ++$br;?></td>
							<td><?php echo $niz['ime'];?></td>
							<td><?php echo $niz['prezime'];?></td>
							<td><?php echo $niz['poeni'];?></td>
							<td><?php echo $ukupno;?></td>
						</tr>
						<?php
						$poeni = $niz['poeni']*100/$ukupno;
						if ($poeni>=0 && $poeni<=10) 
							$br1 += 1;
						else if ($poeni>10 && $poeni<=20)
							$br2 += 1;
						else if ($poeni>20 && $poeni<=30)
							$br3 += 1;
						else if ($poeni>30 && $poeni<=40)
							$br4 += 1;
						else if ($poeni>40 && $poeni<=50)
							$br5 += 1;
						else if ($poeni>50 && $poeni<=60)
							$br6 += 1;
						else if ($poeni>60 && $poeni<=70)
							$br7 += 1;
						else if ($poeni>70 && $poeni<=80)
							$br8 += 1;
						else if ($poeni>80 && $poeni<=90)
							$br9 += 1;
						else if ($poeni>90 && $poeni<=100)
							$br10 += 1;
					}
					echo "</table>";
					?>
					<br/>
					<table width = "200px" style = "margin-left:10px;">
						<tr>
							<td>Poeni:</td>
							<td>Procenat studenata</td>
						</tr>
						<tr>
							<td>0-10%</td>
							<td><?php echo 100*$br1/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>10-20%</td>
							<td><?php echo 100*$br2/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>20-30%</td>
							<td><?php echo 100*$br3/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>30-40%</td>
							<td><?php echo 100*$br4/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>40-50%</td>
							<td><?php echo 100*$br5/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>50-60%</td>
							<td><?php echo 100*$br6/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>60-70%</td>
							<td><?php echo 100*$br7/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>70-80%</td>
							<td><?php echo 100*$br8/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>80-90%</td>
							<td><?php echo 100*$br9/$brIspitanika."%";?></td>
						</tr>
						<tr>
							<td>90-100%</td>
							<td><?php echo 100*$br10/$brIspitanika."%";?></td>
						</tr>
					</table>
		</div>
			<?php
				}
				else {
				?>
					<span style = 'font-weight: bold;'><br/>Test još uvek nije rađen od strane korisnika.</span>
				<?php
				}
				?>
	</body>
</html>