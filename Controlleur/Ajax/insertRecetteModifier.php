<?php
/**
 * Fichier adm_gererRecette.php
 * Examens de TDI
 * @author Julien Savoie
 * @version Friday 5th of April 2019 08:44:33 AM
 */

/* =================================== */
/* = Composant ======================= */
/* =================================== */
require('../../../composants/lib/Autoloader.class.php');

/* =================================== */
/* = Contrôleurs ===================== */
/* =================================== */
require('../../controleurs/Controleur.class.php');

spl_autoload_register('autoloadAjax');


/* =================================== */
/* = Programme Principal ============= */
/* =================================== */
try{

  if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    $idRecette = $_POST['idRecette'];
    $sNomRecette = $_POST['sNomRecette'];
    $ingredients = $_POST['ingredients'];
    $idEtudiant = $_POST['idEtudiant'];
    $sprenomEtudiant = $_POST['sPrenomEtudiant'];
    $sNomEtudiant = $_POST['sNomEtudiant'];
    $idCoequipier = $_POST['idCoequipier'];
    $sPrenomCoequipier = $_POST['sPrenomCoequipier'];
    $sNomCoequipier = $_POST['sNomCoequipier'];

    switch($action) {
        case 'insert':
          try{
            $oControleur = new Controleur();

            $response = $oControleur->insertNewRecette($idRecette, $sNomRecette, $ingredients, $idEtudiant, $sprenomEtudiant, $sNomEtudiant, $idCoequipier, $sPrenomCoequipier, $sNomCoequipier);

            echo($response);

          }catch(Exception $oException){
            echo "<p>".$oException->getMessage()."</p>";
          };
          break;
        case 'blah' : echo("erreur");
          break;
        // ...etc...
    }
}

}catch(Exception $oException){
	echo "<p>".$oException->getMessage()."</p>";
}



?>
