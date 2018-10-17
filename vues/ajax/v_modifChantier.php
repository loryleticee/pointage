<?php
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if (isset($_POST["id"])) {
            $var = explode('.',addslashes($_POST["id"]));
            $id =$var[0];
            $libelle =$var[1];
            $number =$var[2];
            $modifier = $pdo->alterChant($id, $libelle, $number);
                if (!$modifier) {
                    echo "<div class='erreur'><center>Le chantier est dorénavant $number $libelle </center></div>";
                } else {
                    echo "<div class='erreur'><center>Modification erroné</center></div>";
                }

        }else{
            echo "<div class='erreur'><center>Pas de post</center></div>";
        }
?>