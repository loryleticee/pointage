<?php
session_start();
if (isset($_POST['chantier'])) {
    $_SESSION['chantier'] = $_POST['chantier'];?>
    <br>
         <center> <h3><u>SAISIR UN SALARIÉ</u></h3>
 	<label for="listYear" accesskey="n">Salarié : </label>
<input id="text" type="text" class="search" name="search" 
value="Rechercher..." onfocus="this.value=''"  onkeyup="searchOuvrier(document.getElementById('text').value);" 
onblur="this.value=''" autocomplete="off"/>
<input type="button" class="button" onclick="addOdaSal();" value="Autre salarié">
<?php
} 
else {
    echo "Pas de post chantier";
}
