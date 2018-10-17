<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
require_once ("../../include/fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['voie'])) {
  $user=$_SESSION["idVisiteur"];
	$var = explode('.', $_POST['voie']);
	if ($var[0] =='' || $var[1] =='') {
		echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
	}
	else{
/**
                                              Bonne siaasie des heures
*/
    if ($var[1]>"2359" || $var[1]<"0000") {
           $var[1]="0000";
    }
    if ($var[2]>"2359" || $var[2]<"0000") {
      $var[2]="0000";
    }
    if ($var[3]>"2359" || $var[3]<"0000") {
      $var[3]="0000";
    }
   	if ($var[4]>"2359" || $var[4]<"0000") {
      $var[4]="0000";
    }
   	if ($var[5]>"2359" || $var[5]<"0000") {
      $var[5]="0000";
    }
   	if ($var[6]>"2359" || $var[6]<"0000") {
      $var[6]="0000";
    }
/**
                                                      Boonne saisie des heures
*/
    $b = hourIsCorruptVoie($var[1]);
    $c = hourIsCorruptVoie($var[2]);
    $d = hourIsCorruptVoie($var[3]);
    $e = hourIsCorruptVoie($var[4]);
    $f = hourIsCorruptVoie($var[5]);
    $g = hourIsCorruptVoie($var[6]);
    if ($b == true) {
      $var[1]="0000";
    }
    if ($c == true) {
      $var[2]="0000";
    }
    if ($d == true) {
      $var[3]="0000";
    }
    if ($e == true) {
      $var[4]="0000";
    }
    if ($f == true) {
      $var[5]="0000";
    }
    if ($g == true) {
      $var[6]="0000";
    }

        //Récupere toutes les voies
        $allVoie=explode(':',$var[0]);
        //Heure aitc debut
        $aitcD = $var[1].'00';
        //Heure aitc fin
        $aitcF = $var[2].'00';
        //Heure catenaire debut
        $cCD = $var[3].'00';
        //heure caténaire fin
        $cCF = $var[4].'00';
        //Heure debut travaux 
        $hD = $var[5].'00';
        //Heure fin travaux
        $hF = $var[6].'00';
        ///verifie si une fiche pointage a déja été crée a ce jour pour ce chanier
        $verifExistFicheFpointage = $pdo->verifFichePointage($_SESSION["date"],$_SESSION["idVisiteur"]);
        //Calcul la durée effective
        $dureeEffectiv = dureeEffective($aitcD,$aitcF,$cCD,$cCF);
        //Si il existe une fiche de pointage
        if (!empty($verifExistFicheFpointage)) {
          $getId = $pdo->getIdSemaine($_SESSION["date"]);
          $id = $getId["id"];
          for ($i=0; $i <count($allVoie) ; $i++) { 
            $add = $pdo->addConsigne($id,$_SESSION["chantier"],$_SESSION["date"],$_SESSION["idVisiteur"],addslashes($allVoie[$i]),$aitcD,$aitcF,$cCD,$cCF,$hD,$hF,$_SESSION["numba"]);
          }
          if ($add) {
          }
          else{
            echo "<div class='erreur'><center>Bien joué ! B)<center></center></div>";
            $lesConsigne = $pdo->getLesConsigneByDay($_SESSION["chantier"],$_SESSION["date"],$_SESSION["numba"]);
            if(!empty($lesConsigne)){?>
              <table>
                <caption><b>Les consignes d'aujourd'hui</b></caption>
              <tr>
                <th><center>NUMERO DE VOIE</center></th>      
                <th><center>COUPURE VOIE AITC DEBUT</center></th>
                <th><center>COUPURE VOIE AITC FIN</center></th>  
                <th><center>HEURE CONSIGNATION CATÉNAIRE(9007)</center></th>
                <th><center>HEURE CONSIGNATION CATÉNAIRE(9007) FIN</center></th>  
                <th><center>HEURE  DEBUT TRAVAUX</center></th>
                <th><center>HEURE FIN TRAVAUX</center></th>
                <th><center>DUREÉ EFFECTIVE</center></th>
                <th><center>ACTION</center></th>
              </tr> 
              <?php
              $i=0;
              foreach ($lesConsigne as $unConsigne) {
                $idConsigne = $unConsigne["idFiche"];
                $jourConsigne = $unConsigne["jour"];
                $voie = $unConsigne["num_voie"];
                $aitcDebut = $unConsigne["aitc1"];
                $aitcFin = $unConsigne["aitc2"];
                $cCD = $unConsigne["c_catenaire_debut"];
                $cCF = $unConsigne["c_catenaire_fin"];
                $travauxD = $unConsigne["debutTravaux"];
                $travauxF = $unConsigne["finTravaux"];?>
                <form action="#" method="POST">
                  <input type="hidden" id="jourConsigne<?php echo $i?>" value="<?php echo $jourConsigne?>">
                  <td><input type="text" id="voieConsigne<?php echo $i?>" name="voieConsigne" value="<?php echo $voie?>" size="6"></td>
                  <td><input type="text" id="aitc1<?php echo $i?>" value="<?php echo $aitcDebut?>" size="8"></td>
                  <td><input type="text" id="aitc2<?php echo $i?>" size="8" name="aitc2" value="<?php echo $aitcFin;?>" required/></td>
                  <td><input type="text" id="cCD<?php echo $i?>" size="8" name="cCD" value="<?php echo $cCD?>" required/></td>
                  <td><input type="text" id="cCF<?php echo $i?>" size="8" name="cCF" value="<?php echo $cCF?>" required/></td>
                  <td><input type="text" id="travauxD<?php echo $i?>" size="8" name="travauxD" value="<?php echo $travauxD?>" required/></td>
                  <td><input type="text" id="travauxF<?php echo $i?>" size="8" name="travauxF" value="<?php echo $travauxF?>" required/></td>
                  <td><input type="text" id="dureeEff<?php echo $i?>" size="4" name="dureeEff" value="<?php echo $dureeEffectiv?>" required/></td>
                  <td><input type="button"  class="button" name="modifier" value="modifier" alt="modifier <?php echo $voie?>" title="modifier <?php echo $voie?>" onclick="alterConsigne(<?php echo $i?>)"><a/><input type="button"  class="button" name="supprimer" value="supprimer" onclick="delConsigne(<?php echo $i?>);"></td>
                  </tr>
                </form>
              <?php $i++;
              }
            }
            else{
              echo "<div id='erreur'><center>Aucune consigne Ajouté</center></div>";
            }?>
              </table><br>
                <?php 
          }
        }//fin verif existe pointage
        else{
          echo "<div class='erreur'><center>Aucune fiche crée pour le chantier,pointer d'abord un salarié<center></center></div>";
        } 
    
	}
}
else{
	echo "<div class='erreur'><center>Erreur de saisie ,réessayez</center></div>";
}