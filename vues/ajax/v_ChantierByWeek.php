<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
require_once ("../../include/fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST["idChant"]) && $_POST["idChant"]!=0) {
	$_SESSION["chantier"] = $_POST["idChant"];
	$Years = $pdo->getYears($_POST["idChant"]);
	if (!empty($Years)) {?>
		     		<center> <h2>Sélectionner une année</h2></center><center>
 			<label for="listYears" accesskey="n">Année : </label>
			<select id="listYears" name="listYears">
				<option value="0"  selected>Selectionner une année</option>
<?php
				foreach ($Years as $aYear) {
					$date = $aYear["jour"];
					$year = substr($date, 0,4);
					if (!isset($_SESSION["annee"])) {
						$_SESSION["annee"]=$year;					
						echo "<option value='$year'>$year</option>";
					}else{
						if ($year!=$_SESSION["annee"]) {
							echo "<option value='$ans'>$ans</option>";
						}
					}
				}?>
			</select>
<?php	$lesWeek = $pdo->getLesWeek($_POST["idChant"]);?>
<?php 	if (!empty($lesWeek)) {?>
     		<center> <h2>Sélectionner une semaine</h2></center><center>
 			<label for="listWeek" accesskey="n">Semaine : </label>
			<select id="listWeek" name="listWeek" onchange="voirPointageWeek();">
				<option value="0"  selected>Selectionner une semaine</option>
<?php
				foreach ($lesWeek as $unWeek) {
					$idWeek = $unWeek["id"];
					//var_dump($annee);
					echo "<option value='$idWeek'>$idWeek</option>";
				}?>
			</select>
			<?php $lesJours = $pdo->getLesJour($idWeek,$_SESSION["chantier"])?>
			<center><h2>Sélectionner un jour</h2></center>
 			<label for="listjour" accesskey="n">Jour : </label> 
 				<select id="listjour" name="listjour" onchange="voirPointageDay();"> 
 					<option value="0"  selected>Selectionner un jour</option>
<?php					foreach ($lesJours as $unJour) {
						$idJour= $unJour["jour"];?>
						<option value="<?php echo $idJour?>"><?php echo $idJour?></option>
<?php 				}?>
 				</select>
			</center>

<?php 	}?>		 
			<div id="lstPointage"></div>
<?php
 	}else{
			echo "<div class='erreur'><center>Aucune fiche pointages pour ce chantier<center></div>";
		}
}
else{
		echo "<div class='erreur'><center>Aucun chantier Sélectionné<center></div>";
}?>
