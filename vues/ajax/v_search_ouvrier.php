<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
require_once("../../include/fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
$liste = $pdo->getOuvrier();
$chantier=$_SESSION['chantier'];
if (isset($_POST['letta'])) {
    $debut = $_POST['letta'];
} 
else {
    $debut = "";
}
$debut = strtoupper($debut);
?><!--<select>--><?php
function generateOptions($debut,$liste) {
    foreach ($liste as $element) {
        $id = $element['id'];
        $nom = $element['nom'];
        $prenom = $element['prenom'];
        if (substr($nom, 0, strlen($debut)) == $debut) {
             $_SESSION["ouvrier"]=$nom.' '.$prenom;
             $_SESSION["nomOuvrier"]=$nom;
             $_SESSION["prenomOuvrier"]=$prenom;
        }
        elseif(substr($nom, 0, 1).substr($prenom,0,1) == $debut) {
             $_SESSION["ouvrier"] = $nom.' '.$prenom;
              $_SESSION["nomOuvrier"] = $nom;
             $_SESSION["prenomOuvrier"] = $prenom;
        }
        elseif (substr($prenom, 0, strlen($debut)) == $debut) {
             $_SESSION["ouvrier"]=$prenom.' '.$nom;
             $_SESSION["nomOuvrier"]=$nom;
             $_SESSION["prenomOuvrier"]=$prenom;
        }
        else{}
    }
}
generateOptions($debut,$liste);
if (isset($_SESSION["ouvrier"])) {
    $ouvrier = $_SESSION["ouvrier"];
}
?>
<table> 
    <tr>
        <!--<th><center>Id</center></th>-->
        <th><center>AVANT PAUSE</center></th>
        <th><center>APRÈS PAUSE</center></th>
        <th><center>Observation</center></th>
    </tr>
<center><input type ="text" name ="identifiant" id ="identifiant" value ="<?php if(isset($ouvrier)){echo $ouvrier;}else{echo'_-'.'`'.') J`ai rien trouvé';}?>" style="width:300px;"disabled ="disabled"/></center></td>
<input type ="hidden" name ="nomOuv" id ="nomOuv" value ="<?php if(isset($_SESSION['nomOuvrier'])){echo $_SESSION['nomOuvrier'];}?>"/>
<input type ="hidden" name ="prenomOuv" id ="prenomOuv" value ="<?php if(isset($_SESSION['prenomOuvrier'])){echo $_SESSION['prenomOuvrier'];}?>" />
<center><p><td><input type='text' name="DebutD" id="DebutD" size="4" maxlength="4" value="" required="required"/><input id='FinD'  type="text" autocomplete="off" size="4" maxlength="4" name="FinD" value="" onfocus="this.value=''"></td>
<td><input id='DebutF' type="text" autocomplete="off" size="4" maxlength="4" name="DebutF" value="" onfocus="this.value=''" /><input id='FinF'  type="text" autocomplete="off" name="FinF" maxlength="4" size="4" value="" onfocus="this.value=''" /></td>
<td><textarea id='coment'  name="coment"  size="100"></textarea></p></center>
</tr>
<tr>
    <input type="hidden" id="lieu" name="lieu" value="<?php echo $chantier?>">
</tr>
<center><input id="submit" class="button" type="submit" style="width:800px;height:100px" value="Ajouter"></center>
</tr>