<div id="contenu">
<form action="index.php?uc=admin&action=ajouterUnEmploye"  method="POST">
<fieldset><legend>NOUVEAU SALARIÉE</legend>
<p>Nom : <input type="text" name="nom" required/></br></p>
<p>Prenom : <input type="text" name="prenom" required/></br></p>
<p>Login : <input type="text" name="login" required="required"/></p>
<p>Mdp : <input type="password" name="mdp" required="required"/></br></p>
<p>Confirmez Mdp : <input type="password" name="mdp1" /></br></p>
<p>E_mail : <input type="text" name="email" /></br></p>
<p>Entreprise : <select name="group" id="group"></p>
<?php
	 foreach ($lesEntreprise as $uneEntreprise){
	 	$id = $uneEntreprise["id"];
	 	$raison = $uneEntreprise["raison"];

		if($raison =="ANSART TP"){
			?>
			<option value="<?php echo $id?>" selected="selected"><?php echo $raison?></option>
			
<?php
		}
		else{
			?>
			<option value="<?php echo $id?>"><?php echo $raison?></option>
		<?php
		}
	}
?>
</select></br></br>
<p>Type : <select name="type" id="type"></p>
<?php
	 foreach ($lesTypes as $unType){
	 	$id=$unType["id"];
	 	$libelle=$unType["libelle"];

		if($libelle=="Ouvrier"){
			?>
			<option value="<?php echo $id?>" selected><?php echo $libelle?></option>
			
<?php
		}
		else{
			?>
			<option value="<?php echo $id?>"><?php echo $libelle?></option>
		<?php
		}
	}
?>
</select>
</br></br>
<input type="submit" class="button" style="width:750px;height:100px" name="valider"  value="Ajouter">
</fieldset>
</form>
</div>