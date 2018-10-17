<?php
session_start();
require_once ("../include/class.pdogsb.inc.php");
require_once("../include/fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['jour'])) {
    $debut = $_POST['jour'];
$jour=$_POST['jour'];
$heure=substr($jour,0,2);
$minute=substr($jour,2,2);
$date=$heure.":".$minute;
echo "<input type='text' value='$date'/>";
} 
?>