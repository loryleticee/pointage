<script src="todataurl.js"></script>
<script src="include/signature.js"></script>
<script src="include/js.js"></script>
<center><div id="resultat"><?php echo "<div class='erreur'><center>Une petite signature ? <center></center></div>";?></div>
		<div id="resultatUn"></div>
		<div id="canvas">
			<canvas class="roundCorners" id="newSignature"
			style="position: relative; margin: 0; padding: 0; border: 1px solid green;"></canvas>
		</div>
		<script>
			signatureCapture();
		</script>

		<button type="button" style="width:350px;height:50px;" onclick="<?php if(isset($_POST['listMeteo'])){?>saveMeteo(<?php echo $_POST['listMeteo'];?>);v=prompt('Si vous nête pas <?php echo $_SESSION['nom'].' '.$_SESSION['prenom']?> \nSaisissez \n Votre nom et votre prenom séparés d`un espace \nEXEMPLE :<?php echo strtolower($_SESSION['nom'].' '.$_SESSION['prenom'])?>' ,'<?php echo strtolower($_SESSION['nom'].' '.$_SESSION['prenom'])?>');if(v.lenght!='undefined'){sureName(v);signatureSave();}else{alert('Vous n`avez rien saisie');}<?php }?>">
			ENREGISTRER 
		</button>
		<button type="button" style="width:350px;height:50px;" onclick="signatureClear()">
			EFFACER 
		</button>
		<br>
		<img id="saveSignature" alt="Visa"/><br><br>
		<a href="index.php?uc=pointages&action=createFiche&ini=ok"><input class="button" type="button" style="width:450px;height:50px" value="CONTINUER"></a>
</center>