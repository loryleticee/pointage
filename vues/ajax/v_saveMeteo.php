<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['meteo'])) {
	///L'identifiant de la météo
	$meteo = $_POST['meteo'];
	///L'identifiant du chantier
	$idChantier = $_SESSION["chantier"];
	//L'identifiant de l'utilisateur connecté
	$idSal = $_SESSION["idVisiteur"];
	//Si c'est une validation tardive
	if (isset($_SESSION["lejour"])) {
		$_SESSION["date"] = $_SESSION["lejour"];
	}
	///Ajoute la meteo à la fiche de pointage
	$add = $pdo->addMeteo($idChantier,$meteo,$idSal,$_SESSION["date"]);
	//Si l'enregistrement ne passe pas
	if ($add) {
		//ne rien faire
	}
}
else{
	echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
}?>