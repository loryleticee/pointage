<?php session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if(isset($_POST["message"])){
	$lesTAR = explode(':', $_POST['message']);
	$taillelesTAR=count($lesTAR);
	$id =$_SESSION["chantier"];
	if ($_POST["message"]!='') {
		//Pour chaque message
		for ($i=0; $i <$taillelesTAR ; $i++) { 
			//Recupere le message
			$msg=$lesTAR[$i];
			//Ajoute le message au chantier
			$add = $pdo->addTAR($id,$msg,$_SESSION["date"]); 
		}
		if(!$add){
			echo "<div class='erreur'><center> Travaux ajouté(s) avec succès</center></div>";
		}
		else{
			echo "<div class='erreur'><center>Contactez votre webmaster</center></div>";
		}
	}
}
else{
	echo "<div class='erreur'><center>Contactez votre webmaster</center></div>";
}
?>