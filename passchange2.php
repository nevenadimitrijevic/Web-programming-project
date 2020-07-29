<?php
include_once("DB.inc.php");
include_once("header.inc.php");
include_once("menu2.inc.php");
session_start();
$passErr = "";
if (isset($_POST['potvrdi'])) {
	$upit = "SELECT * FROM korisnik WHERE username='".$_SESSION['username']."' AND password = '".$_POST['stara']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die('Greska u upitu: ' .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat) == 1) {
	$upit = "UPDATE korisnik SET password='".$_POST['nova1']."' WHERE username='".$_SESSION['username']."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysli_errno($konekcija));
	if ($rezultat) 
		header("Location: odjava.php");
	}
	else
		$passErr = "Uneta lozinka nije validna.";
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
			#promena {
				width: 30%;
				margin: 30px auto 100px;
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
		<script>
			function provera() {
				var error = "";
				var nova = document.getElementById("nova1").value;
				var patt_pass = /^[A-Z](?=.*\d)(?=.*\W)[0-9a-zA-Z\W]{7,}$|^[a-z](?=.*[A-Z])(?=.*\d)(?=.*\W)[0-9a-zA-Z\W]{7,}$/;
				if (!nova.match(patt_pass)) {
					error += "\nLozinka mora imati minimalno 8 karaktera, od toga bar jedno veliko slovo, jedan broj i jedan specijalni karakter, i mora pocinjati slovom.";
					document.getElementById("nova1").value = "";
					document.getElementById("nova2").value = "";
				}
				
				var nova = document.getElementById("nova1").value;
				var potvrdi = document.getElementById("nova2").value;
				if (nova != potvrdi) {
					error += "\nLozinke se ne poklapaju.";
					document.getElementById("nova2").value = "";
				}
				
				if (error != "")
					alert(error);
			}
		</script>
	</head>
	<body>
		<div id = "promena">
			<h1>Promena lozinke</h1>
			<br/>
			<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
				<table>
					<tr>
						<td>Trenutna lozinka:</td>
						<td>
						<input type = "pass" id = "stara" name = "stara" value = "<?php if (isset($_POST['stara'])) echo $_POST['stara'];?>" required><br/><span><?php echo $passErr;?></span>
						</td>
					</tr>
					<tr>
						<td>Nova lozinka:</td>
						<td><input type = "pass" id = "nova1" name = "nova1" value = "<?php if (isset($_POST['nova1'])) echo $_POST['nova1'];?>" required></td>
					</tr>
					<tr>
						<td>Potvrda nove lozinke:</td>
						<td><input type = "pass" id = "nova2" name = "nova2" value = "<?php if (isset($_POST['nova2'])) echo $_POST['nova2'];?>" required></td>
					</tr>
					<tr>
						<td colspan = '2'>
						<button type = 'submit' class = "btn" name = 'potvrdi' onClick = "provera();">Potvrdi</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
<?php
include("footer.inc.php");
?>