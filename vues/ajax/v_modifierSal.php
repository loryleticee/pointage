<?php session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if(isset($_POST["id"])){
	$var = explode('.', $_POST['id']);
	$id = $var[0];
	$nom = $var[1];
	$prenom = $var[2];
	$modifier = $pdo->alterSal($id,$nom,$prenom);
	//var_dump($modifier);
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