<?php
require("header.inc.php");
require("menu.inc.php");
include_once("DB.inc.php");
session_start();
$username = $robot = "";
$userErr = $emailErr = "";
$poruka = "";
if (isset($_POST['signup'])) {
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$secretKey = "6Le_Wc8UAAAAAC-PZw13h9zVi4W3icziN3LjwoiD";
	$responseKey = $_POST['g-recaptcha-response'];
	$userIP = $_SERVER['REMOTE_ADDR'];
	
	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
	$response = file_get_contents($url);
	$data = json_decode($response);
	if (isset($data->success) AND $data->success!=true) {
		$robot = "Captcha verifikacija nije uspela, pokušajte ponovo!";
	}
	else {
	$upit = "SELECT * FROM korisnik WHERE username='".$_POST["user"]."'";
	$rezultat = mysqli_query($konekcija, $upit)
		or die("Greska u upitu: " .mysqli_errno($konekcija));
	if (mysqli_num_rows($rezultat) == 0) {
		$username = $_POST['user'];
		$_SESSION["username"] = $username;
		$upit = "SELECT * FROM korisnik WHERE eposta='".$_POST["email"]."'";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) < 2) {
			$email = $_POST["email"];
			$upit = "INSERT INTO korisnik(username, password, ime, prezime, datumrodj, mestorodj, jmbg, kontakt, eposta, tip, registrovan) 
			VALUES('".$_POST["user"]."', '".$_POST['lozinka1']."', '".$_POST['ime']."', '".$_POST['prezime']."', '".$_POST['datum']."', '".$_POST['mesto']."', 
			'".$_POST['jmbg']."', ".$_POST['telefon'].", '".$_POST["email"]."', 'I', 0)";
			$rezultat = mysqli_query($konekcija, $upit);
			if ($rezultat)
				$poruka = "Zahtev za registraciju je uspešno kreiran.";
			else
				$poruka = "Došlo je do greške, pokušajte ponovo.";
		}
		else 
			$emailErr = "Nalozi sa ovom email adresom već postoje!";
	}
	else 
		$userErr = "Nalog sa ovim korisničkim imenom već postoji!";
	}	
}
?>
<html>
	<head>
		<title>Signup</title>
		<link type = "text/css" rel = "stylesheet" href = "styles.css">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script src = "funkcije.js"></script>
	</head>
	<body>
		<div class = "header_form">
			<h2>Signup</h2>
		</div>	
		<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
		<?php
			if (!$poruka) {
		?>
				<div class = "podaci">
					<label>Ime:</label> 
					<input type = "text" name = "ime" value = "<?php if (isset($_POST["ime"]) && !empty($_POST["ime"])) echo $_POST["ime"];?>" required>
				</div>
				<div class = "podaci">
					<label>Prezime:</label> 
					<input type = "text" name = "prezime" value = "<?php if (isset($_POST["prezime"]) && !empty($_POST["prezime"])) echo $_POST["prezime"];?>" required>
				</div>
				<div class = "podaci">
					<label>Korisnicko ime:</label> 
					<input type = "text" name = "user" value = "<?php echo $username;?>" required>
					<span><?php echo $userErr;?></span>
				</div>
				<div class = "podaci">
					<label>Lozinka:</label> 
					<input type = "password" name = "lozinka1" value = "<?php if (isset($_POST["lozinka1"]) && !empty($_POST["lozinka1"])) echo $_POST["lozinka1"];?>" id = "lozinka1" required> 
				</div>
				<div class = "podaci">
					<label>Potvrdi lozinku:</label> 
					<input type = "password" name = "lozinka2" value = "<?php if (isset($_POST["lozinka2"]) && !empty($_POST["lozinka2"])) echo $_POST["lozinka2"];?>" id = "lozinka2" required>
				</div>
				<div class = "podaci">
					<label>Datum rođenja:</label> 
					<input type = "date" name = "datum" id = "datum" value = "<?php if (isset($_POST["datum"]) && !empty($_POST["datum"])) echo $_POST["datum"];?>" required>
				</div>
				<div class = "podaci">
					<label>Mesto rođenja:</label> 
					<input type = "text" name = "mesto" value = "<?php if (isset($_POST["mesto"]) && !empty($_POST["mesto"])) echo $_POST["mesto"];?>" required>
				</div>
				<div class = "podaci">
					<label>JMBG:</label> 
					<input type = "text" name = "jmbg" id = "jmbg" value = "<?php if (isset($_POST["jmbg"]) && !empty($_POST["jmbg"])) echo $_POST["jmbg"];?>" required>
				</div>
				<div class = "podaci">
					<label>Kontakt telefon:</label> 
					<input type = "text" name = "telefon" value = "<?php if (isset($_POST["telefon"]) && !empty($_POST["telefon"])) echo $_POST["telefon"];?>" required>
				</div>
				<div class = "podaci">
					<label>Email adresa:</label> 
					<input type = "text" name = "email" value = "<?php if (isset($_POST["email"]) && !empty($_POST["email"])) echo $_POST["email"];?>" required>
					<span><?php echo $emailErr;?></span>
				</div>
				<div class = "podaci">
				<div class="g-recaptcha" data-sitekey="6Le_Wc8UAAAAAAukCeB2of5Ce3EhL9ZO_EashXOL"></div>
				</div>
				<div class = "podaci">
					<?php echo $robot;?>
				</div>
				<div class = "podaci">
					<button type = "submit" name = "signup" class = "btn" onClick = "provera();">Sign up</button>
				</div>
				<p>
					Već imate korisnicki nalog? <a href = "index.php">Ulogujte se</a>
				</p>
			<?php
			}
			else 
				echo $poruka;
			?>
		</form>
	</body>
</html>
<?php
include_once("footer.inc.php");
?>