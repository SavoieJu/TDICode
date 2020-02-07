<?php
/**
 * Fichier Etudiants_recettes_ingredients_allergene.class.php
 * Gestion des allergènes
 * @author Caroline Martin
 * @version Friday 4th of October 2019 03:38:43 PM
 */
class Etudiants_recettes_ingredients_allergene {
	private $oEtudiant = NULL;
	private $oCoequipier = NULL;
	private $oGroupe = NULL;
	private $oRecette = NULL;
	private $oIngredient = NULL;
	private $oMarque = NULL;
	private $oAllergene= NULL;


	private $aoIngredients = array();

	private $bFinalise;



    /**
    * constructeur
	* @param integer $idEtudiant
	* @param integer $idGroupe
	* @param integer $idRecette
	* @param integer $idIngredient
	* @param integer $idMarque
	* @param integer $idAllergene
	* @param integer $bFinalise
	* @return void
    */
    public function __construct($idEtudiant=1,$idGroupe=1,$idRecette=1,$idIngredient=1,$idMarque=1,$idAllergene=1,$bFinalise=1){
			$this->setoEtudiant(new Etudiant($idEtudiant));
			$this->setoGroupe(new Groupe($idGroupe));
			$this->setoRecette(new Recette($idRecette));
			$this->setoIngredient(new Ingredient($idIngredient));
			$this->setoMarque(new Marque($idMarque));
			$this->setoAllergene(new Allergene($idAllergene));

			$this->setbFinalise($bFinalise);

    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param Etudiant $oEtudiant
    * @return void
    */
    public function setoEtudiant(Etudiant $oEtudiant){
    	$this->oEtudiant = $oEtudiant;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Etudiant
    */
    public function getoEtudiant(){
    	return $this->oEtudiant;
    }//fin de la fonction

	/**
    * affecte la valeur du paramètre a la propriété privée
    * @param Etudiant $oEtudiant
    * @return void
    */
    public function setoCoequipier(Etudiant $oCoequipier){
    	$this->oCoequipier = $oCoequipier;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Etudiant
    */
    public function getoCoequipier(){
    	return $this->oCoequipier;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param Groupe $oGroupe
    * @return void
    */
    public function setoGroupe(Groupe $oGroupe){
    	$this->oGroupe = $oGroupe;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Groupe
    */
    public function getoGroupe(){
    	return $this->oGroupe;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param Recette $oRecette
    * @return void
    */
    public function setoRecette(Recette $oRecette){
    	$this->oRecette = $oRecette;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Recette
    */
    public function getoRecette(){
    	return $this->oRecette;
    }//fin de la fonction


    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param Ingredient $oIngredient
    * @return void
    */
    public function setoIngredient(Ingredient $oIngredient){
    	$this->oIngredient = $oIngredient;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Ingredient
    */
    public function getoIngredient(){
    	return $this->oIngredient;
    }//fin de la fonction
	/**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  array
    */
    public function getaoIngredients(){
    	return $this->aoIngredients;
    }//fin de la fonction
    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param Marque $oMarque
    * @return void
    */
    public function setoMarque(Marque $oMarque){
    	$this->oMarque = $oMarque;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Marque
    */
    public function getoMarque(){
    	return $this->oMarque;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param Allergene $oAllergene
    * @return void
    */
    public function setoAllergene(Allergene $oAllergene){
    	$this->oAllergene = $oAllergene;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Allergene
    */
    public function getoAllergene(){
    	return $this->oAllergene;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $bFinalise
    * @return void
    */
    public function setbFinalise($bFinalise){
    	TypeException::estNumerique($bFinalise);
    	$this->bFinalise = $bFinalise;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  integer
    */
    public function getbFinalise(){
    	return $this->bFinalise;
    }//fin de la fonction

    /**
    * ajoute un enregistrement dans la table "etudiants_recettes_ingredients_allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouterUn(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete="
			INSERT etudiants_recettes_ingredients_allergenes
			(idGroupe,idRecette,idIngredient,idMarque,idAllergene,bFinalise)
			VALUES(:idGroupe,:idRecette,:idIngredient,:idMarque,:idAllergene,:bFinalise)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getoGroupe()->getidGroupe(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", $this->getoRecette()->getidRecette(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idAllergene", $this->getoAllergene()->getidAllergene(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":bFinalise", $this->getbFinalise(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){

			return true;
		}
		return false;

    }//fin de la fonction

    /**
    * ajoute plusieurs enregistrements dans la table "etudiants_recettes_ingredients_allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouterPlusieurs(PDOLib $oPDOLib){
		//Réaliser la requête
		$iMaxIngredients = count($this->aoIngredients);
		for($i=0; $i < $iMaxIngredients; $i++){
			if($i == 0){
				$sRequete = "
				INSERT etudiants_recettes_ingredients_allergenes
				(idGroupe,idRecette,idIngredient,idMarque,idAllergene,bFinalise)
				VALUES(:idGroupe,:idRecette,:idIngredient_".$i.",:idMarque_".$i.",:idAllergene_".$i.",:bFinalise)";
			}else{
				$sRequete .= ",(:idGroupe,:idRecette,:idIngredient_".$i.",:idMarque_".$i.",:idAllergene_".$i.",:bFinalise)";
			}

		}

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getoGroupe()->getidGroupe(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", $this->getoRecette()->getidRecette(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":bFinalise", $this->getbFinalise(), PDO::PARAM_INT);

		$aoIngredients = $this->aoIngredients;
		for($i=0; $i < $iMaxIngredients; $i++){
			$oPDOStatement->bindValue(":idIngredient_".$i, $aoIngredients[$i][0]->getidIngredient(), PDO::PARAM_INT);
			$oPDOStatement->bindValue(":idMarque_".$i, $aoIngredients[$i][1]->getidMarque(), PDO::PARAM_INT);
			$oPDOStatement->bindValue(":idAllergene_".$i, $aoIngredients[$i][2]->getidAllergene(), PDO::PARAM_INT);

		}
		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){

			return true;
		}
		return false;

    }//fin de la fonction

    /**
    * supprime un enregistrement dans la table "etudiants_recettes_ingredients_allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement supprimé) ou un boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete="
			DELETE FROM etudiants_recettes_ingredients_allergenes
			WHERE idEtudiant = :idEtudiant
			AND idGroupe = :idGroupe
			AND idRecette = :idRecette
			AND idIngredient = :idIngredient
			AND idAllergene = :idAllergene
			";


		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getoGroupe()->getidGroupe(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", $this->getoRecette()->getidRecette(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idAllergene", $this->getoAllergene()->getidAllergene(), PDO::PARAM_INT);


		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction



    /**
    * rechercher tous les enregistrements dans la table "etudiants_recettes_ingredients_allergenes"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTousLesAllergenesDeUneRecetteModifieeJSON(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT
			ingredients.idIngredient, ingredients.sNomIngredient,
			marques.idMarque, marques.sNomMarque,
			allergenes.idAllergene

			FROM etudiants_recettes_ingredients_allergenes
			LEFT JOIN etudiants ON etudiants.idEtudiant=etudiants_recettes_ingredients_allergenes.idEtudiant
			LEFT JOIN etudiants as coequipiers ON coequipiers.idEtudiant=etudiants.idCoEquipier
			LEFT JOIN groupes ON groupes.idGroupe=etudiants_recettes_ingredients_allergenes.idGroupe
			LEFT JOIN recettes ON recettes.idRecette=etudiants_recettes_ingredients_allergenes.idRecette
			LEFT JOIN ingredients ON ingredients.idIngredient=etudiants_recettes_ingredients_allergenes.idIngredient
			LEFT JOIN marques ON etudiants_recettes_ingredients_allergenes.idMarque=marques.idMarque
			LEFT JOIN allergenes ON etudiants_recettes_ingredients_allergenes.idAllergene=allergenes.idAllergene


			WHERE etudiants_recettes_ingredients_allergenes.idRecette= :idRecette
			AND etudiants_recettes_ingredients_allergenes.idEtudiant = :idEtudiant
			AND etudiants_recettes_ingredients_allergenes.idGroupe = :idGroupe

			ORDER BY  ingredients.idIngredient, allergenes.idAllergene
			";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getoGroupe()->getidGroupe(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idEtudiant", $this->getoEtudiant()->getidEtudiant(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", $this->getoRecette()->getidRecette(), PDO::PARAM_INT);


		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer le array
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
			$iMax = count($aEnregs);
			for($i=0; $i < $iMax;  $i++ ){
				$aEnregs[$i]['bTraite']=0;
			}

			return json_encode($aEnregs);
		}
		return false;

    }//fin de la fonction


    public function rechercherTousLesAllergenesDeTousLesIngredientsDeUneRecetteModifiee(PDOLib $oPDOLib){

        $sRequete ="
        SELECT etudiants.idEtudiant, etudiants.sNomEtudiant, etudiants.sPrenomEtudiant, etudiants.idCoEquipier,
			coequipiers.idEtudiant as idEquipier, coequipiers.sNomEtudiant as sNomCoequipier, coequipiers.sPrenomEtudiant as sPrenomCoequipier,
			groupes.idGroupe, sNomGroupe, dateGroupe,
			recettes.idRecette, sNomRecette, sCategorie, recettes.idPortion, sDescRecette,
			ingredients.idIngredient, sNomIngredient,
			marques.idMarque, sNomMarque,
			allergenes.idAllergene, sNomAllergene

        FROM etudiants_recettes_ingredients
        INNER JOIN etudiants ON etudiants.idEtudiant=etudiants_recettes_ingredients.idEtudiant
		INNER JOIN etudiants as coequipiers ON coequipiers.idEtudiant=etudiants.idCoEquipier
		INNER JOIN groupes ON groupes.idGroupe=etudiants_recettes_ingredients.idGroupe
		INNER JOIN recettes ON recettes.idRecette=etudiants_recettes_ingredients.idRecette
        INNER JOIN ingredients on ingredients.idIngredient = etudiants_recettes_ingredients.idIngredient
        INNER JOIN ingredients_marques_allergenes ON ingredients_marques_allergenes.idIngredient = etudiants_recettes_ingredients.idIngredient
        INNER JOIN allergenes ON allergenes.idAllergene = ingredients_marques_allergenes.idAllergene
        INNER JOIN marques ON marques.idMarque=etudiants_recettes_ingredients.idMarque
        WHERE etudiants_recettes_ingredients.idRecette= :idRecette
        AND etudiants_recettes_ingredients.idEtudiant = :idEtudiant
		AND etudiants_recettes_ingredients.idGroupe = :idGroupe
        ORDER BY ingredients.idIngredient, allergenes.idAllergene
        ";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getoGroupe()->getidGroupe(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idEtudiant", $this->getoEtudiant()->getidEtudiant(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", $this->getoRecette()->getidRecette(), PDO::PARAM_INT);

        //Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){

			//Récupérer le array
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
			$iMax = count($aEnregs);

			$aoEnregs = array();
			if($iMax > 0){
				for($iEnreg=0;$iEnreg<$iMax;$iEnreg++){
					if($iEnreg==0){
						$this->setoGroupe(new Groupe($aEnregs[$iEnreg]['idGroupe'], $aEnregs[$iEnreg]['sNomGroupe'], $aEnregs[$iEnreg]['dateGroupe']));
						$this->setoEtudiant(new Etudiant($aEnregs[$iEnreg]['idEtudiant'], $aEnregs[$iEnreg]['sNomEtudiant'], $aEnregs[$iEnreg]['sPrenomEtudiant']));

						$this->setoCoequipier(new Etudiant($aEnregs[$iEnreg]['idEquipier'], $aEnregs[$iEnreg]['sNomCoequipier'], $aEnregs[$iEnreg]['sPrenomCoequipier']));



						$this->setoRecette(new Recette($aEnregs[$iEnreg]['idRecette'], $aEnregs[$iEnreg]['sNomRecette'],
						$aEnregs[$iEnreg]['sDescRecette']
						));
					}
					$this->aoIngredients[$iEnreg][0] = new Ingredient($aEnregs[$iEnreg]['idIngredient'], $aEnregs[$iEnreg]['sNomIngredient']) ;
					$this->aoIngredients[$iEnreg][1] = new Marque($aEnregs[$iEnreg]['idMarque'], $aEnregs[$iEnreg]['sNomMarque']) ;
					$this->aoIngredients[$iEnreg][2] = new Allergene($aEnregs[$iEnreg]['idAllergene'], $aEnregs[$iEnreg]['sNomAllergene']) ;
				}
				return true;
			}
			return false;
		}
    }//fin de la fonction

		/**
    * ajoute un enregistrement dans la table "etudiants_recettes_ingredients_allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouterUnCustom(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete="
			INSERT INTO etudiants_recettes_ingredients_allergenes (idEtudiant,idGroupe,idRecette,idIngredient,idMarque,idAllergene,bFinalise) VALUES (:idEtudiant,:idGroupe,:idRecette,:idIngredient,:idMarque,:idAllergene,:bFinalise)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idEtudiant", (int)$this->getoEtudiant()->getidEtudiant(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idGroupe", (int)$this->getoGroupe()->getidGroupe(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", (int)$this->getoRecette()->getidRecette(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idIngredient", (int)$this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", (int)$this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idAllergene", (int)$this->getoAllergene()->getidAllergene(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":bFinalise", (int)$this->getbFinalise(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){

			return true;
		}
		return false;

    }//fin de la fonction


}//fin de la classe Etudiants_recettes_ingredients_allergene
