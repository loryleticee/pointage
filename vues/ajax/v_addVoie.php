<br>
<table>
	<tr>
<th><center>Numéro de voie</center></th>
<th><center>Heure début coupure voie(AITC)</center></th>
<th><center>Heure fin coupure voie(AITC)</center></th>
<th><center>Heure consignation catenaire(9007)</center></th>
<th><center>Heure fin consignation catenaire(9007)</center></th>
<th><center>Heure début travaux</center></th>
<th><center>Heure fin travaux</center></th> 
</tr>
	<td><input type='text' name="nVoie" id="nVoie" size="30" maxlength="100"  onfocus="this.value=''" value="n1:n2:n3..." required="required"/></td> 
	<td><input id='hDebutAITC'  type="text" autocomplete="off" size="4" maxlength="4" name="hDebutAITC"  value="<?php echo date('Hi');?>" onfocus="this.value=''" required="required"/></td>
	<td><input id='hFinAITC' type="text" autocomplete="off" size="4" maxlength="4" name="hFinAITC" value="" onfocus="this.value=''" /></td>
	<td><input id='hDebutC'  type="text" autocomplete="off" name="hDebutC" maxlength="4" size="4" value="" onfocus="this.value=''" /></td>
	<td><input id='hFinC' type="text" autocomplete="off" size="4" maxlength="4" name="hFinC" value="" onfocus="this.value=''" /></td>
 	<td><input id='hDebutT'  type="text" autocomplete="off" name="hDebutT" maxlength="4" size="4" value="" onfocus="this.value=''" /></td>
 	<td><input id='hFinT' type="text" autocomplete="off" size="4" maxlength="4" name="hFinT" value="" onfocus="this.value=''"/></td>
	<tr>
		<input id="submit" class="button" name="subconsigne" type="button" style="width:800px;height:80px" value="Ajouter" onclick="addVoie();nVoie.value='';"></td>
	</tr>
</table>