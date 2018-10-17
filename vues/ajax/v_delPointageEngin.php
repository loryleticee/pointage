<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['nom'])) {
	$var = explode('.', $_POST['nom']);
	//le nom du chantier
	$name = addslashes($var[0]);
	$num = $var[1];
	//le numero du chantier
	$nChantier = $var[3];
	//date du chantier
	$date = $var[2];
        $numba = $_SESSION["numba"];
	//Recupere l'identifiant du chantier
	$getIdChant = $pdo->getIdChantierByNum($nChantier);
	$idChantier = $getIdChant["id"];
	$getEngin = $pdo->getIdEngin($num,$name);
	$id = $getEngin["id"];
	$del = $pdo->delPointageEngin($date,$idChantier,$id,$name,$num,$numba);
	if ($del) {
	}else
	echo "<div class='erreur'><center>$name supprimé avec succès<center></center></div>";
}
else{
	echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
}?>