<?php
require("header.inc.php");
require("menu.inc.php");
include_once("DB.inc.php");
session_start();
$username = $password = "";
$userErr = $passErr = "";
if (isset($_POST["login"])) {
	if (isset($_POST["user"])) {
		$upit = "SELECT * FROM korisnik WHERE username='".$_POST["user"]."' AND registrovan=1";
		$rezultat = mysqli_query($konekcija, $upit)
			or die("Greska u upitu: " .mysqli_errno($konekcija));
		if (mysqli_num_rows($rezultat) == 1) {
			$username = $_POST["user"];
			if (isset($_POST["pass"])) {
				$upit = "SELECT * FROM korisnik WHERE username='".$username."' AND password='".$_POST["pass"]."' AND registrovan=1";
				$rezultat = mysqli_query($konekcija, $upit)
					or die("Greska u upitu: " .mysqli_errno($konekcija));
				if (mysqli_num_rows($rezultat) == 1) {
					$password = $_POST["pass"];
					$_SESSION["username"] = $username;
					$niz = mysqli_fetch_array($rezultat);
					$_SESSION["ime"] = $niz['ime'];
					$_SESSION['prezime'] = $niz['prezime'];
					$_SESSION["osoba"] = $niz["ime"]." ".$niz["prezime"];
					$_SESSION["datumrodj"] = $niz["datumrodj"];
					if ($niz["tip"] == "I")
						header("Location: ispitanik.php");
					else if ($niz["tip"] == "K")
						header("Location: kreator.php");
					else
						header("Location: admin.php");
				}
				else
					$passErr = "Pogresna lozinka!";
			}
			else
				$passErr = "Pogresna lozinka!";
		}
		else {
			$userErr = "Pogresno korisnicko ime!";
			$passErr = "Pogresna lozinka!";
		}
	}
	else {
		$userErr = "Pogresno korisnicko ime!";
		$passErr = "Pogresna lozinka!";
	}
}
?>
<html>
	<head>
		<title>Login</title>
		<link type = "text/css" rel = "stylesheet" href = "styles.css">
	</head>
	<body>
		<div class = "header_form">
			<h2>Login</h2>
		</div>
		
		<form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"];?>">
			<div class = "podaci">
				<label>Korisnicko ime:</label> 
				<input type = "text" name = "user" value = "<?php echo $username;?>" required><span><?php echo $userErr;?></span>
			</div>
			<div class = "podaci">
				<label>Lozinka:</label> 
				<input type = "password" name = "pass" required><span><?php echo $passErr;?></span>
			</div>
			<div class = "podaci">
				<button type = "submit" name = "login" class = "btn">Log in</button>
			</div>
			<p>
				Nemate korisnicki nalog? <a href = "register.php">Registrujte se</a>
			</p>
		</form>
	</body>
</html>
<?php
include_once("footer.inc.php");
?>
