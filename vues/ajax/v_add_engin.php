<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
require_once("../../include/fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
$lesIndice=$pdo->getLesIndice();
if (isset($_POST['id'])) {
    $group = $_POST['id'];
} 
else {
    echo "string";
}?>
<br><br>
<input id='idMateriel' type="hidden" autocomplete="off" size="30"  name="idMateriel" value="<?php echo $group?>" />
<input type="text" id="nomEngin" name="nomEngin" value="" size="30" maxlenght="60">
<input type="hidden" id="numMateriel" name="numMateriel" size="4" value="0">
<br><br><h1><center><u>DURÉE</u></center></h1><br><select id="listIndice" name="listIndice">
<?php
	foreach ($lesIndice as $unIndice) {
		$idIndice= $unIndice["id"];
		$libIndice= $unIndice["numero"];
        if ($idIndice == 1){
            echo "<option value='$idIndice' selected='selected'>$libIndice</option>";
        }else{
            echo "<option value='$idIndice'>$libIndice</option>";            
        }
	}?>
		</select><br><br>
<input id="submitEngin" class="button" name="submitEngin" type="submit" style="width:800px;height:100px" value="ajouter">
