<div id="contenu">
	<div id="resultat">
	</div>
<table>
	 <caption>LES ENTREPRISES</caption>
             <tr>
                <th><center>RAISON</center></th>
                <th><center>ACTION</center></th>
             </tr>
<form action="#" method="POST">
<?php
$i=0;
foreach ($lesGroup as $unGroup) {
	$id = $unGroup["id"];
	$nom = $unGroup["raison"];?>
	<tr><p><input type="hidden" id="id<?php echo $i;?>"name ="id" value="<?php echo $id;?>"/></p>
	<p><td><input type="text" id="nomGroup<?php echo $i;?>" value="<?php echo $nom;;?>"size="50" name="nomGroup" required="required"/></td></p>
<p><td><input  class="button" type="button" style="width:200px;height:50px" onclick="alterGroup(<?php echo $i?>);" name="modifierGroup" value="modifier" alt="modifier <?php echo $nom?>" title="modifier <?php echo $nom?>"><input type="button"  class="button" name="supprimer" style="width:200px;height:50px" value="supprimer" onclick="delGroup(<?php echo $i ?>);"></td></p>
</tr>
<?php	
$i+=1;
}
?>
</form>
</table>
</div>