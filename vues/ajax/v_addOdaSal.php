<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
$chantier = $_SESSION['chantier'];
$lesCateg=$pdo->getLesEntreprise();
?>
<br><br>
Nom
<input type ="text" name ="nomOuv" id ="identifiant" style="width:300px;"/>
prenom
<input type ="text" name ="prenomOuv" id ="identifiant" style="width:300px;"/>
Entreprise
 	<select id="group" name="group" >
			<option value="0"  selected>Selectionner une entreprise</option>
<?php
	foreach ($lesCateg as $uneCateg) {
		$idCateg = $uneCateg["id"];
		$libCateg = $uneCateg["raison"];
		//var_dump($annee);
		if ($idCateg!=3) {
			echo "<option value='$idCateg'>$libCateg</option>";
		}
		
	}?>
		</select>
<input type="hidden" id="lieu" name="lieu" value="<?php echo $chantier?>">
<table> 
    <tr>
        <!--<th><center>Id</center></th>-->
        <th><center>AVANT PAUSE</center></th>
        <th><center>APRÈS PAUSE</center></th>
        <th><center>Observation</center></th>
    </tr>
<center><p><td><input type='text' name="DebutD" id="DebutD" size="4" maxlength="4" value="" required="required"/><input id='FinD'  type="text" autocomplete="off" size="4" maxlength="4" name="FinD" value="" onfocus="this.value=''"></td>
<td><input id='DebutF' type="text" autocomplete="off" size="4" maxlength="4" name="DebutF" value="" onfocus="this.value=''" /><input id='FinF'  type="text" autocomplete="off" name="FinF" maxlength="4" size="4" value="" onfocus="this.value=''" /></td>
<td><textarea id='coment'  name="coment"  size="100"></textarea></p></center>
</tr>
<center><input id="submit" class="button" type="submit" style="width:800px;height:100px" value="Ajouter"></center>
