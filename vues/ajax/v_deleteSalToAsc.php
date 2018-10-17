<?php
session_start();
require_once ("../../include/class.pdoansart.inc.php");
$pdo = PdoAnsart::getPdoAnsart();
if (isset($_POST['nomSal']) ) {
	$var = explode('.', $_POST['nomSal']);
	$nom = $var[0];
	$fiche = $var[1];
	$prenom = $var[2];
	$date = $var[3];
	$getId = $pdo->getIdUser($nom,$prenom);
	//var_dump($getId);
	$id = $getId["id"];
	$del = $pdo->supSalToAsc($fiche,$id,$date);
	echo "<div class='erreur'><center>$prenom supprimé avec succès<center></center></div>";
}
else{
	echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
}?>