<div id="contenu">
	<div id="resultat">
	</div>
<table>
	 <caption>LES MATERIAUX</caption>
             <tr>
				<th>NOM</th>  
                <th>NUMERO</th>
                <th><center>ACTION</center></th>
             </tr>
<form action="#" method="POST">
<?php
$i=0;
foreach ($lesEngins as $unEngin) {
	$id = $unEngin["id"];
	$nom = $unEngin["libelle"];
	$num = $unEngin["numero"];
	?>
	
	<tr><p><input type="hidden" id="id<?php echo $i;?>"name ="id" value="<?php echo $id;?>"/></p>
	<p><td><input type="text" id="nomMat<?php echo $i;?>" value="<?php echo $nom;;?>"size="30" name="nomMat" required="required"/></td></p>
	<p><td><input type="text" id="numMat<?php echo $i;?>" size="6" name="numChant" value="<?php echo $num;?>" required="required"/></td></p>
<p><td><input type="button" style="width:200px;height:50px" onclick="alterMat(<?php echo $i?>);" name="modifierEngin" value="modifier" alt="modifier <?php echo $nom.' '.$num?>" title="modifier <?php echo $nom.' '.$num?>"><input type="button" name="supprimer" style="width:200px;height:50px" value="supprimer" onclick="delMat(<?php echo $i ?>);"></td></p>
</tr>
<?php	
$i+=1;
}
?>
</form>
</table>
</div>