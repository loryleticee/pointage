<?php
require_once ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if(isset($_POST["id"])){
	$id = $_POST["id"];
	$delete=$pdo->supSal($id);
	if($delete){
		echo "SUppression erroné";
	}
	else{
		echo "<div class ='erreur'>Le salarié n°".$id." à bien été supprimé</div>"; 
		 
	}
}
else{
	echo "Probleme formulaire";
}
?>