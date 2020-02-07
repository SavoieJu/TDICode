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
    $idEtudiant = $_POST['idEtudiant'];
    $pwdEtudiant = $_POST['pwdEtudiant'];
    $idPartner = $_POST['idPartner'];
    switch($action) {
        case "loginTry":
          try{
            // Avec un coéquipier
            $oControleur = new Controleur();

            $response = $oControleur->connectionUtilisateur($idEtudiant, $pwdEtudiant, $idPartner);

            if ($response != "2" || $response != "3" || $response != "4") {
              echo(json_encode($response));
            } else {
              switch ($response) {
                case "2":
                  echo("Mauvais mot de passe.");
                  break;
                case "3":
                  echo("Erreur lors de l'authentification, vérifier votre numéro d'étudiant.");
                  break;
                case "4":
                  echo("Le numéro d'étudiant du coéquipier n'existe pas.");
                  break;
                default:
                  echo("Vérifier vos informations, si le problème persiste, contacter votre professeur.");
                  break;
              }
            }

          }catch(Exception $oException){
            echo "<p>".$oException->getMessage()."</p>";
          };
          break;
        case false :
        try{
          // Pas de coéquipier
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
