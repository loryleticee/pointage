<div id="contenu">
	<div id="resultat">
	</div>
<table>
	 <caption>LES DOCUMENTS</caption>
             <tr>
                <th><center>LIBELLE</center></th>
                <th><center>ACTION</center></th>
             </tr>
<form action="#" method="POST">
<?php
$i=0;
foreach ($lesDoc as $unDoc) {
	$id = $unDoc["id"];
	$nom = $unDoc["libelle"];
	?>
	<tr><p><input type="hidden" id="id<?php echo $i;?>"name ="id" value="<?php echo $id;?>"/></p>
	<p><td><input type="text" id="nomDoc<?php echo $i;?>" value="<?php echo $nom;;?>"size="50" name="nomDoc" required="required"/></td></p>
<p><td><input type="button" class="button" style="width:200px;height:50px" onclick="alterDoc(<?php echo $i?>);" name="modifierDoc" value="modifier" alt="modifier <?php echo $nom?>" title="modifier <?php echo $nom?>"><input class="button" type="button" name="supprimer" style="width:200px;height:50px" value="supprimer" onclick="delDoc(<?php echo $i ?>);"></td></p>
</tr>
<?php	
$i+=1;
}
?>
</form>
</table>
</div>