<div id="contenu">
	<div id="resultat">
	</div>
<table>
	 <caption>Les salariées</caption>
             <tr>
				<th><center>Nom</center></th>  
                <th><center>Prenom</center></th>              
                <th><center>Type</center></th>
                <th><center>Action</center></th>
             </tr>
<form>            
<?php
//faire un tableau
$i=0;
foreach ($lesSal as $unSAl) {
	$id = $unSAl["id"];
	$nom = $unSAl["nom"];
	$prenom = $unSAl["prenom"];
	$login = $unSAl["login"];
	$mdp = $unSAl["mdp"];
	$mail = $unSAl["email"];
	$type = $unSAl["id_type"];
	if($type==0){
		$type="Cadre";
	}
	if($type==1){
		$type="Ouvrier";
	}
	if($type==2){
		$type="Chef de chantier";
	}
	if($type==3){
		$type="Conducteur de travaux";
	}
	if($id!='0') {
	?>
	
	<p><tr><td><input type="hidden" id="id<?php echo $i?>" name ="id" value="<?php echo $id ?>"/><input type="text" id="nom<?php echo $i?>" value="<?php echo $nom; ?>"size="25" name="nom" required/></td>
	<td><input type="text" id="prenom<?php echo $i?>" size="15" name="prenom" value="<?php echo $prenom; ?>" required/></td>
	<td><input type="hidden" id="type<?php echo $i?>" value="<?php echo"$type"; ?>"><?php echo"$type"; ?></td>
	<td><input class="button" type="button" style="width:150px;height:50px" name="modifier" value="modifier" alt="modifier <?php echo $nom.' '.$prenom?>" title="modifier <?php echo $nom.' '.$prenom?>" onclick="alterSalarie(<?php echo $i ?>)">
	<input class="button" type="button" style="width:150px;height:50px" name="supprimer"  class="button" value="supprimer" alt="supprimer <?php echo $nom.' '.$prenom?>" title="supprimer <?php echo $nom.' '.$prenom?>" onclick="delSal(<?php echo $i ?>)"></td></p>
</tr>
<?php	
	}
$i+=1;
}
?>
</form></table></div>