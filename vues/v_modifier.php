<?php
require_once ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if(isset($_POST["id"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["login"]) && isset($_POST["mdp"]) && isset($_POST["tel"]) && isset($_POST["adresse"]) && isset($_POST["mail"]) && isset($_POST["txHoraire"])){
	$id = $_POST["id"];
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$login = $_POST["login"];
	$mdp = $_POST["mdp"];
	$tel = $_POST["tel"];
	$adresse = $_POST["adresse"];
	$mail = $_POST["mail"];
	$tauxHoraire = $_POST["txHoraire"];
	$modifier = $pdo->alterSal($id,$nom,$prenom,$tel,$adresse,$mail,$tauxHoraire);
	var_dump($modifier);
	if($modifier){
		echo "ModificatiON erroné";
	}
	else{
		echo "Modificatino reussie";
	}
}
else{
	echo"Pas de post";
}
?>
