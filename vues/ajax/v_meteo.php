<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
/**
 * @name $getPdoAnsart connection
 */
$pdo = PdoGsb::getPdoGsb();
/**Si la signature a été posté
 * Sinon Affiche un message d'erreur
 * @$_POST['visa'] string Signature echapé du caractère "+"
 * @sansPlus array Tableau associatif des caractères avant et après les "+"
 * @avecPlus string Signature avec le caractère "+" 
 */
if (isset($_POST['meteo'])) {
	$_SESSION["meteo"] = $_POST['meteo'];
}