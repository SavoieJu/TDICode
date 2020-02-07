<?php
/**
 * Fichier Controleur.class.php
 * Examens de TDI
 * @author Caroline Martin
 * @version Friday 5th of April 2019 08:44:30 AM
 */
class Controleur {
	private $oPDOLib;

	public function __construct(){
		$this->oPDOLib = new PDOLib();
	}//fin du _-construct

    /* ====================================================== */
	/* ============== INTERNAUTE ============================ */
	/* ====================================================== */
	/**
	 * Gère le fonctionnement du site Web
	 * @param void
	 * @return void
	 */
	 public function gererSite(){
	 	try{
	 		//Déclaration d'un objet de la classe Vue
	 		//pour accéder à toutes les méthodes de cette classe
	 		$oVue = new VueSiteEleve();
	 		$oIngredientMarqueAllergene = new Ingredients_marques_allergene();
			$oIngredientMarque= new Ingredients_marque();
			$oAllergene= new Allergene();
			$oRecettesIngredient = new Recettes_ingredient();
	 		/* Afficher le début de la page HTML */
	 		/*************************************/

	 		echo $oVue->afficherHeader("Techniques de dietetique");

			/* Afficher le contenu */
			/***********************/
			$oVue->afficherContenue();

	 		//* Afficher la fin de la page HTML */
	 		/*************************************/
	 		$aoIngredientMarque=$oIngredientMarque->rechercherTous($this->oPDOLib,true);
	 		$aoIngredientMarqueAllergene=$oIngredientMarqueAllergene->rechercherTousLesProduitsMarquesAllergenes($this->oPDOLib,true);
	 		$aoAllergene= $oAllergene->rechercherTousJSON($this->oPDOLib);
			$aoRec= $oRecettesIngredient->rechercherTous($this->oPDOLib,true);
	 		echo $oVue->afficherPiedPage($aoIngredientMarqueAllergene,$aoIngredientMarque,$aoAllergene,$aoRec);

		}catch(Exception $oException){
	 		echo "<p>".$oException->getMessage()."</p>";
	 	}
    }//fin de la fonction
	/**
	  * Gère 'afficher tous de' recettes côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function gererAfficherUneRecette(){
		try{

			//Déclaration d'un objet de la classe VueRecette
			//pour accéder aux méthodes de la classe
			$oVueRecettes_ingredient = new VueRecettes_ingredient();
			$oRecettes_ingredient = new Recettes_ingredient(1);
			$sMsg="";
			//Rechercher une Recette
			$aoRecettes_ingredient = $oRecettes_ingredient->rechercherTousLesIngredientsDeUneRecette($this->oPDOLib);

			//Affichage
			$oVueRecettes_ingredient->afficherUne($aoRecettes_ingredient, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction


	/* ====================================================== */
	/* ============== Administration ======================== */
	/* ====================================================== */
	/**
	 * Gère le fonctionnement du site Web
	 * @param void
	 * @return void
	 */
	 public function adm_gererSite(){
	 	try{
	 		//
	 		//Déclaration d'un objet de la classe Vue
	 		//pour accéder à toutes les méthodes de cette classe
	 		$oVue = new VueSite();
	 		$aCss = array("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",

			'../../public/css/adm_list.css',
			'../../public/css/adm_nav.css',
			'../../public/css/adm_form.css',
			"../../public/TE/jquery-te-1.4.0.css",
			'../../public/css/adm_global.css',
			"../../public/fontawesome-free-5.10.2-web/css/all.css");
			$aJs = array("../../public/js/fonctions.js",
			"https://code.jquery.com/jquery-3.3.1.min.js",
			"https://code.jquery.com/ui/1.12.1/jquery-ui.js",
			"../../public/TE/jquery-te-1.4.0.min.js"
			);
	 		/* Afficher le début de la page HTML */
	 		/*************************************/
	 		echo $oVue->getHeader('Administration :: TDI', $aCss, $aJs);
	 		if(isset($_GET['s']) == false){
				$_GET['s']=1;
			}
			/* Afficher le menu */
			/***********************/
			$aOptionsMenu = array(
				array('href'=>'index.php?s=1', 'title'=>'Accueil', 'text'=>'Accueil'),

				array('href'=>'index.php?s=2', 'title'=>'Etudiants', 'text'=>'Etudiants'),
				array('href'=>'index.php?s=3', 'title'=>'Recettes', 'text'=>'Recettes'),
				array('href'=>'index.php?s=4', 'title'=>'Produits', 'text'=>'Produits'),
				array('href'=>'index.php?s=5', 'title'=>'Marques', 'text'=>'Marques'),
				array('href'=>'index.php?s=6', 'title'=>'Allergènes', 'text'=>'Allergènes'),


			);
			$oVue->afficherNavigation($aOptionsMenu, $_GET['s'], "Administration", "Technique de Diététique");

			/* Afficher le contenu */
			/***********************/
			switch($_GET['s']){

				case 2:
					$this->adm_gererEtudiant();
				break;
				case 3:
					$this->adm_gererRecettePortionIngredient();
				break;
				case 4:
					$this->adm_gererProduit();
					break;
				case 5:
					$this->adm_gererMarque();
				break;
				case 6:
					$this->adm_gererAllergene();
				break;


			case 1: default:
                    $oVueSite = new VueSite();
                    $oVueSite->afficherAccueil();

			}



	 		/* Afficher la fin de la page HTML */
	 		/*************************************/
	 		$oVue->afficherPiedPage();

		}catch(Exception $oException){
	 		echo "<p>".$oException->getMessage()."</p>";
	 	}
    }//fin de la fonction


    /* ============================================================== */
    /* ALLERGÈNES =================================================== */
    /* ============================================================== */
	/**
	  * Gère les allergenes côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererAllergene(){
		try{
			//Déclaration d'un objet de la classe VueAllergene
			//pour accéder aux méthodes de la classe
			$oVueAllergene = new VueAllergene();
			$oAllergene = new Allergene();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousAllergene();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'all':
							$this->adm_gererSourceGlutenAllergene();
							break;
					case 'mod':
						$this->adm_gererModifierAllergene();
						break;
					case 'sup':
						$this->adm_gererSupprimerAllergene();
						break;
					case 'add':
						$this->adm_gererAjouterAllergene();
						break;
					default:
						$this->adm_gererAfficherTousAllergene();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction


    /**
	  * Gère source de gluten ou pas lors de la sauvegarde dans la BDD
	  * @param void
	  * @return void
	  */
    public function adm_gererSourceGlutenAllergene(){
        try{
            $oAllergene = new Allergene($_POST['idAllergene']);
            if($oAllergene->rechercherUn($this->oPDOLib) == true){

                $oAllergene->setbSourceGluten($_POST['bSourceGluten']);
                //Sauvegarder
                if($oAllergene->modifier($this->oPDOLib, 1) !== false){
                    $sMsg ='La modification de  - '.$oAllergene->getsNomAllergene().' - s\'est déroulée avec succès.';
                    echo $sMsg; //avec AJAX
                }else {
                    throw new Exception('Une erreur est survenue durant la modification de  : ' . $oAllergene->getsNomAllergene());
                }
            }else{
                throw new Exception('Erreur - Ce Allergene n\'existe pas.  : ' . $_POST['idAllergene']);
            }

        }catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' allergenes côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousAllergene($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueAllergene
			//pour accéder aux méthodes de la classe
			$oVueAllergene = new VueAllergene();
			$oAllergene = new Allergene();

			//Rechercher tous les Allergene
			$aoAllergenes = $oAllergene->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueAllergene->adm_afficherTous($aoAllergenes, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierAllergene(){
			try{



			if(isset($_POST['cmd']) == false){
                $oVueAllergene = new VueAllergene();

				$oAllergene = new Allergene($_GET['idAllergene']);
				if($oAllergene->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueAllergene->adm_afficherModifierUn($oAllergene);
				}else{
					throw new Exception('Erreur - Ce Allergene n\'existe pas.  : ' . $_GET['idAllergene']);
				}
			}else{
				$oAllergene = new Allergene($_POST['idAllergene']);
				if($oAllergene->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$bSourceGluten=0;
					if($_POST['bSourceGluten']=="true"){
						$bSourceGluten=1;
					}
					$oAllergene = new Allergene($_POST['idAllergene'],$_POST['sNomAllergene'],$bSourceGluten);
					//Sauvegarder
					if($oAllergene->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oAllergene->getsNomAllergene().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousAllergene($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oAllergene->getsNomAllergene());
					}
				}else{
					throw new Exception('Erreur - Ce Allergene n\'existe pas.  : ' . $_POST['idAllergene']);
				}


			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterAllergene(){
			try{


			if(isset($_POST['cmd']) == false){
                $oVueAllergene = new VueAllergene();
				//Affichage
				$oVueAllergene->adm_afficherAjouterUn();

			}else{
				//Affecter
				$bSourceGluten=0;
				if($_POST['bSourceGluten']=="true"){
					$bSourceGluten=1;
				}
				$oAllergene = new Allergene(1, $_POST['sNomAllergene'],$bSourceGluten);

				//Sauvegarder
				if($oAllergene->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oAllergene->getsNomAllergene().' - s\'est déroulé avec succès.';
					//Affichage
					//$oVueAllergene->adm_afficherAjouterUn($sMsg); //Sans AJAX
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oAllergene->getsNomAllergene());
				}
			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerAllergene(){
			try{
			$oVueAllergene = new VueAllergene();
			$oAllergene = new Allergene();
			$sMsg='';


			//Affecter
			$oAllergene = new Allergene($_POST['idAllergene']);
			if($oAllergene->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oAllergene->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oAllergene->getsNomAllergene().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousAllergene($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oAllergene->getsNomAllergene());
				}
			}else{
				throw new Exception('Erreur - Ce Allergene n\'existe pas.  : ' . $_POST['idAllergene']);
			}


		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
	}//fin de la fonction

	/* ============================================================== */
    /* ÉTUDIANTS ==================================================== */
    /* ============================================================== */
	/**
	  * Gère les etudiants côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererEtudiant(){
		try{
			$oVue = new VueSite();
			if(isset($_GET['s']) == false){

				$_GET['s'] = $_POST['s'];
			}
			$aSections = array(
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=1', 'title'=>'Visualiser les groupes/login/mot de passe', 'text'=>'Les groupes'),
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=2', 'title'=>'Visualiser les recettes modifiées et tableau d\'identification', 'text'=>'Les travaux'),
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=3', 'title'=>'Téléversement', 'text'=>'Téléversement')
			);

			if(isset($_GET['ss']) == false && isset($_POST['ss']) == false){
				$_GET['ss'] = 1;


				//Afficher le sous-menu Téléchargement/Visualiser
				echo $oVue->getNavigation($aSections, $_GET['ss']);
			}else{
				if(isset($_POST['ss']) == true){
					$_GET['ss'] = $_POST['ss'];
				}else{
					//Afficher le sous-menu Téléchargement/Visualiser
					echo $oVue->getNavigation($aSections, $_GET['ss']);
				}
			}

			switch($_GET['ss']){
				case 2:
					//Afficher les groupe/étudiants
					$this->adm_gererEtudiantsRecettes();
				break;
				case 3:
				//Afficher le formulaire de Téléchargement
				$this->adm_gererEtudiantTeleverser($sFileUpLoad);
				break;
				default:
					//Afficher les groupe/étudiants
					$this->adm_gererGroupes_etudiant();

			}

		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/* ============================================================== */
    /* TRAVAUX ====================================================== */
    /* ============================================================== */
	public function adm_gererEtudiantsRecettes(){
		try{

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$sAction = 1;
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}
			}

			switch($sAction){
				case "rec"://voir la recette modifiée par l'étudiant
					$this->adm_afficherRecetteModifiee();
				break;
				case "all":
                    $this->adm_afficherTableauIdentificationRecetteModifiee();

				break;
				case "sup":
					//supprimer la recette modifiée + tableau d'identification des allergènes réalisé par l'étudiant
                    $this->adm_supprimerRecetteModifiee();
				break;
				case "see":
					//rendre la recette modifiée + tableau d'identification des allergènes réalisé par l'étudiant accessible
					$this->adm_gererRendreAccessibleRecetteModifiee();
				break;
				default:
					//afficher la liste des étudiants + recette + Allergènes
					$this->adm_afficherToutesLesRecettesModifiees();
			}//fin du swtich


		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	 *
	 * @return void
	 */
	public function adm_afficherToutesLesRecettesModifiees(){
		try{
			$oVueERI = new VueEtudiants_recettes_ingredient();
			$oERI = new Etudiants_recettes_ingredient();

			//rechercher toutes les recettes pour un groupe
			$aoERI = $oERI->rechercherTous($this->oPDOLib);

			//afficher toputes les recettes de ce groupe
			 $oVueERI->adm_afficherTous($aoERI);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	 *
	 * @return void
	 */
	public function adm_afficherRecetteModifiee(){
		try{
			//Déclaration d'un objet de la classe VueRecette
			//pour accéder aux méthodes de la classe
			$oVueERI = new VueEtudiants_recettes_ingredient();

			$oERI = new Etudiants_recettes_ingredient($_GET['idEtudiant'], $_GET['idGroupe'], $_GET['idRecette']);

			//Rechercher une Recette
			$oERI->rechercherTousLesIngredientsDeUneRecetteModifiee($this->oPDOLib);


			//var_dump($aoERI);
			//Affichage
			$oVueERI->adm_afficherUne($oERI);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}

	}//fin de la fonction
    public function adm_gererERIA(){

        $oERIA = new Etudiants_recettes_ingredients_allergene();
        $oERIA->getoGroupe()->setidGroupe($_POST['idGroupe']);
        $oERIA->getoEtudiant()->setidEtudiant($_POST['idEtudiant']);
        $oERIA->getoRecette()->setidRecette($_POST['idRecette']);
        //rechercher les allergènes saisis par l'étudiant
        $sJSON_ERIA = $oERIA->rechercherTousLesAllergenesDeUneRecetteModifieeJSON($this->oPDOLib);


        //echo un objet json
        echo($sJSON_ERIA);
    }//fin de la fonction

    public function adm_afficherTableauIdentificationRecetteModifiee(){
        try{
			//Lire la liste des produits de la recette modifiée
			$oVueERIA = new VueEtudiants_recettes_ingredients_allergene();
			$oERIA = new Etudiants_recettes_ingredients_allergene();
			$oERIA->getoGroupe()->setidGroupe($_GET['idGroupe']);
			$oERIA->getoEtudiant()->setidEtudiant($_GET['idEtudiant']);
			$oERIA->getoRecette()->setidRecette($_GET['idRecette']);



			$bTrouve = $oERIA->rechercherTousLesAllergenesDeTousLesIngredientsDeUneRecetteModifiee($this->oPDOLib);
			$oAllergene = new Allergene();
			$aoAllergenes = $oAllergene->rechercherTous($this->oPDOLib);


			$oVueERIA -> adm_afficherTous($oERIA, $aoAllergenes);
            //Etudiants_recettes_ingredients == Etudiants_recettes_ingredients_allergene
            //1] En manque-t-il ?
            //2] Y En a-t-il en trop ?

            //Pour chacun des produits
                //Les allergènes sélectionnés par l'étudiant
                //Etudiants_recettes_ingredients_allergene == ingredients_marques_allergene
                //1] En manque-t-il ?
                //2] Y En a-t-il en trop ?


		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}

	}//fin de la fonction

    public function adm_supprimerRecetteModifiee(){
    try{

			$oERI = new Etudiants_recettes_ingredient($_POST['idEtudiant'], $_POST['idGroupe'], $_POST['idRecette']);
			$aoERI = $oERI->rechercherTousLesIngredientsDeUneRecetteModifiee($this->oPDOLib);
			if( $aoERI !== false){


				//Supprimer
				if($oERI->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de la recette modifiée s\'est déroulée avec succès.';

					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de la recette modifiée.');
				}
			}else{
				throw new Exception('Erreur - Ce  n\'existe pas.  : ' . $_POST['idAllergene']);
			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}

	}//fin de la fonction

	/**
	  * Gère l'Accessibilité de la Recette pour les étudiants
	  * @param void
	  * @return void
	  */
	public function adm_gererRendreAccessibleRecetteModifiee(){
		try{

			$oERI = new Etudiants_recettes_ingredient($_POST['idEtudiant'], $_POST['idGroupe'], $_POST['idRecette']);

			if($oERI->rechercherUn($this->oPDOLib) == true){

				$oERI->setbAccessible(($oERI->getbAccessible() == 1)? 0: 1);


			if($oERI->rendreAccessible($this->oPDOLib) !== false){
				$sMsg ='La recette modifiée n\'est plus accessible aux étudiants.';
				if($oERI->getbAccessible() == 1){
					$sMsg ='La recette modifiée est maintenant accessible aux étudiants.';
				}
				//Affichage
				echo $sMsg; //avec AJAX

			}else {
				throw new Exception('Une erreur est survenue durant la modification de l\'accessibilité.' );
			}
		}else{
				throw new Exception('Etudiants_recettes_ingredient n\'existe pas .' );
			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
	}//fin de la fonction

    /* ============================================================== */
    /* TELEVERSEMENT ================================================ */
    /* ============================================================== */
	/**
	  * Gère les etudiants (téléchargement) côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererEtudiantTeleversement(&$sFileUpload){
		try{
			$aCodes = array(
			 	UPLOAD_ERR_OK =>"Aucune erreur, le téléchargement est correct.",
				UPLOAD_ERR_INI_SIZE => "La taille du fichier téléchargé excède la valeur permise.",
				UPLOAD_ERR_FORM_SIZE => "La taille du fichier téléchargé excède la valeur permise.",
				UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé.",
				UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été téléchargé.",
				UPLOAD_ERR_NO_TMP_DIR => "Un dossier temporaire est manquant.",
				UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque.",
				UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté l'envoi de fichier."
			);

			if(isset($_FILES['sFichier']) == false){
				$oVueEtudiant = new VueEtudiant();
				$oVueEtudiant->adm_afficherTeleversement();
			}else{

				if(isset($_FILES['sFichier']) == false || $_FILES['sFichier']['name']==""){
					echo("Vous devez sélectionner un fichier à téléverser.");
					return;
				}
				if (isset($_FILES['sFichier']) == false  && $_FILES['sFichier']['error'] !== UPLOAD_ERR_OK) {
					echo $aCodes[$_FILES['sFichier']['error']];
					return;
				}

				$oTeleversementLib = new TeleversementLib('sFichier');
				$sErreur = $oTeleversementLib->televerser($sFileUpload);


				if($sErreur != TeleversementLib::ERR_FILE_UPLOAD_SUCCES){
					echo "Erreur dans le téléversement !";
					return;
				}


			}
		}catch(Exception $oException){
			echo($oException->getMessage());
		}

	}//fin de la fonction

	/**
	  * sanitise le contenu d'un fichier
	  * @param string $sFileUpload
	  * @return void
	  */
	  public function sanitizeContenuFichier($sFileUpload){
	  	//1]Lire le fichier
		$sContenuFile = file_get_contents(TeleversementLib::DOSSIER_FICHIERS.$sFileUpload);

			//2]ôter les signes "="
			$sContenuFile = str_replace("=", "", $sContenuFile);

			//3]Convertir en utf-8
			$sContenuFile = utf8_encode($sContenuFile);

			$sNomFichierEtudiant = TeleversementLib::DOSSIER_FICHIERS.$sFileUpload;
		//4]Écrire le fichier
		file_put_contents($sNomFichierEtudiant, $sContenuFile);
	  	return $sContenuFile;
	  }//fin de la fonction

	  /**
	  * récupérer le nom du groupe
	  * @param string $sFileUpload
	  * @return void
	  */
	  public function recupererLeNomDuGroupe($sFileUpload){
	  		//Découper le nom du ficher ($sFileUpload) pour obtenir le groupe
			$aGroupe = explode("gr", $sFileUpload);
			$aGroupe = explode("csv", $aGroupe[1]);
			$sNomGroupe = "gr".$aGroupe[0];

			return $sNomGroupe;
	  }//fin de la fonction

	  /**
	  * récupérer La Liste Des Etudiants
	  * @param string $sContenuFile
	  * @return void
	  */
	  public function recupererLaListeDesEtudiants($sContenuFile){
		$aContenuFile = explode(";", $sContenuFile);
		$iTaille = count($aContenuFile);
		for($i=0; $i<$iTaille; $i=$i+3){
			$idEtudiant = (int)trim($aContenuFile[$i], " \t\n\r\0\x0B\"");
			//var_dump($idEtudiant." != 0 ? "); var_dump($idEtudiant != 0);echo "<br>";
			if($idEtudiant != 0){
				$aidEtudiants[] = $idEtudiant;
			}
		}
		return $aidEtudiants;
	  }//fin de fonction

	  /**
	  * récupérer La Liste Des Etudiants
	  * @param array $aidEtudiants
	  * @return void
	  */
	  public function recupererLaListeDesUtilisateurs($aidEtudiants){

		$iTaille = count($aidEtudiants);
		$aoLoginsPwds = array();
		for($i=0; $i<$iTaille; $i++){
			if($aidEtudiants[$i] != 0){
				$idEtudiant = $aidEtudiants[$i];
				if(strlen($aidEtudiants[$i]) < 7){
					$idEtudiant = "0".$aidEtudiants[$i];
				}
				$oUtilisateur = new Utilisateur();
				$oUtilisateur->setsLoginUtilisateur("e".$idEtudiant);
				//Génerer Login/Pwd
				$oUtilisateur->generersPwdUtilisateur();
				$oUtilisateur->setiNoEtudiant($aidEtudiants[$i]);
				$aoLoginsPwds[] = $oUtilisateur;
			}
		}

		return $aoLoginsPwds;
	}//fin de la fonction

	/**
	  * Gère les etudiants
	  * 	à partir d'un fichier excel qui va être nettoyé
	  * 	qui sera téléversé sur le serveur
	  * 	puis importé dans la BDD
	  * 	Le nom du groupe de ces étudiants est lui aussi stocké dans la BDD
	  * 	On associe chaque étudiant à son groupe dans la BDD (table groupes_etudiants)
	  * 	On associe chaque étudiant avec son login/pwd
	  * 	On remplit la table utilisateurs avec login/pwd et no étudiant
	  * 	On envoie le message "La liste des étudiants avec leur Login/Pwd est prête." à AJAX
	  *
	  * @param string $sFileUpload
	  * @return void
	  */
	public function adm_gererEtudiantImporterDansBDD($sFileUpload){
		try{
			//1] Sanitise le contenu du fichier
			$sContenuFile = $this->sanitizeContenuFichier($sFileUpload);

			//2] Téléverse le fichier $sFileUpload
			$sNomFichierEtudiant = TeleversementLib::DOSSIER_FICHIERS.$sFileUpload;

			//3] Importe les étudiants de ce fichier dans la table "etudiants"
			$oEtudiant = new Etudiant();
			$bImportation = $oEtudiant->importerTous($this->oPDOLib, $sNomFichierEtudiant);

			//4] Sauvegarde du groupe dans la BDD
			$sNomGroupe = $this->recupererLeNomDuGroupe($sFileUpload);
			$oGroupe = new Groupe(1, $sNomGroupe, $_POST['sSession']);
			$iLastInsertId = $oGroupe->ajouter($this->oPDOLib);

			//5] Récupère la liste des étudiants dans un array
			$aidEtudiants = $this->recupererLaListeDesEtudiants($sContenuFile);

			//6] Ajoute tous les étudiants/leur groupe dans "groupes_etudiants"
			if($iLastInsertId !== false && $bImportation !== false){
				//ajouter dans la table groupes_etudiants
				$oGpeEtudiants = new Groupes_etudiant();
				$oGpeEtudiants->getoGroupe()->setidGroupe($iLastInsertId);
				$oGpeEtudiants->ajouterPlusieurs($this->oPDOLib, $aidEtudiants);
			}

			//7] Récupère la liste des utilisateurs
			$oUtilisateur = new Utilisateur();
			$aoLoginsPwds = $this->recupererLaListeDesUtilisateurs($aidEtudiants);

			//8] Ajoute dans la table "utilisateurs"
			$oUtilisateur->ajouterPlusieurs($this->oPDOLib, $aoLoginsPwds);

			//7] Retourne le message à AJAX
			echo "La liste des étudiants avec leur Login/Pwd est prête.";

		}catch(Exception $oException){
			echo($oException->getMessage());
		}

	}//fin de la fonction


	/**
	  * Gère les etudiants (téléversement) côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererEtudiantTeleverser(&$sFileUpload){
		try{

			$this->adm_gererEtudiantTeleversement($sFileUpload);

			if(isset($_POST['sSession']) == true){
				$this->adm_gererEtudiantImporterDansBDD($sFileUpload);
			}


		}catch(Exception $oException){
			echo($oException->getMessage());
		}

	}//fin de la fonction

	/**
	  * Gère les etudiants côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererEtudiantMAJ(){
		try{
			//Déclaration d'un objet de la classe VueEtudiant
			//pour accéder aux méthodes de la classe
			$oVueEtudiant = new VueEtudiant();
			$oEtudiant = new Etudiant();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousEtudiant();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'mod':
						$this->adm_gererModifierEtudiant();
						break;
					case 'sup':
						$this->adm_gererSupprimerEtudiant();
						break;
					case 'add':
						$this->adm_gererAjouterEtudiant();
						break;
					default:
						$this->adm_gererAfficherTousEtudiant();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère les etudiants côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererEtudiantParGroupe(){
		try{
			//Déclaration d'un objet de la classe VueEtudiant
			//pour accéder aux méthodes de la classe
			$oVueEtudiant = new VueEtudiant();
			$oEtudiant = new Etudiant();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousEtudiant();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'mod':
						$this->adm_gererModifierEtudiant();
						break;
					case 'sup':
						$this->adm_gererSupprimerEtudiant();
						break;
					case 'add':
						$this->adm_gererAjouterEtudiant();
						break;
					default:
						$this->adm_gererAfficherTousEtudiant();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' etudiants côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousEtudiant($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueEtudiant
			//pour accéder aux méthodes de la classe
			$oVueEtudiant = new VueEtudiant();
			$oEtudiant = new Etudiant();

			//Rechercher tous les Etudiant
			$aoEtudiants = $oEtudiant->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueEtudiant->adm_afficherTous($aoEtudiants, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierEtudiant(){
			try{
				$oEtudiant = new Etudiant($_POST['idEtudiant']);
				if($oEtudiant->rechercherUn($this->oPDOLib) == true){

                    $oUtilisateur = new Utilisateur();
                    $oUtilisateur->setiNoEtudiant($_POST['idEtudiant']);
                    //Génerer Login/Pwd
                    $bTrouve = $oUtilisateur->rechercherUnParNumeroEtudiant($this->oPDOLib);

                    if($bTrouve == true){
                        $oUtilisateur->generersPwdUtilisateur();
                        $oUtilisateur->modifier($this->oPDOLib);
                    }else{
                        $oUtilisateur->generersPwdUtilisateur();
                        $oUtilisateur->setsLoginUtilisateur("e".$oEtudiant->getidEtudiant());
                        if(strlen($oEtudiant->getidEtudiant()) < 7){
                            $oUtilisateur->setsLoginUtilisateur("e0".$oEtudiant->getidEtudiant());
                        }
                        $oUtilisateur->setiNoEtudiant($oEtudiant->getidEtudiant());
                        $oUtilisateur->ajouter($this->oPDOLib);
                    }
                    $sMsg ='La modification de  - '.$oEtudiant->getsNomEtudiant().' - s\'est déroulée avec succès.'."#".$oUtilisateur->getsLoginUtilisateur()."#".$oUtilisateur->getsPwdUtilisateur();
                    //Affichage
                    echo $sMsg; //avec AJAX

				}else{
					throw new Exception('Erreur - Ce Etudiant n\'existe pas.  : ' . $_POST['idEtudiant']);
				}




		}catch(Exception $oException){
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterEtudiant(){
			try{
			$oVueEtudiant = new VueEtudiant();
			$oEtudiant = new Etudiant();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				//Affichage
				$oVueEtudiant->adm_afficherAjouterUn();

			}else{
				//Affecter
				$oEtudiant = new Etudiant(1, $_POST['sNomEtudiant'],$_POST['sPrenomEtudiant']);

				//Sauvegarder
				if($oEtudiant->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oEtudiant->getsNomEtudiant().' - s\'est déroulé avec succès.';
					//Affichage
					//$oVueEtudiant->adm_afficherAjouterUn($sMsg); //Sans AJAX
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oEtudiant->getsNomEtudiant());
				}
			}

		}catch(Exception $oException){
			/*
			$oVueEtudiant = new VueEtudiant();
			$oVueEtudiant->adm_afficherAjouterUn($oException->getMessage());
			*/
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerEtudiant(){
			try{
			$oVueEtudiant = new VueEtudiant();
			$oEtudiant = new Etudiant();
			$sMsg='';


			//Affecter
			$oEtudiant = new Etudiant($_POST['idEtudiant']);
			if($oEtudiant->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oEtudiant->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oEtudiant->getsNomEtudiant().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousEtudiant($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oEtudiant->getsNomEtudiant());
				}
			}else{
				throw new Exception('Erreur - Ce Etudiant n\'existe pas.  : ' . $_POST['idEtudiant']);
			}


		}catch(Exception $oException){
			//$this->adm_gererAfficherTousEtudiant($oException->getMessage());
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

    /* ============================================================== */
    /* GROUPES ====================================================== */
    /* ============================================================== */
	/**
	  * Gère les groupes côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererGroupe(){
		try{
			//Déclaration d'un objet de la classe VueGroupe
			//pour accéder aux méthodes de la classe
			$oVueGroupe = new VueGroupe();
			$oGroupe = new Groupe();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousGroupe();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'mod':
						$this->adm_gererModifierGroupe();
						break;
					case 'sup':
						$this->adm_gererSupprimerGroupe();
						break;
					case 'add':
						$this->adm_gererAjouterGroupe();
						break;
					default:
						$this->adm_gererAfficherTousGroupe();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' groupes côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousGroupe($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueGroupe
			//pour accéder aux méthodes de la classe
			$oVueGroupe = new VueGroupe();
			$oGroupe = new Groupe();

			//Rechercher tous les Groupe
			$aoGroupes = $oGroupe->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueGroupe->adm_afficherTous($aoGroupes, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierGroupe(){
			try{
			$oVueGroupe = new VueGroupe();
			$oGroupe = new Groupe();
			$sMsg='';

			if(isset($_POST['cmd']) == false){
				$oGroupe = new Groupe($_GET['idGroupe']);
				if($oGroupe->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueGroupe->adm_afficherModifierUn($oGroupe, $sMsg);
				}else{
					throw new Exception('Erreur - Ce Groupe n\'existe pas.  : ' . $_GET['idGroupe']);
				}
			}else{
				$oGroupe = new Groupe($_POST['idGroupe']);
				if($oGroupe->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oGroupe = new Groupe($_POST['idGroupe'],$_POST['sNomGroupe'],$_POST['dateGroupe']);
					//Sauvegarder
					if($oGroupe->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oGroupe->getsNomGroupe().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousGroupe($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oGroupe->getsNomGroupe());
					}
				}else{
					throw new Exception('Erreur - Ce Groupe n\'existe pas.  : ' . $_POST['idGroupe']);
				}


			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterGroupe(){
			try{
			$oVueGroupe = new VueGroupe();
			$oGroupe = new Groupe();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				//Affichage
				$oVueGroupe->adm_afficherAjouterUn();

			}else{
				//Affecter
				$oGroupe = new Groupe(1, $_POST['sNomGroupe'],$_POST['dateGroupe']);

				//Sauvegarder
				if($oGroupe->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oGroupe->getsNomGroupe().' - s\'est déroulé avec succès.';
					//Affichage
					//$oVueGroupe->adm_afficherAjouterUn($sMsg); //Sans AJAX
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oGroupe->getsNomGroupe());
				}
			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerGroupe(){
			try{
			$oVueGroupe = new VueGroupe();
			$oGroupe = new Groupe();
			$sMsg='';


			//Affecter
			$oGroupe = new Groupe($_POST['idGroupe']);
			if($oGroupe->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oGroupe->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oGroupe->getsNomGroupe().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousGroupe($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oGroupe->getsNomGroupe());
				}
			}else{
				throw new Exception('Erreur - Ce Groupe n\'existe pas.  : ' . $_POST['idGroupe']);
			}


		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction



    /* ============================================================== */
    /* GROUPES_ETUDIANTS ============================================ */
    /* ============================================================== */
	/**
	  * Gère les groupes_etudiants côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererGroupes_etudiant(){
		try{
			//Déclaration d'un objet de la classe VueGroupes_etudiant
			//pour accéder aux méthodes de la classe
			$oVueGroupes_etudiant = new VueGroupes_etudiant();
			$oGroupes_etudiant = new Groupes_etudiant();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousGroupes_etudiant();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){

					case 'sup':
						$this->adm_gererSupprimerGroupes_etudiant();
						break;
					case 'mod':
						$this->adm_gererModifierEtudiant();
						break;
					default:
						$this->adm_gererAfficherTousGroupes_etudiant();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' groupes_etudiants côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousGroupes_etudiant($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueGroupes_etudiant
			//pour accéder aux méthodes de la classe
			$oVueGroupes_etudiant = new VueGroupes_etudiant();
			$oGroupes_etudiant = new Groupes_etudiant();

			//Rechercher tous les Groupes_etudiant
			$aoGroupes_etudiants = $oGroupes_etudiant->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueGroupes_etudiant->adm_afficherTous($aoGroupes_etudiants);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierGroupes_etudiant(){
			try{
			$oVueGroupes_etudiant = new VueGroupes_etudiant();
			$oGroupes_etudiant = new Groupes_etudiant();
			$sMsg='';

			if(isset($_POST['cmd']) == false){
				$oGroupes_etudiant = new Groupes_etudiant($_GET['idgroupe']);
				if($oGroupes_etudiant->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueGroupes_etudiant->adm_afficherModifierUn($oGroupes_etudiant, $sMsg);
				}else{
					throw new Exception('Erreur - Ce Groupes_etudiant n\'existe pas.  : ' . $_GET['idgroupe']);
				}
			}else{
				$oGroupes_etudiant = new Groupes_etudiant($_POST['idgroupe']);
				if($oGroupes_etudiant->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oGroupes_etudiant = new Groupes_etudiant($_POST['idgroupe'],$_POST['idEtudiant']);
					//Sauvegarder
					if($oGroupes_etudiant->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oGroupes_etudiant->getidEtudiant().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousGroupes_etudiant($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oGroupes_etudiant->getidEtudiant());
					}
				}else{
					throw new Exception('Erreur - Ce Groupes_etudiant n\'existe pas.  : ' . $_POST['idgroupe']);
				}


			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterGroupes_etudiant(){
			try{
			$oVueGroupes_etudiant = new VueGroupes_etudiant();
			$oGroupes_etudiant = new Groupes_etudiant();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				//Affichage
				$oVueGroupes_etudiant->adm_afficherAjouterUn();

			}else{
				//Affecter
				$oGroupes_etudiant = new Groupes_etudiant(1, $_POST['idEtudiant']);

				//Sauvegarder
				if($oGroupes_etudiant->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oGroupes_etudiant->getidEtudiant().' - s\'est déroulé avec succès.';
					//Affichage
					//$oVueGroupes_etudiant->adm_afficherAjouterUn($sMsg); //Sans AJAX
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oGroupes_etudiant->getidEtudiant());
				}
			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerGroupes_etudiant(){
			try{
			$oVueGroupes_etudiant = new VueGroupes_etudiant();
			$oGroupes_etudiant = new Groupes_etudiant();
			$sMsg='';


			//Affecter
			$oGroupes_etudiant = new Groupes_etudiant($_POST['idGroupe']);
			if($oGroupes_etudiant->getoGroupe()->rechercherUn($this->oPDOLib) == true){
				//Supprimer

				if($oGroupes_etudiant->supprimerEtudiantsDUnGroupe($this->oPDOLib) && $oGroupes_etudiant->getoGroupe()->supprimer($this->oPDOLib) !== false){

					$sMsg ='La suppression de  - '.$oGroupes_etudiant->getoGroupe()->getsNomGroupe().' - '.$oGroupes_etudiant->getoGroupe()->getdateGroupe().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousGroupes_etudiant($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oGroupes_etudiant->getoGroupe()->getsNomGroupe().' - '.$oGroupes_etudiant->getoGroupe()->getdateGroupe());
				}
			}else{
				throw new Exception('Erreur - Ce groupe n\'existe pas.  : ' . $_POST['idGroupe']);
			}


		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction


    /* ============================================================== */
    /* PRODUITS ===================================================== */
    /* ============================================================== */
	/**
	  * Gère les produits (ingredients) côté administration
	  * maj des produits
	  * association avec les marques
	  * association avec les allergènes
	  * @param void
	  * @return void
	  */
	public function adm_gererProduit(){
		try{

			if(isset($_GET['s']) == false){
				$_GET['s'] = $_POST['s'];
			}
			$aSections = array(
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=1', 'title'=>'Gérer les produits', 'text'=>'Produits'),
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=2', 'title'=>'Gérer les associations entre produits et marques', 'text'=>'Produits-Marques'),
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=3', 'title'=>'Gérer les associations entre les produits/marques et les allergènes', 'text'=>'Produits-Marques-Allergènes'),
				array('href'=>'index.php?s='.$_GET['s'].'&amp;ss=4', 'title'=>'Téléversement du cahier des allergènes', 'text'=>'Téléversement')
			);

			if(isset($_GET['ss']) == false && isset($_POST['ss']) == false){
				$_GET['ss'] = 1;
				$oVue = new VueSite();
				echo $oVue->getNavigation($aSections, $_GET['ss']);
			}else{
				if(isset($_POST['ss']) == true){
					$_GET['ss'] = $_POST['ss'];
				}else{
					$oVue = new VueSite();
					//Afficher le sous-menu Téléchargement/Visualiser
					echo $oVue->getNavigation($aSections, $_GET['ss']);
				}
			}

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$sAction = "";
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}
			}

			switch($_GET['ss']){
				case 2:
					$this->adm_gererIngredientMarque($sAction);
				break;//fin du case 2
				case 3:
					$this->adm_gererIngredientMarqueAllergene($sAction);
				break;
				case 4:
					//Afficher le formulaire de Téléchargement
					$this->adm_gererIngredientTeleverser($sFileUpLoad);
				break;
				case 1: default:
					$this->adm_gererIngredient($sAction);
				break;
			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction
	/**
	  * Gère les ingredients-marques-allergenes côté administration
	  * @param string $sAction
	  * @return void
	  */
	public function adm_gererIngredientMarqueAllergene($sAction){
		try{
			switch($sAction){
				case 'mod':
					$this->adm_gererModifierIngredientMarqueAllergene();
					break;
				case 'sup':
					$this->adm_gererSupprimerIngredientMarqueAllergene();
					break;
				case 'add':
					$this->adm_gererAjouterIngredientMarqueAllergene();
					break;
				default:
					$this->adm_gererAfficherTousIngredientMarqueAllergene();
			}//fin du switch()
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction
	/**
	  * Gère les produits côté administration
	  * @param string $sAction
	  * @return void
	  */
	public function adm_gererIngredient($sAction){
		try{
			switch($sAction){
				case 'mod':
					$this->adm_gererModifierIngredient();
					break;
				case 'sup':
					$this->adm_gererSupprimerIngredient();
					break;
				case 'add':
					$this->adm_gererAjouterIngredient();
					break;
				default:
					$this->adm_gererAfficherTousIngredient();
			}//fin du switch()
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' ingredients côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousIngredient($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueIngredient
			//pour accéder aux méthodes de la classe
			$oVueIngredient = new VueIngredient();
			$oIngredient = new Ingredient();

			//Rechercher tous les Ingredients
			$aoIngredients = $oIngredient->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueIngredient->adm_afficherTous($aoIngredients, $sMsg);

		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère modifier les ingredients côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererModifierIngredient($sMsg=''){
		try{
			if(isset($_POST['cmd']) == false){
				$oVueIngredient = new VueIngredient();
				$oIngredient = new Ingredient($_GET['idIngredient']);
				if($oIngredient->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueIngredient->adm_afficherModifierUn($oIngredient, $sMsg);
				}else{
					throw new Exception('Erreur - Ce produit n\'existe pas.  : ' . $_GET['idIngredient']);
				}
			}else{
				$oIngredient = new Ingredient($_POST['idIngredient']);
				if($oIngredient->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oIngredient = new Ingredient($_POST['idIngredient'],$_POST['sNomIngredient']);
					//Sauvegarder
					if($oIngredient->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oIngredient->getsNomIngredient().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousIngredient($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oIngredient->getsNomIngredient());
					}
				}else{
					throw new Exception('Erreur - Ce produit n\'existe pas.  : ' . $_POST['idIngredient']);
				}


			}

		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère ajouter les ingredients côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAjouterIngredient($sMsg=''){
		try{
			if(isset($_POST['cmd']) == false){
				$oVueIngredient = new VueIngredient();
				$oIngredient = new Ingredient();
				//Affichage
				$oVueIngredient->adm_afficherModifierUn($oIngredient, $sMsg);
			}else{
				//Affecter
				$oIngredient = new Ingredient(1, $_POST['sNomIngredient']);

				//Sauvegarder
				if($oIngredient->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oIngredient->getsNomIngredient().' - s\'est déroulé avec succès.';
					//Affichage
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oIngredient->getsNomIngredient());
				}
			}



		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère supprimer les ingredients côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererSupprimerIngredient($sMsg=''){
		try{
			$oVueIngredient = new VueIngredient();
			$oIngredient = new Ingredient();
			$sMsg='';


			//Affecter
			$oIngredient = new Ingredient($_POST['idIngredient']);
			if($oIngredient->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oIngredient->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oIngredient->getsNomIngredient().' - s\'est déroulée avec succès.';
					//Affichage
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oIngredient->getsNomIngredient());
				}
			}else{
				throw new Exception('Erreur - Ce produit n\'existe pas.  : ' . $_POST['idIngredient']);
			}


		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/* ============================================================== */
    /* PRODUITS-MARQUES ============================================= */
    /* ============================================================== */
	/**
	  * Gère les ingredients-marques côté administration
	  * @param string $sAction
	  * @return void
	  */
	public function adm_gererIngredientMarque($sAction){
		try{
			switch($sAction){
				case 'mod':
					$this->adm_gererModifierIngredientMarque();
					break;
				default:
					$this->adm_gererAfficherTousIngredientMarque();
			}//fin du switch()
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}
	/**
	  * Gère 'afficher tous de' ingredients-marques côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousIngredientMarque($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueIngredient
			//pour accéder aux méthodes de la classe
			$oVueIngredients_marque = new VueIngredients_marque();
			$oIngredient = new Ingredient();

			//Rechercher tous les Ingredients
			$aoIngredients = $oIngredient->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueIngredients_marque->adm_afficherTous($aoIngredients, $sMsg);

		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'modifier' ingredients-marques côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererModifierIngredientMarque($sMsg=''){
		try{
			if(isset($_POST['cmd']) == false){

				$oIngredients_marque = new Ingredients_marque($_GET['idIngredient']);
				$aoIM = $oIngredients_marque->rechercherUnIngredient($this->oPDOLib);

				//Affichage
				$oVueIngredients_marque = new VueIngredients_marque();
				$oMarque = new Marque();

				$aoMarques = $oMarque->rechercherTous($this->oPDOLib);

				$oIngredients_marque = new Ingredients_marque($_GET['idIngredient']);
				$oIngredients_marque->getoIngredient()->rechercherUn($this->oPDOLib);
				$oVueIngredients_marque->adm_afficherModifierUn($oIngredients_marque, $aoIM, $aoMarques);

			}else{
				$oIngredients_marque = new Ingredients_marque($_POST['idIngredient']);

				$oIngredients_marque->getoIngredient()->rechercherUn($this->oPDOLib);
				//Sauvegarder l'association produit-marques
				$oIngredients_marque->supprimerUnIngredient($this->oPDOLib);

				$sMsg = 'Aucune association de  - '.$oIngredients_marque->getoIngredient()->getsNomIngredient().' - avec des marques n\'a été réalisée.';
				if(isset($_POST["idMarque"]) == true){
					if($oIngredients_marque->ajouterPlusieurs($this->oPDOLib, $_POST["idMarque"]) == true){
						$sMsg ='L\'association de  - '.$oIngredients_marque->getoIngredient()->getsNomIngredient().' - avec les marques sélectionnées  s\'est déroulée avec succès.';
					}else{
						$sMsg ='Un problème est survenu lors de l\'association de  - '.$oIngredients_marque->getoIngredient()->getsNomIngredient().' - avec les marques sélectionnées.';
					}
				}
				echo $sMsg; // AJAX


			}

		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction


	/**
	  * Gère les allergenes (téléchargement) côté administration
	  * @param string &$sFileUpload paramètre par référence
	  * @return void
	  */
	 public function adm_gererTeleversement(&$sFileUpload){
		try{
			$aCodes = array(
			 	UPLOAD_ERR_OK =>"Aucune erreur, le téléchargement est correct.",
				UPLOAD_ERR_INI_SIZE => "La taille du fichier téléchargé excède la valeur permise.",
				UPLOAD_ERR_FORM_SIZE => "La taille du fichier téléchargé excède la valeur permise.",
				UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé.",
				UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été téléchargé.",
				UPLOAD_ERR_NO_TMP_DIR => "Un dossier temporaire est manquant.",
				UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque.",
				UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté l'envoi de fichier."
			);

			if(isset($_FILES['sFichier']) == false){
				$oVueIngredient = new VueIngredient();
				$oVueIngredient->adm_afficherTeleversement();
			}else{

				if(isset($_FILES['sFichier']) == false || $_FILES['sFichier']['name']==""){
					echo("Vous devez sélectionner un fichier à téléverser.");
					return;
				}
				if (isset($_FILES['sFichier']) == false  && $_FILES['sFichier']['error'] !== UPLOAD_ERR_OK) {
					echo $aCodes[$_FILES['sFichier']['error']];
					return;
				}

				$oTeleversementLib = new TeleversementLib('sFichier');
				$sErreur = $oTeleversementLib->televerser($sFileUpload);


				if($sErreur != TeleversementLib::ERR_FILE_UPLOAD_SUCCES){
					echo "Erreur dans le téléversement !";
					return false;
				}

				return true;
			}
		}catch(Exception $oException){
			echo($oException->getMessage());
		}

	}//fin de la fonction


	/**
	  * Gère les ingrédients (téléversement) côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererIngredientTeleverser(&$sFileUpload){
		try{
			$b = $this->adm_gererTeleversement($sFileUpload);

			if($b == true){
				$this->adm_gererIngredientImporterDansBDD($sFileUpload);
			}


		}catch(Exception $oException){
			echo($oException->getMessage());
		}

	}//fin de la fonction

	public function adm_gererIngredientImporterDansBDD($sFileUpload){
		  define("DATE_MAJ","0");
			define("INGREDIENT","1");
			define("MARQUE","2");
			define("IMAGE","3");
			define("CONSTITUANT","4");
			define("PEUT_CONTENIR","5");
			define("ALLERGENE","6");

			//1]Lire le fichier
			$sContenuFile = file_get_contents(TeleversementLib::DOSSIER_FICHIERS.$sFileUpload);
			//2]Convertir en utf-8
			//$sContenuFile = utf8_encode($sContenuFile);

			$sContenuFile = str_ireplace("Soja", "Soya", $sContenuFile);
			$sContenuFile = str_ireplace("sulftes", "sulfites", $sContenuFile);
			$sContenuFile = str_ireplace("céleri", "sulfites", $sContenuFile);
			$sContenuFile = str_ireplace("leri", "sulfites", $sContenuFile);
			$sContenuFile = str_ireplace("Arachides", "Arachide", $sContenuFile);
			$sContenuFile = str_ireplace("Allergènes", "", $sContenuFile);
			$sContenuFile = str_ireplace("Allergenes", "", $sContenuFile);
			$sContenuFile = str_ireplace("Allergie", "", $sContenuFile);
			$sContenuFile = str_ireplace("Allergies", "", $sContenuFile);

			$sContenuFile = str_ireplace(":", "", $sContenuFile);
			$sContenuFile = str_ireplace("Trace de", "", $sContenuFile);
			$sContenuFile = str_ireplace("S.O", "", $sContenuFile);
			$sContenuFile = str_ireplace("S.O.", "", $sContenuFile);
			$sContenuFile = str_ireplace("S'O", "", $sContenuFile);
			$sContenuFile = str_ireplace("Aucun constituant", "", $sContenuFile);


			$sProduits = str_ireplace("\r\n;", "$", $sContenuFile);
			$sProduits = str_ireplace("\r\n", "", $sProduits);
			$sProduits = str_ireplace("$", "\r\n;", $sProduits);

			//4]découper selon les ;
			$aProduits = explode("\r\n", $sProduits);
			$iNbProduits = count($aProduits);

			//var_dump($iNbProduits);
			//echo "<pre>";
			//var_dump($aProduits);
			//echo "</pre>";
			$aCols = array();
			for($i=0; $i< $iNbProduits; $i++){
				$aCols[$i] = explode(";", $aProduits[$i]);
			}
			//echo "<pre>";
			//var_dump($aCols);
			//echo "</pre>";
			//5]À partir de la table allergenes,
			//remplacer les champs string par le idAllergene dans le fichier

			//Rechercher tous les Allergènes
			$oAllergene = new Allergene();
			$aAllergenes = $oAllergene->rechercherTous($this->oPDOLib);
			/*
			echo "<pre>";
			var_dump($aAllergenes);
			echo "</pre>";
			*/
			$iNbAllergene = count($aAllergenes);
			$iNbProduits = count($aCols);
			$sNeoFichier = "";
			for($i=0; $i < $iNbAllergene; $i++){

				for($iPdt=0; $iPdt<$iNbProduits; $iPdt++){
					$sCol_peut_contenir = str_ireplace(strtolower ($aAllergenes[$i]->getsNomAllergene()), " ".$aAllergenes[$i]->getidAllergene()." ", strtolower ($aCols[$iPdt][PEUT_CONTENIR]));
					$sCol = str_ireplace(strtolower ($aAllergenes[$i]->getsNomAllergene()), " ".$aAllergenes[$i]->getidAllergene()." ", strtolower ($aCols[$iPdt][ALLERGENE]));
					//$sCol = preg_replace('/\s\s+/', ' ', $sCol);
					//echo "<pre>";
					//var_dump($aCols[$iPdt][ALLERGENE]);
					//echo "</pre>";
					if($sCol_peut_contenir != $aCols[$iPdt][PEUT_CONTENIR]){
						$aCols[$iPdt][PEUT_CONTENIR]=$sCol_peut_contenir;
					}
					if($sCol != $aCols[$iPdt][ALLERGENE]){
						$aCols[$iPdt][ALLERGENE]=$sCol;
					}
				}//fin du for

			}
			//Constituer une chaine de caractères à partir du array
			/*
			$sCh = "";
			$aIngredients = array();
			$aMarques = array();

			for($i=1; $i<$iNbProduits; $i++){
				$aIngredients[$i] = trim($aCols[$i][INGREDIENT], "\" ");
				$aMarques[$i] = trim($aCols[$i][MARQUE], "\" ");

				$sCh .= trim($aCols[$i][INGREDIENT], "\" ")."$"
						.trim($aCols[$i][MARQUE], "\" ")."$"
						.trim($aCols[$i][CONSTITUANT], "\" ")."$"
						.trim($aCols[$i][ALLERGENE], "\" ")."$"
						.trim($aCols[$i][PEUT_CONTENIR], "\" ").";\r\n";


			}
			//1]Écrire le fichier
			$sContenuFile = file_put_contents(TeleversementLib::DOSSIER_FICHIERS."file_constitue.txt", $sCh);
			*/

			//POUR tous les enregistrements du fichier
			//$iNbMaxEnregistrement = count($aIngredients);
			$oIngredient = new Ingredient();
			$oMarque = new Marque();
			$oAllergene = new Allergene();

			for($i=1; $i< $iNbProduits; $i++){
				//Remplir la BDD
				//la table ingredients avec la colonne INGREDIENT
				$oIngredient->setsNomIngredient($aIngredients[$i]);
				$oIngredient->ajouter($this->oPDOLib);

				//la table marques avec la colonne MARQUE
				$oMarque->setsNomMarque($aMarques[$i]);
				$oMarque->ajouter($this->oPDOLib);

				//la table ingredients_marques avec idMarque et idIngredient + la colonne CONSTITUANT
				$oIngredients_marque = new Ingredients_marque($oIngredient->getidIngredient(), $oMarque->getidMarque(), trim($aCols[$i][CONSTITUANT], "\" "));
				$oIngredients_marque->ajouter($this->oPDOLib);

				//la table Ingredients_marques_allergene avec idMarque, idAllergene et idIngredient

				$aidAllergenes = explode(",", $aCols[$i][ALLERGENE]);
				//$oIngredient->getidIngredient()."-" . ."-".."-"
				if($aidAllergenes !== FALSE){//des allergènes
					for($idAllergene = 0; $idAllergene < count($aidAllergenes); $idAllergene++){
						$oIngredients_marques_allergene = new Ingredients_marques_allergene($oIngredient->getidIngredient(), $oMarque->getidMarque(), (int)trim($aidAllergenes[$idAllergene], "\" "), 0);
						$oIngredients_marques_allergene->ajouter($this->oPDOLib);
					}
				}

				$aidPeutContenir = explode(",", $aCols[$i][PEUT_CONTENIR]);
				if($aidPeutContenir !== FALSE){//des allergènes
					for($idAllergene = 0; $idAllergene < count($aidPeutContenir); $idAllergene++){
						$oIngredients_marques_allergene = new Ingredients_marques_allergene($oIngredient->getidIngredient(), $oMarque->getidMarque(), (int)trim($aidPeutContenir[$idAllergene], "\" "), 1);
						$oIngredients_marques_allergene->ajouter($this->oPDOLib);
					}
				}


			}//FIN_POUR
			echo "Marque et Ingredient et Allergènes --- Écrit ----";

	}//fin de la fonction


    /* ============================================================== */
    /* PRODUITS-MARQUES-ALLERGÈNES ================================== */
    /* ============================================================== */
	/**
	  * Gère 'afficher tous de' ingredients côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousIngredientMarqueAllergene($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueIngredient
			//pour accéder aux méthodes de la classe
			$oVueIngredients_marques_allergene = new VueIngredients_marques_allergene();
			$oIngredientMarque = new Ingredients_marque();

			//Rechercher tous les Ingredient
			$aoIngredientsMarques = $oIngredientMarque->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueIngredients_marques_allergene->adm_afficherTous($aoIngredientsMarques, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	public function constituerArrayDesAllergenes(&$aAllergenes){
		$i=0;
		if(isset($_POST["idAllergene"]) == true){
			$iNbAll = count($_POST["idAllergene"]);
			$aAllergenes = array();
			$aAllergenes["idAllergene"] = array();
			$aAllergenes["bPeutContenir"] = array();

			for($i=0; $i<$iNbAll; $i++){
				$aAllergenes["idAllergene"][$i] = $_POST["idAllergene"][$i];
				$aAllergenes["bPeutContenir"][$i] = 0;
			}
		}

		if(isset($_POST["pc_idAllergene"]) == true){
			$iNbAll = count($_POST["pc_idAllergene"]);
			for($j=0; $j<$iNbAll; $j++){
				$aAllergenes["idAllergene"][$i] = $_POST["pc_idAllergene"][$j];
				$aAllergenes["bPeutContenir"][$i] = 1;
				$i++;
			}

		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierIngredientMarqueAllergene(){
		try{

			if(isset($_POST['cmd']) == false){

				$oIngredients_marques_allergene = new Ingredients_marques_allergene($_GET['idIngredient'], $_GET['idMarque']);
				$aoIMA = $oIngredients_marques_allergene->rechercherTousLesAllergenes($this->oPDOLib);
				//var_dump($aoIMA);

				//Affichage
				$oVueIngredients_marques_allergene = new VueIngredients_marques_allergene();
				$oMarque = new Marque();
				$oAllergene = new Allergene();
				$aoMarques = $oMarque->rechercherTous($this->oPDOLib);
				$aoAllergenes = $oAllergene->rechercherTous($this->oPDOLib);
				$oIngredients_marque = new Ingredients_marque($_GET['idIngredient'], $_GET['idMarque']);
				$oIngredients_marque->rechercherUn($this->oPDOLib);
				$oVueIngredients_marques_allergene->adm_afficherModifierUn($aoIMA, $oIngredients_marque, $aoMarques, $aoAllergenes);

			}else{
				$sMsg="----";
				$oIM = new Ingredients_marque($_POST['idIngredient'], $_POST['idMarque']);
				if($oIM->getoIngredient()->rechercherUn($this->oPDOLib) == true){
					$oIM->setoMarque(new Marque($_POST['idMarque']));
					$oIM->getoMarque()->rechercherUn($this->oPDOLib);
					$oIM->setsConstituants($_POST['sConstituants']);
					$oIM->setsUrlImage($_POST['sUrlImage']);

					if($oIM->modifier($this->oPDOLib) !== false){
						$sMsg ='Ingrédients et Image de  - '.$oIM->getoIngredient()->getsNomIngredient().' avec '.$oIM->getoMarque()->getsNomMarque().'  ont été modifiés avec succès.';

						// Sauvegarder l'ingrédient-marque associé aux allergènes
						$this->constituerArrayDesAllergenes($aAllergenes);

						$oIMA = new Ingredients_marques_allergene($_POST['idIngredient'], $_POST['idMarque']);
						$bSup = $oIMA->supprimer($this->oPDOLib);

						if(isset($aAllergenes["idAllergene"]) == true){
							if($oIMA->ajouter($this->oPDOLib, $aAllergenes) == true){
								$sMsg .='<br>Les allergènes ont été ajoutés avec succès.';
							}else{
								throw new Exception("Une erreur s'est produite durant la sauvegarde des allergènes.");
							}
						}
					}//fin du modifier ingredient/marque

					echo $sMsg; //avec AJAX

				}else{
					throw new Exception('Erreur - Ce produit  : ' . $_POST['idIngredient'].' avec la marque '. $_POST['idIngredient'].'n\'existe pas.');
				}


			}

		}catch(Exception $oException){
			switch($oException->getCode()){
				case 1: //pas de AJAX
					//Affichage
					$oIngredients_marques_allergene = new Ingredients_marques_allergene($_GET['idIngredient'], $_GET['idMarque']);
					$aoIMA = $oIngredients_marques_allergene->rechercherTousLesAllergenes($this->oPDOLib);
					$oVueIngredients_marques_allergene = new VueIngredients_marques_allergene();
					$oMarque = new Marque();
					$oAllergene = new Allergene();
					$aoMarques = $oMarque->rechercherTous($this->oPDOLib);
					$aoAllergenes = $oAllergene->rechercherTous($this->oPDOLib);
					$oIngredients_marque = new Ingredients_marque($_GET['idIngredient'], $_GET['idMarque']);
					$oIM = $oIngredients_marque->rechercherUn($this->oPDOLib);
					$oVueIngredients_marques_allergene->adm_afficherModifierUn($aoIMA, $oIM, $aoMarques, $aoAllergenes);
				break;

				default:
					echo $oException->getMessage(); //avec AJAX
				break;
			}



		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterIngredientMarqueAllergene(){
		try{

			if(isset($_POST['cmd']) == false){
				$oIngredients_marques_allergene = new Ingredients_marques_allergene();

				//Affichage
				$oVueIngredients_marques_allergene = new VueIngredients_marques_allergene();
				$oMarque = new Marque();
				$oAllergene = new Allergene();
				$aoMarques = $oMarque->rechercherTous($this->oPDOLib);
				$aoAllergenes = $oAllergene->rechercherTous($this->oPDOLib);

				$oVueIngredients_marques_allergene->adm_afficherAjouterUn($aoMarques, $aoAllergenes);

			}else{

				$oIM = new Ingredients_marque();

				//Affecter
				$oIM->setoIngredient( new Ingredient(0,$_POST['sNomIngredient']));
				//1] Ajouter l'ingrédient
				$idIngredient = $oIM->getoIngredient()->ajouter($this->oPDOLib);
				if($idIngredient !== false){
					$sMsg ='L\'ajout de  - '.$oIM->getoIngredient()->getsNomIngredient().' - s\'est déroulé avec succès.';

					//2] Sauvegarder l'ingrédient associé à la marque (+ constituants + url image)
					$oIM->setoMarque(new Marque($_POST['idMarque']));
					$oIM->getoMarque()->rechercherUn($this->oPDOLib);
					$oIM->setsConstituants($_POST['sConstituants']);
					$oIM->setsUrlImage($_POST['sUrlImage']);
					if($oIM->ajouter($this->oPDOLib) !== false){
						$sMsg .='<br>L\'association de  - '.$oIM->getoIngredient()->getsNomIngredient().' avec '.$oIM->getoMarque()->getsNomMarque().'  s\'est déroulée avec succès.';

						//3] Sauvegarder l'ingrédient-marque associé aux allergènes
						$oIMA = new Ingredients_marques_allergene($idIngredient, $_POST['idMarque']);
						if(isset($_POST["idAllergene"]) == true){
							$iNbAll = count($_POST["idAllergene"]);
							$aAllergenes = array();
							$aAllergenes["idAllergene"] = array();
							$aAllergenes["bPeutContenir"] = array();
							for($i=0; $i<$iNbAll; $i++){
								$aAllergenes["idAllergene"][$i] = $_POST["idAllergene"][$i];
								$aAllergenes["bPeutContenir"][$i] = 0;
							}
						}
						if(isset($_POST["pc_idAllergene"]) == true){
							$iNbAll = count($_POST["pc_idAllergene"]);
							for($j=0; $j<$iNbAll; $j++){
								$aAllergenes["idAllergene"][$i] = $_POST["pc_idAllergene"][$j];
								$aAllergenes["bPeutContenir"][$i] = 1;
								$i++;
							}

						}
						if(isset($aAllergenes["idAllergene"]) == true){
							$oIMA->supprimer($this->oPDOLib);
							if($oIMA->ajouter($this->oPDOLib, $aAllergenes) == true){
								$sMsg .='<br>Les allergènes ont été ajoutés avec succès.';
							}else{
								throw new Exception("Une erreur s'est produite durant la sauvegarde des allergènes.");
							}
						}
					}//fin du ajouter ingredient/marque

						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oIM->getoIngredient()->getsNomIngredient());
					}
			}

		}catch(Exception $oException){
			switch($oException->getCode()){
				case 1: //pas de AJAX
					//Affichage
					$oIngredients_marques_allergene = new Ingredients_marques_allergene($_GET['idIngredient'], $_GET['idMarque']);
					$aoIMA = $oIngredients_marques_allergene->rechercherTousLesAllergenes($this->oPDOLib);
					$oVueIngredients_marques_allergene = new VueIngredients_marques_allergene();
					$oMarque = new Marque();
					$oAllergene = new Allergene();
					$aoMarques = $oMarque->rechercherTous($this->oPDOLib);
					$aoAllergenes = $oAllergene->rechercherTous($this->oPDOLib);
					$oIngredients_marque = new Ingredients_marque($_GET['idIngredient'], $_GET['idMarque']);
					$oIM = $oIngredients_marque->rechercherUn($this->oPDOLib);
					$oVueIngredients_marques_allergene->adm_afficherModifierUn($aoIMA, $oIM, $aoMarques, $aoAllergenes);
				break;

				default:
					echo $oException->getMessage(); //avec AJAX
				break;
			}

		}
	}//fin de la fonction

	/* ============================================================== */
    /* MARQUES ====================================================== */
    /* ============================================================== */

	/**
	  * Gère les marques côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererMarque(){
		try{
			//Déclaration d'un objet de la classe VueMarque
			//pour accéder aux méthodes de la classe
			$oVueMarque = new VueMarque();
			$oMarque = new Marque();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousMarque();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'mod':
						$this->adm_gererModifierMarque();
						break;
					case 'sup':
						$this->adm_gererSupprimerMarque();
						break;
					case 'add':
						$this->adm_gererAjouterMarque();
						break;
					default:
						$this->adm_gererAfficherTousMarque();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' marques côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousMarque($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueMarque
			//pour accéder aux méthodes de la classe
			$oVueMarque = new VueMarque();
			$oMarque = new Marque();

			//Rechercher tous les Marque
			$aoMarques = $oMarque->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueMarque->adm_afficherTous($aoMarques, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierMarque(){
			try{
			$oVueMarque = new VueMarque();
			$oMarque = new Marque();
			$sMsg='';

			if(isset($_POST['cmd']) == false){
				$oMarque = new Marque($_GET['idMarque']);
				if($oMarque->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueMarque->adm_afficherModifierUn($oMarque, $sMsg);
				}else{
					throw new Exception('Erreur - Ce Marque n\'existe pas.  : ' . $_GET['idMarque']);
				}
			}else{
				$oMarque = new Marque($_POST['idMarque']);
				if($oMarque->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oMarque = new Marque($_POST['idMarque'],$_POST['sNomMarque']);
					//Sauvegarder
					if($oMarque->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oMarque->getsNomMarque().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousMarque($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oMarque->getsNomMarque());
					}
				}else{
					throw new Exception('Erreur - Ce Marque n\'existe pas.  : ' . $_POST['idMarque']);
				}


			}

		}catch(Exception $oException){
			/*
			$oVueMarque = new VueMarque();
			$oMarque = new Marque($_GET['idMarque']);

			$oMarque->rechercherUn($this->oPDOLib);
			$oVueMarque->adm_afficherModifierUn($oMarque, $oException->getMessage());
			*/
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterMarque(){
			try{
			$oVueMarque = new VueMarque();
			$oMarque = new Marque();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				//Affichage
				$oVueMarque->adm_afficherAjouterUn();

			}else{
				//Affecter
				$oMarque = new Marque(1, $_POST['sNomMarque']);

				//Sauvegarder
				if($oMarque->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oMarque->getsNomMarque().' - s\'est déroulé avec succès.';
					//Affichage
					//$oVueMarque->adm_afficherAjouterUn($sMsg); //Sans AJAX
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oMarque->getsNomMarque());
				}
			}

		}catch(Exception $oException){
			/*
			$oVueMarque = new VueMarque();
			$oVueMarque->adm_afficherAjouterUn($oException->getMessage());
			*/
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerMarque(){
			try{
			$oVueMarque = new VueMarque();
			$oMarque = new Marque();
			$sMsg='';


			//Affecter
			$oMarque = new Marque($_POST['idMarque']);
			if($oMarque->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oMarque->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oMarque->getsNomMarque().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousMarque($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oMarque->getsNomMarque());
				}
			}else{
				throw new Exception('Erreur - Ce Marque n\'existe pas.  : ' . $_POST['idMarque']);
			}


		}catch(Exception $oException){
			//$this->adm_gererAfficherTousMarque($oException->getMessage());
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction






	/* ============================================================== */
    /* PORTIONS ===================================================== */
    /* ============================================================== */


	/**
	  * Gère les recettes/portions/produits côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererRecettePortionIngredient(){
		try{

			if(isset($_GET['ss'] ) == false){
				$_GET['ss'] = "";
			}

            switch($_GET['ss']){
                case 1:
                    $this->adm_gererPortion();
                    break;
                case 2:
                    $this->adm_gererRecettes_ingredient();
                    break;
                case "": default:
                   $this->adm_gererRecette();
            }


		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
    }//fin de la fonction

	/**
	  * Gère les recettes côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererRecette(){
		try{
			//Déclaration d'un objet de la classe VueRecette
			//pour accéder aux méthodes de la classe
			$oVueRecette = new VueRecette();
			$oRecette = new Recette();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousRecette();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

                switch($sAction){
                    case 'mod':
                        $this->adm_gererModifierRecette();
                        break;
                    case 'sup':
                        $this->adm_gererSupprimerRecette();
                        break;
                    case 'add':
                        $this->adm_gererAjouterRecette();
                        break;
					case "see":
						$this->adm_gererRendreAccessibleRecette();
						break;
                    default:
                        $this->adm_gererAfficherTousRecette();
                }//fin du switch()


			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction
    /**
	  * Gère les recettes côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererPortion(){
		try{

        	$this->adm_gererModifierPortion();

        }catch(Exception $oException){
            echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction
	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierPortion(){
		try{
			$oVuePortion = new VuePortion();
			$oPortion = new Portion();
			$oRecette = new Recette();
			$sMsg='';

			if(isset($_POST['cmd']) == false){
				$oPortion = new Portion($_GET['idPortion']);
				$oRecette->getoPortion()->setidPortion($_GET['idPortion']);
				$oRecette->rechercherUneRecetteParPortion($this->oPDOLib);
				if($oPortion->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVuePortion->adm_afficherModifierUn($oPortion, $oRecette, $sMsg);
				}else{
					throw new Exception('Erreur - Cette Portion n\'existe pas.  : ' . $_GET['idPortion']);
				}
			}else{
				$oPortion = new Portion($_POST['idPortion']);
				$oRecette->getoPortion()->setidPortion($_POST['idPortion']);
				$oRecette->rechercherUneRecetteParPortion($this->oPDOLib);
				if($oPortion->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oPortion = new Portion($_POST['idPortion'],$_POST['iNbPortions'],$_POST['sGrosseurPortion'],$_POST['sEnergiePortion'],$_POST['sGlucides'],$_POST['sProteines'],$_POST['sLipides'],$_POST['sFibres'],$_POST['sSodium']);
					//Sauvegarder
					if($oPortion->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification des portions de - '.$oRecette->getsNomRecette().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousPortion($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oPortion->getiNbPortions());
					}
				}else{
					throw new Exception('Erreur - Cette Portion n\'existe pas.  : ' . $_POST['idPortion']);
				}


			}

		}catch(Exception $oException){
			/*
			$oVuePortion = new VuePortion();
			$oPortion = new Portion($_GET['idPortion']);

			$oPortion->rechercherUn();
			$oVuePortion->adm_afficherModifierUn($oPortion, $oException->getMessage());
			*/
			echo $oException->getMessage(); //avec AJAX
		}
	}//fin de la fonction


    /* ============================================================== */
    /* RECETTES ===================================================== */
    /* ============================================================== */
	/**
	  * Gère l'Accessibilité de la Recette pour les étudiants
	  * @param void
	  * @return void
	  */
	public function adm_gererRendreAccessibleRecette(){
		try{

			$oRecette = new Recette($_POST['idRecette']);
			if($oRecette->rechercherUn($this->oPDOLib) == true){
				$oRecette->setbVisible(($oRecette->getbVisible() == true)? false: true);
			}

			if($oRecette->rendreAccessible($this->oPDOLib) !== false){
				$sMsg ='La recette n\'est plus accessible aux étudiants.';
				if($oRecette->getbVisible() == true){
					$sMsg ='La recette est maintenant accessible aux étudiants.';
				}
				//Affichage
				echo $sMsg; //avec AJAX
			}else {
				throw new Exception('Une erreur est survenue durant la modification de  l\'accessibilité.' );
			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
	}//fin de la fonction


	/**
	  * Gère 'afficher tous de' recettes côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousRecette($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueRecette
			//pour accéder aux méthodes de la classe
			$oVueRecette = new VueRecette();
			$oRecette = new Recette();

			//Rechercher tous les Recette
			$aoRecettes = $oRecette->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueRecette->adm_afficherTous($aoRecettes, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierRecette(){
			try{
			$oVueRecette = new VueRecette();
			$oRecette = new Recette();
			$sMsg='';

			if(isset($_POST['cmd']) == false){
				$oRecette = new Recette(trim($_GET['idRecette']));
				if($oRecette->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueRecette->adm_afficherModifierUn($oRecette, $sMsg);
				}else{
					throw new Exception('Erreur - Cette Recette n\'existe pas.  : ' . $_GET['idRecette']);
				}
			}else{
				$oRecette = new Recette(trim($_POST['idRecette']));
				if($oRecette->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oRecette = new Recette(trim($_POST['idRecette']),$_POST['sNomRecette'],$_POST['sDescRecette'], $_POST['sTempsCuisson'], $_POST['sTemperatureCuisson']);
					$oRecette->setiCategorie($_POST['sCategorie']);
					//Sauvegarder
					if($oRecette->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oRecette->getsNomRecette().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousRecette($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oRecette->getsNomRecette());
					}
				}else{
					throw new Exception('Erreur - Ce Recette n\'existe pas.  : ' . $_POST['idRecette']);
				}


			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterRecette(){
			try{
			$oVueRecette = new VueRecette();
			$oRecette = new Recette();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				//Affichage
				$oVueRecette->adm_afficherAjouterUn();

			}else{
				//Affecter
				$oRecette = new Recette($_POST['idRecette'],$_POST['sNomRecette'],$_POST['sDescRecette'], $_POST['sTempsCuisson'], $_POST['sTemperatureCuisson']);
				$oRecette->setiCategorie($_POST['sCategorie']);
				$oRecette->setoPortion(new Portion());
				//Sauvegarder
				//ajouter la portion (tout est à vide)
				if($oRecette->getoPortion()->ajouter($this->oPDOLib) !== false){

					if($oRecette->ajouter($this->oPDOLib) !== false){
						$sMsg = trim($oRecette->getidRecette().'&'.$oRecette->getoPortion()->getidPortion().'&L\'ajout de  - '.$oRecette->getsNomRecette().' - s\'est déroulé avec succès.');
						//Affichage
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oRecette->getsNomRecette());
					}
				}else {
						throw new Exception('Une erreur est survenue durant l\'ajout de  la portion pour la recette : ' . $oRecette->getsNomRecette());
					}
			}

		}catch(Exception $oException){

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerRecette(){
			try{
			$oVueRecette = new VueRecette();
			$oRecette = new Recette();
			$sMsg='';


			//Affecter
			$oRecette = new Recette($_POST['idRecette']);
			if($oRecette->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oRecette->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oRecette->getsNomRecette().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousRecette($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oRecette->getsNomRecette());
				}
			}else{
				throw new Exception('Erreur - Ce Recette n\'existe pas.  : ' . $_POST['idRecette']);
			}


		}catch(Exception $oException){
			//$this->adm_gererAfficherTousRecette($oException->getMessage());
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction


    /* ============================================================== */
    /* RECETTES-PRODUITS ============================================ */
    /* ============================================================== */
	/**
	  * Gère les recettes_ingredients côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererRecettes_ingredient(){
		try{

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousRecettes_ingredient();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'mod':
						$this->adm_gererModifierRecettes_ingredient();
						break;
					case 'sup':
						$this->adm_gererSupprimerRecettes_ingredient();
						break;
					case 'add':
						$this->adm_gererAjouterRecettes_ingredient();
						break;
					default:
						$this->adm_gererAfficherTousRecettes_ingredient();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' recettes_ingredients côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousRecettes_ingredient($sMsg=''){
		try{

			//Déclaration d'un objet de la classe VueRecettes_ingredient
			//pour accéder aux méthodes de la classe
			$oVueRecettes_ingredient = new VueRecettes_ingredient();
			$oIngredientRecette = new Recettes_ingredient();


			$oIngredientRecette->setoRecette(new Recette($_GET['idRecette']));
			$aoRecettes_ingredients = $oIngredientRecette->rechercherTousLesIngredientsDeUneRecette($this->oPDOLib);

			/* Si aucun ingrédient */
			if($aoRecettes_ingredients === false){
				$aoRecettes_ingredients = array(new Recettes_ingredient());
				$oRecette = new Recette($_GET['idRecette']);
				//Rechercher la Recette
				$oRecette->rechercherUn($this->oPDOLib);
				$aoRecettes_ingredients[0]->setoRecette($oRecette);

			}
			//Affichage

			$oVueRecettes_ingredient->adm_afficherTous($aoRecettes_ingredients);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierRecettes_ingredient(){
			try{
			$oVueRecettes_ingredient = new VueRecettes_ingredient();
			$oRecettes_ingredient = new Recettes_ingredient();
			$sMsg='';
			var_dump('adm_gererModifierRecettes_ingredient');
			if(isset($_POST['cmd']) == false){

				$oRecettes_ingredient = new Recettes_ingredient($_GET['idRecette'], $_GET['idIngredient'], $_GET['idMarque']);
				if($oRecettes_ingredient->rechercherUnIngredientCompletDeUneRecette($this->oPDOLib) !== false){

					//Affichage
					$oVueRecettes_ingredient->adm_afficherModifierUn($oRecettes_ingredient, $sMsg);
				}else{
					throw new Exception('Erreur - Ce Recettes_ingredient n\'existe pas.  : ' . $_GET['idRecette']);
				}
			}else{
				$oRecettes_ingredient = new Recettes_ingredient($_POST['idRecette']);

				if($oRecettes_ingredient->getoRecette()->rechercherUn($this->oPDOLib) == true){
                    //var_dump($_POST);
					//Affecter
					$oRecettes_ingredient = new Recettes_ingredient($_POST['idRecette'],$_POST['idIngredient'],$_POST['idMarque'],$_POST['']);
					//Sauvegarder
					if($oRecettes_ingredient->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oRecettes_ingredient->getidIngredient().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousRecettes_ingredient($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oRecettes_ingredient->getidIngredient());
					}
				}else{
					throw new Exception('Erreur - Ce Recettes_ingredient n\'existe pas.  : ' . $_POST['idRecette']);
				}


			}

		}catch(Exception $oException){

			$oVueRecettes_ingredient = new VueRecettes_ingredient();
			$oRecettes_ingredient = new Recettes_ingredient($_GET['idRecette']);

			$oRecettes_ingredient->rechercherUn($this->oPDOLib);
			$oVueRecettes_ingredient->adm_afficherModifierUn($oRecettes_ingredient, $oException->getMessage());

			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterRecettes_ingredient(){
			try{
			$oVueRecettes_ingredient = new VueRecettes_ingredient();
			$oRecettes_ingredient = new Recettes_ingredient();
			$oIngredientsMarques = new Ingredients_marque();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				$oRecettes_ingredient = new Recettes_ingredient($_GET['idRecette']);
				if($oRecettes_ingredient->getoRecette()->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$aoIngredientsMarques = $oIngredientsMarques->rechercherTous($this->oPDOLib);
					$oVueRecettes_ingredient->adm_afficherAjouterUn($oRecettes_ingredient, $aoIngredientsMarques);
				}else{
					throw new Exception('Erreur - Cette recette n\'existe pas.  : ' . $_GET['idRecette']);
				}
			}else{
				//Affecter
				$oRecettes_ingredient = new Recettes_ingredient($_POST['idRecette'], $_POST['idIngredient'],$_POST['idMarque']);

				$oRecettes_ingredient->getoRecette()->rechercherUn($this->oPDOLib);

				$bTrouve = $oRecettes_ingredient->rechercherUnIngredientDeUneRecette($this->oPDOLib);

				if(!($oRecettes_ingredient->getoPoids()->getidPoids() >=1 || $oRecettes_ingredient->getoMesure()->getidMesure() >=1 )  ){

					switch($_POST['poidsMesure']){
						case 'poids':
							$oRecettes_ingredient->setoPoids(new Poids(1, $_POST['poidsA'], $_POST['poidsC'], $_POST['unite']));

							//ajouter le poids
							$idPoids = $oRecettes_ingredient->getoPoids()->ajouter($this->oPDOLib);
							if($idPoids === false){
								throw new Exception('Une erreur est survenue durant l\'ajout du poids du produit  : ' . $oRecettes_ingredient->getoIngredient()->getsNomIngredient());
							}
							break;
						case 'mesure':
							$oRecettes_ingredient->setoMesure(new Mesure(1, $_POST['qte'], $_POST['uniteM']));
							//ajouter la mesure
							$idMesure = $oRecettes_ingredient->getoMesure()->ajouter($this->oPDOLib);
							if($idMesure === false){
								throw new Exception('Une erreur est survenue durant l\'ajout de la mesure du produit  : ' . $oRecettes_ingredient->getoIngredient()->getsNomIngredient());
							}
							break;

					}
				}
				//Sauvegarder
				if($bTrouve===false){
					$iNoErreur = $oRecettes_ingredient->ajouter($this->oPDOLib);

					if($iNoErreur === true ){
						$sMsg ='L\'ajout du produit s\'est déroulé avec succès.';
						//Affichage
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant l\'ajout du produit  : ' . $iNoErreur);
					}
				}else{
					throw new Exception('Ce produit est déjà associé à la recette.');
				}
			}


		}catch(Exception $oException){
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerRecettes_ingredient(){
			try{
			$oVueRecettes_ingredient = new VueRecettes_ingredient();
			$oRecettes_ingredient = new Recettes_ingredient();
            $oIngredient= new Ingredient($_POST['idIngredient']);
			$sMsg='';


			//Affecter
			$oRecettes_ingredient = new Recettes_ingredient($_POST['idRecette']);
            $oIngredient->rechercherUn($this->oPDOLib);
			if($oRecettes_ingredient->rechercherUnIngredientDeUneRecette($this->oPDOLib) == true){

				//Supprimer
				if($oRecettes_ingredient->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oIngredient->getsNomIngredient().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousRecettes_ingredient($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oRecettes_ingredient->getoIngredient()->getidIngredient());
				}
			}else{
				throw new Exception('Erreur - Ce Recettes_ingredient n\'existe pas.  : ' . $_POST['idRecette']);
			}


		}catch(Exception $oException){
			//$this->adm_gererAfficherTousRecettes_ingredient($oException->getMessage());
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction


    /* ============================================================== */
    /* UTILISATEURS ================================================= */
    /* ============================================================== */
	/**
	  * Gère les utilisateurs côté administration
	  * @param void
	  * @return void
	  */
	public function adm_gererUtilisateur(){
		try{
			//Déclaration d'un objet de la classe VueUtilisateur
			//pour accéder aux méthodes de la classe
			$oVueUtilisateur = new VueUtilisateur();
			$oUtilisateur = new Utilisateur();

			if(isset($_GET['action'] ) == false && isset($_POST['action'] ) == false){
				$this->adm_gererAfficherTousUtilisateur();
			}else{
				if(isset($_GET['action'] ) == true)
					$sAction = $_GET['action'];
				else{
					$sAction = $_POST['action'];
				}

				switch($sAction){
					case 'mod':
						$this->adm_gererModifierUtilisateur();
						break;
					case 'sup':
						$this->adm_gererSupprimerUtilisateur();
						break;
					case 'add':
						$this->adm_gererAjouterUtilisateur();
						break;
					default:
						$this->adm_gererAfficherTousUtilisateur();
				}//fin du switch()

			}
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère 'afficher tous de' utilisateurs côté administration
	  * @param string $sMsg
	  * @return void
	  */
	public function adm_gererAfficherTousUtilisateur($sMsg=''){
		try{
			//Déclaration d'un objet de la classe VueUtilisateur
			//pour accéder aux méthodes de la classe
			$oVueUtilisateur = new VueUtilisateur();
			$oUtilisateur = new Utilisateur();

			//Rechercher tous les Utilisateur
			$aoUtilisateurs = $oUtilisateur->rechercherTous($this->oPDOLib);
			//Affichage
			$oVueUtilisateur->adm_afficherTous($aoUtilisateurs, $sMsg);
		}catch(Exception $oException){
			echo "<p>".$oException->getMessage()."</p>";
		}
	}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire de modification ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererModifierUtilisateur(){
			try{
			$oVueUtilisateur = new VueUtilisateur();
			$oUtilisateur = new Utilisateur();
			$sMsg='';

			if(isset($_POST['cmd']) == false){
				$oUtilisateur = new Utilisateur($_GET['idUtilisateur']);
				if($oUtilisateur->rechercherUn($this->oPDOLib) == true){
					//Affichage
					$oVueUtilisateur->adm_afficherModifierUn($oUtilisateur, $sMsg);
				}else{
					throw new Exception('Erreur - Ce Utilisateur n\'existe pas.  : ' . $_GET['idUtilisateur']);
				}
			}else{
				$oUtilisateur = new Utilisateur($_POST['idUtilisateur']);
				if($oUtilisateur->rechercherUn($this->oPDOLib) == true){
					//Affecter
					$oUtilisateur = new Utilisateur($_POST['idUtilisateur'],$_POST['sLoginUtilisateur'],$_POST['sPwdUtilisateur'],$_POST['iNoEtudiant']);
					//Sauvegarder
					if($oUtilisateur->modifier($this->oPDOLib) !== false){
						$sMsg ='La modification de  - '.$oUtilisateur->getsLoginUtilisateur().' - s\'est déroulée avec succès.';
						//Affichage
						//$this->adm_gererAfficherTousUtilisateur($sMsg); //sans AJAX
						echo $sMsg; //avec AJAX
					}else {
						throw new Exception('Une erreur est survenue durant la modification de  : ' . $oUtilisateur->getsLoginUtilisateur());
					}
				}else{
					throw new Exception('Erreur - Ce Utilisateur n\'existe pas.  : ' . $_POST['idUtilisateur']);
				}


			}

		}catch(Exception $oException){
			/*
			$oVueUtilisateur = new VueUtilisateur();
			$oUtilisateur = new Utilisateur($_GET['idUtilisateur']);

			$oUtilisateur->rechercherUn($this->oPDOLib);
			$oVueUtilisateur->adm_afficherModifierUn($oUtilisateur, $oException->getMessage());
			*/
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère l'affichage du formulaire d'ajout ainsi que la sauvegarde dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererAjouterUtilisateur(){
			try{
			$oVueUtilisateur = new VueUtilisateur();
			$oUtilisateur = new Utilisateur();
			$sMsg='';
			if(isset($_POST['cmd']) == false){
				//Affichage
				$oVueUtilisateur->adm_afficherAjouterUn();

			}else{
				//Affecter
				$oUtilisateur = new Utilisateur(1, $_POST['sLoginUtilisateur'],$_POST['sPwdUtilisateur'],$_POST['iNoEtudiant']);

				//Sauvegarder
				if($oUtilisateur->ajouter($this->oPDOLib) !== false){
					$sMsg ='L\'ajout de  - '.$oUtilisateur->getsLoginUtilisateur().' - s\'est déroulé avec succès.';
					//Affichage
					//$oVueUtilisateur->adm_afficherAjouterUn($sMsg); //Sans AJAX
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant l\'ajout de  : ' . $oUtilisateur->getsLoginUtilisateur());
				}
			}

		}catch(Exception $oException){
			/*
			$oVueUtilisateur = new VueUtilisateur();
			$oVueUtilisateur->adm_afficherAjouterUn($oException->getMessage());
			*/
			echo $oException->getMessage(); //avec AJAX
		}
		}//fin de la fonction

	/**
	  * Gère la suppression dans la bdd
	  * @param void
	  * @return void
	  */
	public function adm_gererSupprimerUtilisateur(){
			try{
			$oVueUtilisateur = new VueUtilisateur();
			$oUtilisateur = new Utilisateur();
			$sMsg='';


			//Affecter
			$oUtilisateur = new Utilisateur($_POST['idUtilisateur']);
			if($oUtilisateur->rechercherUn($this->oPDOLib) == true){
				//Supprimer
				if($oUtilisateur->supprimer($this->oPDOLib) !== false){
					$sMsg ='La suppression de  - '.$oUtilisateur->getsLoginUtilisateur().' - s\'est déroulée avec succès.';
					//Affichage
					//$this->adm_gererAfficherTousUtilisateur($sMsg);
					echo $sMsg; //avec AJAX
				}else {
					throw new Exception('Une erreur est survenue durant la suppression de  : ' . $oUtilisateur->getsLoginUtilisateur());
				}
			}else{
				throw new Exception('Erreur - Ce Utilisateur n\'existe pas.  : ' . $_POST['idUtilisateur']);
			}


		}catch(Exception $oException){
			//$this->adm_gererAfficherTousUtilisateur($oException->getMessage());
			echo $oException->getMessage(); //avec AJAX
		}
}//fin de la fonction

    /**
     *
     * @return void
     */
    public function adm_afficherRecette(){
        try{

            $oRecette = new Recette();
            $aListe = $oRecette->rechercherInfoRecettes($this->oPDOLib);

            return($aListe);

        }catch(Exception $oException){
            echo "<p>".$oException->getMessage()."</p>";
        }
    }

/**
 *
 * @return void
 */
public function connectionUtilisateur($idEtudiant, $pwdEtudiant, $idPartner){
	try{

		$oUtilisateur = new Utilisateur();
		$oUtilisateur->setiNoEtudiant($idEtudiant);
		$bEtudiant = $oUtilisateur->rechercherUnParNumeroEtudiantCustom($this->oPDOLib);

		if ($idPartner != -1) {
			$oCoequipier = new Utilisateur();
			$oCoequipier->setiNoEtudiant($idPartner);
			$bCoequipier = $oCoequipier->rechercherUnParNumeroEtudiantCustom($this->oPDOLib);
			if ($bCoequipier != false) {
				$bCoequipierId = $bCoequipier['iNoEtudiant'];
			} else {
				return("4"); // Mauvais id de coéquipier
			}

		} else {
			$bCoequipierId = -1; // Pas de coéquipier
		}



		if ($bEtudiant != false) {


			$oEtudiant = new Etudiant($idEtudiant);
			$oEtudiantInfo = $oEtudiant->rechercherUnCustom($this->oPDOLib);

			if ($idPartner != -1) {
				$oEtudiantCoequipier = new Etudiant($idPartner);
				$oEtudiantCoequipierInfo = $oEtudiantCoequipier->rechercherUnCustom($this->oPDOLib);
				$prenomEtudiantCoequipier = $oEtudiantCoequipierInfo['sPrenomEtudiant'];
				$nomEtudiantCoequipier = $oEtudiantCoequipierInfo['sNomEtudiant'];
				$coequipier = $bCoequipierId;
			}

			$prenomEtudiant = $oEtudiantInfo['sPrenomEtudiant'];
			$nomEtudiant = $oEtudiantInfo['sNomEtudiant'];
			$id = $bEtudiant['iNoEtudiant'];
			$pwd = $bEtudiant['sPwdUtilisateur'];


			if ($idEtudiant == $id && $pwdEtudiant == $pwd) {
				if ($idPartner != -1) {
					$infoSession = [$prenomEtudiant, $nomEtudiant, $id, $pwd, $prenomEtudiantCoequipier, $nomEtudiantCoequipier, $coequipier];
					return ($infoSession); // Success
				} else {
					$infoSession = [$prenomEtudiant, $nomEtudiant, $id, $pwd, -1, -1, -1];
					return ($infoSession); // Success
				}

			} else {
				return("2"); // Mauvais mot de passe
			}
		} else {
			return("3"); //Mauvais ID/Erreur dans le decodage/trouver l'étudiant dans base de donnée
		}



	}catch(Exception $oException){
		echo "<p>".$oException->getMessage()."</p>";
	}
}

/**
 *
 * @return void
 */
public function adm_afficherRecetteModifie(){
	try{

		$oEtudiants_recettes_ingredient = new Etudiants_recettes_ingredient();
		$aListe = $oEtudiants_recettes_ingredient->chercherLesRecettesModifierAAfficher($this->oPDOLib);

		return($aListe);

	}catch(Exception $oException){
		echo "<p>".$oException->getMessage()."</p>";
	}
}

public function insertNewRecette($idRecette, $sNomRecette, $ingredients, $idEtudiant, $sprenomEtudiant, $sNomEtudiant, $idCoequipier, $sPrenomCoequipier, $sNomCoequipier) {
	try{

		for ($i = 0; $i < count($ingredients); $i++) {
			$oEtudiants_recettes_ingredient = new Etudiants_recettes_ingredient($idEtudiant, 2, $idRecette, $ingredients[$i]['idIngredient'], $ingredients[$i]['marque'], 1, 1);

			//Étudiant
			$oEtudiant = $oEtudiants_recettes_ingredient->getoEtudiant()->rechercherUnCustomTwo($this->oPDOLib);
			$oEtudiants_recettes_ingredient->setoEtudiant($oEtudiant);

			//Coéquipier
			$oCoequipier = new Etudiant($idCoequipier);
			$oEtudiant = $oCoequipier->rechercherUnCustomTwo($this->oPDOLib);
			$oEtudiants_recettes_ingredient->setoCoequipier($oEtudiant);

			//Groupe
			$oGroupe = $oEtudiants_recettes_ingredient->getoGroupe()->rechercherUnCustom($this->oPDOLib);
			$oEtudiants_recettes_ingredient->setoGroupe($oGroupe);

			//Recette
			$oRecette = $oEtudiants_recettes_ingredient->getoRecette()->rechercherUnCustom($this->oPDOLib);
			$oEtudiants_recettes_ingredient->setoRecette($oRecette);

			//Ingredient
			$oIngredient = $oEtudiants_recettes_ingredient->getoIngredient()->rechercherUnCustom($this->oPDOLib);
			$oEtudiants_recettes_ingredient->setoIngredient($oIngredient);

			//Marque
			$oMarque = $oEtudiants_recettes_ingredient->getoMarque()->rechercherUnCustom($this->oPDOLib);
			$oEtudiants_recettes_ingredient->setoMarque($oMarque);

			$response = $oEtudiants_recettes_ingredient->ajouterCustom($this->oPDOLib);

			var_dump($response);
		}

	}catch(Exception $oException){
		echo "<p>".$oException->getMessage()."</p>";
	}
}

public function insertNewRecetteAllergene($idRecette, $sNomRecette, $ingredients, $idEtudiant, $sprenomEtudiant, $sNomEtudiant, $idCoequipier, $sPrenomCoequipier, $sNomCoequipier) {
	try{

		for ($i = 0; $i < count($ingredients); $i++) {

			if (isset($ingredients[$i]['allergenes'])) {
				if (count($ingredients[$i]['allergenes']) > 0) {
					for ($p = 0; $p < count($ingredients[$i]['allergenes']); $p++) {
						$oEtudiants_recettes_ingredients_allergene = new Etudiants_recettes_ingredients_allergene($idEtudiant, 2, $idRecette, $ingredients[$i]['idIngredient'], $ingredients[$i]['marque'], $ingredients[$i]['allergenes'][$p], 1);

						//Étudiant
						$oEtudiant = $oEtudiants_recettes_ingredients_allergene->getoEtudiant()->rechercherUnCustomTwo($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoEtudiant($oEtudiant);

						//Coéquipier
						$oCoequipier = new Etudiant($idCoequipier);
						$oEtudiant = $oCoequipier->rechercherUnCustomTwo($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoCoequipier($oEtudiant);

						//Groupe
						$oGroupe = $oEtudiants_recettes_ingredients_allergene->getoGroupe()->rechercherUnCustom($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoGroupe($oGroupe);

						//Recette
						$oRecette = $oEtudiants_recettes_ingredients_allergene->getoRecette()->rechercherUnCustom($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoRecette($oRecette);

						//Ingredient
						$oIngredient = $oEtudiants_recettes_ingredients_allergene->getoIngredient()->rechercherUnCustom($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoIngredient($oIngredient);

						//Marque
						$oMarque = $oEtudiants_recettes_ingredients_allergene->getoMarque()->rechercherUnCustom($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoMarque($oMarque);

						//Allergene
						$oAllergene = $oEtudiants_recettes_ingredients_allergene->getoAllergene()->rechercherUnCustom($this->oPDOLib);
						$oEtudiants_recettes_ingredients_allergene->setoAllergene($oAllergene);

						$response = $oEtudiants_recettes_ingredients_allergene->ajouterUnCustom($this->oPDOLib);

						var_dump($response);
					}
				}
			}
		}

	}catch(Exception $oException){
		echo "<p>".$oException->getMessage()."</p>";
	}
}



}//fin de la classe Controleur
