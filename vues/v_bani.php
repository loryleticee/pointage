<div id="resultat">
</div>
<form>
<table> 
    <tr>
        <!--<th><center>Id</center></th>-->
        <th><center>Adresse</center></th>
        <th><center>Action</center></th>
    </tr>
<?php 
foreach ($lesBanis as $aBani) {
    $nom=$aBani['adresse'];
?>
<td><input type="text" id="adress" size="15" name="nom" value="<?php echo $nom; ?>" required/></td>
<td><input class="button" type="button" style="width:150px;height:50px" name="supprimer"  class="button" value="supprimer" alt="supprimer <?php echo $nom?>" title="supprimer <?php echo $nom?>" onclick="delBani(getElementById('adress').value);"/></td>

<?php
}?>
</table>
</form>