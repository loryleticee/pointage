<div id="contenu">
<center><form action="index.php?uc=admin&action=addUnChantier"  method="POST">
<fieldset><legend>NOUVEAU CHANTIER</legend> 
<p>Nom : <input class='inputIpad' type="text" style="width:600px;height:70px" name="nom" required></br></p>
<p>Numero : <input type="text" style="width:600px;height:70px" name="numero" required></br></p>
<p>Responsable : <select id="lstConduc" name="lstConduc" style="width:600px;height:30px;">
	<option value="9999" selected>Selectionner un responsable chantier...</option>
<?php foreach ($lesConduc as $unConduc) {
	$id = $unConduc["id"];
	$nom = $unConduc["nom"];
	$prenom = $unConduc["prenom"];?>
	<p><option value="<?php echo $id?>"><?php echo $nom.' '.$prenom?></option></p>
<?php }?>
</select></p><br>
<input type="submit" style="width:400px;height:100px" name="valider"  value="Ajouter">
</fieldset> 
</form></center>
</div>