<?php
include_once("DB.inc.php");
session_start();
$_SESSION['username'] = "";
$_SESSION['ime'] = "";
$_SESSION['prezime'] = "";
$_SESSION['datumrodj'] = "";
$_SESSION['osoba'] = "";
session_destroy();
header("Location: index.php");
?>