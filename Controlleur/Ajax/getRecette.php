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
    switch($action) {
        case 'getRecettes':
          try{
            $oControleur = new Controleur();

            $response = $oControleur->adm_afficherRecette();

            echo(json_encode($response));
          }catch(Exception $oException){
            echo "<p>".$oException->getMessage()."</p>";
          };
          break;
        // ...etc...
    }
}

}catch(Exception $oException){
	echo "<p>".$oException->getMessage()."</p>";
}



?>
