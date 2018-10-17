<?php session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if(isset($_POST["pointage"])){
	$var = explode('.', $_POST['pointage']);
	$name = explode(' ',$var[0]);
	$nom = $name[0];
	$prenom = $name[1];
	$getIdSal = $pdo->getIdUser($nom,$prenom);
	$idSal = $getIdSal["id"];
	$date = substr($var[1],0,10);
	$debutD = $var[1];
	$finD = $var[2];
	$debutF = $var[3];
	$finF = $var[4];
	$modifier = $pdo->alterPointage($idSal,$date,$_SESSION["idVisiteur"],$_SESSION["chantier"],$debutD,$finD,$debutF,$finF); 
	if(!$modifier){
		echo "<div class='erreur'><center>$prenom modifié avec succès</center></div>";
	}
	else{
		echo "<div class='erreur'><center>Contactez votre webmaster</center></div>";
	}
}
else{
	echo"Pas de post";
}
?>