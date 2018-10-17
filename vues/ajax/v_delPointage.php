<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['nom'])) {
	$var = explode('.', $_POST['nom']);
	$name = explode(' ', $var[0]);
	$prenom = $name[1];
	$nom = $name[0];
        $numba = $_SESSION["numba"];
	//recupere l'identifiant du personnel
	$getId = $pdo->getIdUser($nom,$prenom);
	$id = $getId["id"];
	$chantier = substr($var[1],0,5);
	$getIdChant = $pdo->getIdChantierByNum($chantier);
	if (strlen($var[1])>3) {
		$idChantier = $getIdChant["id"];
	}
	else{
		$idChantier = $var[1];
	}
	$date =substr($var[2],0,10) ;
	$del = $pdo->delPointageSal($date,$idChantier,$id,$numba);
	if ($del) {
	}else
	echo "<div class='erreur'><center>$prenom supprimé avec succès<center></center></div>";
}
else{
	echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
}?>