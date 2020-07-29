<?php
	define("SERVER_ADR", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "ankete_testovi");
	
	$konekcija = mysqli_connect(SERVER_ADR, DB_USER, DB_PASS);
	
	if (!$konekcija)
		die("Neuspesno konektovanje: " .mysqli_connect_error());
	
	mysqli_select_DB($konekcija, DB_NAME)
		or die("Neuspesna konekcija na bazu: " .mysqli_connect($konekcija));
?>