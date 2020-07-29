<?php
require("header.inc.php");
include_once("DB.inc.php");
session_start();
if (!isset($_SESSION["username"])) 
	header("Location: index.php");
?>
<html>
	<head>
	</head>
	<body>
		<form>
			<?php
				$upit = "SELECT * FROM anketa1";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				$br = 0;
				while ($niz = mysqli_fetch_array($rezultat)) {
					echo ++$br.". ". $niz["pitanje"]."<br/>";
					?>
					<input type = "radio" name = "odgovor".<?php echo $niz["idPitanja"];?> <?php if (($_POST["odgovor".<?php echo $niz["idPitanja"];?>])?> ;?>><?php echo $niz["odgovor1"];?>
					<br/>
					<input type = "radio" name = "odgovor" <?php if isset($_POST["odgovor"]) echo "checked";?>><?php echo $niz["odgovor2"];?>
					<br/>
					<input type = "radio" name = "odgovor" <?php if isset($_POST["odgovor"]) echo "checked";?>><?php echo $niz["odgovor3"];?>
					<br/>
				<?php
				}
				?>
				<br/>
				<input type = "submit" name = "predaj" value = "Kraj">
		</form>
	</body>
</html>