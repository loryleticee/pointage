<?php 
session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoAnsart::getPdoAnsart();
if (isset($_POST["theme"]) && $_POST["theme"]!='' && $_POST["theme"]!="Nouveau theme ...") {
	//var_dump($_POST);
	$them=addslashes($_POST["theme"]);
	$themes=firstLetta($them);
	//var_dump($f);
	$leTheme=$pdo->getLastTheme();
	//var_dump($leTheme);
	$id=$leTheme["id"]+1;
	$add=$pdo->addTheme($id,$themes);
	//var_dump($add);
	echo "<div class='erreur'><center>Le nouveau themes `$themes` à été ajouté</center></div>";

}else{
	echo "<div class='erreur'><center>Renseignez le nouveau theme</center></div>";
}
?>