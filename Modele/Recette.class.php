<?php
/**
 * Fichier Recette.class.php
 * Examens de TDI
 * @author Caroline Martin
 * @version Friday 5th of April 2019 08:44:28 AM
 */
class Recette {
	private $idRecette;
	private $sNomRecette;
	private $sDescRecette;
    private $sTempsCuisson;
	private $sTemperatureCuisson;
	private $aCategories = array(1=>'Soupe','Plat principal','Féculent','Légume','Dessert');
	private $sCategorie;
	private $bVisible;
	private $oPortion = NULL;

    /**
    * constructeur
	* @param integer $idRecette
	* @param string $sNomRecette
	* @param string $sDescRecette
	* @return void
    */
    public function __construct($idRecette=1,$sNomRecette="",$sDescRecette="", $sTempsCuisson="", $sTemperatureCuisson="", $idPortion=1){
			$this->setidRecette($idRecette);
			$this->setsNomRecette($sNomRecette);
			$this->setsDescRecette($sDescRecette);
            $this->setsTempsCuisson($sTempsCuisson);
            $this->setsTemperatureCuisson($sTemperatureCuisson);
    		$this->setoPortion(new Portion($idPortion));
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $idRecette
    * @return void
    */
    public function setidRecette($idRecette){
    	TypeException::estNumerique($idRecette);
    	$this->idRecette = $idRecette;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  integer
    */
    public function getidRecette(){
    	return $this->idRecette;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sNomRecette
    * @return void
    */
    public function setsNomRecette($sNomRecette){
    	TypeException::estChaineDeCaracteres($sNomRecette);
    	$this->sNomRecette = $sNomRecette;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsNomRecette(){
    	return $this->sNomRecette;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sDescRecette
    * @return void
    */
    public function setsDescRecette($sDescRecette){
    	TypeException::estChaineDeCaracteres($sDescRecette);
    	$this->sDescRecette = $sDescRecette;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsDescRecette(){
    	return $this->sDescRecette;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sTempsCuisson
    * @return void
    */
    public function setsTempsCuisson($sTempsCuisson){
    	TypeException::estChaineDeCaracteres($sTempsCuisson);
    	$this->sTempsCuisson = $sTempsCuisson;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsTempsCuisson(){
    	return $this->sTempsCuisson;
    }//fin de la fonction
    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sTemperatureCuisson
    * @return void
    */
    public function setsTemperatureCuisson($sTemperatureCuisson){
    	TypeException::estChaineDeCaracteres($sTemperatureCuisson);
    	$this->sTemperatureCuisson = $sTemperatureCuisson;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsTemperatureCuisson(){
    	return $this->sTemperatureCuisson;
    }//fin de la fonction


	/**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $iCategorie
    * @return void
    */
    public function setiCategorie($iCategorie){
    	TypeException::estNumerique($iCategorie);
    	$this->sCategorie = $this->aCategories[$iCategorie];
    }//fin de la fonction

	/**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sCategorie
    * @return void
    */
    public function setsCategorie($sCategorie){
    	TypeException::estChaineDeCaracteres($sCategorie);
    	$this->sCategorie = $sCategorie;
    }//fin de la fonction
	/**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsCategorie(){
    	return $this->sCategorie;
    }//fin de la fonction
	/**
    * retourne la valeur de la propriété privée
    * @param integer $iCategorie
    * @return  string
    */
    public function getsaCategorie($iCategorie){
    	return $this->aCategories[$iCategorie];
    }//fin de la fonction

	/**
    * affecte la valeur du paramètre a la propriété privée
    * @param boolean $bVisible
    * @return void
    */
    public function setbVisible($bVisible){
    	TypeException::estBooleen($bVisible);
    	$this->bVisible = $bVisible;
    }//fin de la fonction

	/**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  boolean
    */
    public function getbVisible(){
    	return $this->bVisible;
    }//fin de la fonction

	/**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  array
    */
    public function getaCategories(){
    	return $this->aCategories;
    }//fin de la fonction

	/**
    * affecte la valeur du paramètre a la propriété privée
    * @param Portion $oPortion
    * @return void
    */
    public function setoPortion(Portion $oPortion){
    	$this->oPortion = $oPortion;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  Portion
    */
    public function getoPortion(){
    	return $this->oPortion;
    }//fin de la fonction

    /**
    * ajoute un enregistrement dans la table "recettes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouter(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete="
			INSERT recettes
			(sNomRecette,sDescRecette, sTempsCuisson, sTemperatureCuisson, idPortion, sCategorie)
			VALUES(:sNomRecette,:sDescRecette, :sTempsCuisson, :sTemperatureCuisson, :idPortion, :sCategorie)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":sNomRecette", $this->getsNomRecette(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":sDescRecette", $this->getsDescRecette(), PDO::PARAM_STR);
        $oPDOStatement->bindValue(":sTempsCuisson", $this->getsTempsCuisson(), PDO::PARAM_STR);
        $oPDOStatement->bindValue(":sTemperatureCuisson", $this->getsTemperatureCuisson(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":idPortion", $this->getoPortion()->getidPortion(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":sCategorie", $this->getsCategorie(), PDO::PARAM_STR);

		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){
			$this->idRecette = (int)$oPDOLib->getoPDO()->lastInsertId();
			return $this->idRecette;
		}
		return false;

    }//fin de la fonction

    /**
    * modifie un enregistrement dans la table "recettes"
     * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function modifier(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			UPDATE recettes
			SET sNomRecette = :sNomRecette,
				sDescRecette = :sDescRecette,
				sTempsCuisson = :sTempsCuisson,
				sTemperatureCuisson = :sTemperatureCuisson,
				sCategorie = :sCategorie

			WHERE idRecette= :idRecette";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs

		$oPDOStatement->bindValue(":sNomRecette", $this->getsNomRecette(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":sDescRecette", $this->getsDescRecette(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":idRecette", $this->getidRecette(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":sTempsCuisson", $this->getsTempsCuisson(), PDO::PARAM_STR);
        $oPDOStatement->bindValue(":sTemperatureCuisson", $this->getsTemperatureCuisson(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":sCategorie", $this->getsCategorie(), PDO::PARAM_STR);

		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){

			return (int)$oPDOStatement->rowCount();
		}

		return false;

    }//fin de la fonction


	/**
    * modifie un enregistrement dans la table "recettes"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function rendreAccessible(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete="
			UPDATE recettes
			SET bVisible = :bVisible
			WHERE idRecette= :idRecette";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs

		$oPDOStatement->bindValue(":bVisible", $this->getbVisible(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idRecette", $this->getidRecette(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){

			return (int)$oPDOStatement->rowCount();
		}

		return false;

    }//fin de la fonction

    /**
    * supprime un enregistrement dans la table "recettes" et toutes les tables associées à la recette soit :
	* - portions
	* - poids
	* - mesures
	* - recettes_ingredients
    * @param PDOLib $oPDOLib
    * @return boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){

    	$oRI = new Recettes_ingredient($this->getidRecette());

		//Supprimer les poids/mesures et ingredients associés à la recette
		$bRI = $oRI->supprimer($oPDOLib);
		if($bRI == false){
			return false;
		}
		//Supprimer la portion associée à la recette
		$bPortion = $this->getoPortion()->supprimer($oPDOLib);
		if($bPortion == false){
			return false;
		}

		//Supprimer la recette
		//Réaliser la requête
		$sRequete="
			DELETE FROM recettes
			WHERE idRecette= :idRecette";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idRecette", $this->getidRecette(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());

		return $b;

    }//fin de la fonction

    /**
    * rechercher un enregistrement dans la table "recettes"
     * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUn(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM recettes
			INNER JOIN portions ON portions.idPortion = recettes.idPortion
			WHERE idRecette= :idRecette";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idRecette", $this->getidRecette(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idRecette'],$aEnregs['sNomRecette'],$aEnregs['sDescRecette'],$aEnregs['sTempsCuisson'], $aEnregs['sTemperatureCuisson']);
				$this->setsCategorie($aEnregs['sCategorie']);
				$this->setbVisible($aEnregs['bVisible']);
				$this->setoPortion(new Portion($aEnregs['idPortion'], $aEnregs['iNbPortions'], $aEnregs['sGrosseurPortion'], $aEnregs['sEnergiePortion'], $aEnregs['sGlucides'], $aEnregs['sProteines'], $aEnregs['sLipides'], $aEnregs['sFibres'], $aEnregs['sSodium']));

				return true;
			}
		}

		return false;

    }//fin de la fonction

    /**
    * rechercher tous les enregistrements dans la table "recettes"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTous(PDOLib $oPDOLib, $bRechJS=false){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM recettes
			INNER JOIN portions ON portions.idPortion = recettes.idPortion
			ORDER BY sCategorie
			";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		//void

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer le array
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
			if($bRechJS==true){
				return json_encode($aEnregs);
			}
			$iMax = count($aEnregs);
			$aoEnregs = array();
			if($iMax > 0){
				for($iEnreg=0;$iEnreg<$iMax;$iEnreg++){
					$aoEnregs[$iEnreg] = new Recette(

						$aEnregs[$iEnreg]['idRecette'],$aEnregs[$iEnreg]['sNomRecette'],$aEnregs[$iEnreg]['sDescRecette'], $aEnregs[$iEnreg]['sTempsCuisson'], $aEnregs[$iEnreg]['sTemperatureCuisson']
					);
				$aoEnregs[$iEnreg]->setsCategorie($aEnregs[$iEnreg]['sCategorie']);
				$aoEnregs[$iEnreg]->setbVisible($aEnregs[$iEnreg]['bVisible']);

				$aoEnregs[$iEnreg]->setoPortion(new Portion($aEnregs[$iEnreg]['idPortion'], $aEnregs[$iEnreg]['iNbPortions'], $aEnregs[$iEnreg]['sGrosseurPortion'], $aEnregs[$iEnreg]['sEnergiePortion'], $aEnregs[$iEnreg]['sGlucides'], $aEnregs[$iEnreg]['sProteines'], $aEnregs[$iEnreg]['sLipides'], $aEnregs[$iEnreg]['sFibres'], $aEnregs[$iEnreg]['sSodium']));

				}
				//Retourner le array d'objets de la classe Recette
				return $aoEnregs;
			}
		}
		return false;

    }//fin de la fonction

	/**
    * rechercher tous les enregistrements dans la table "recettes" qui sont accessibles pour les étudiants
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */

    public function rechercherTousAccessibles(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete="
			SELECT *
			FROM recettes
			INNER JOIN portions ON portions.idPortion = recettes.idPortion
			WHERE bVisible = 1
			ORDER BY sCategorie
			";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		//void

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer le array
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);

			$iMax = count($aEnregs);
			$aoEnregs = array();
			if($iMax > 0){
				for($iEnreg=0;$iEnreg<$iMax;$iEnreg++){
					$aoEnregs[$iEnreg] = new Recette(

						$aEnregs[$iEnreg]['idRecette'],$aEnregs[$iEnreg]['sNomRecette'],$aEnregs[$iEnreg]['sDescRecette'], $aEnregs[$iEnreg]['sTempsCuisson'], $aEnregs[$iEnreg]['sTemperatureCuisson']
					);
				$aoEnregs[$iEnreg]->setsCategorie($aEnregs[$iEnreg]['sCategorie']);
				$aoEnregs[$iEnreg]->setbVisible($aEnregs[$iEnreg]['bVisible']);
				$aoEnregs[$iEnreg]->setoPortion(new Portion($aEnregs[$iEnreg]['idPortion'], $aEnregs[$iEnreg]['iNbPortions'], $aEnregs[$iEnreg]['sGrosseurPortion'], $aEnregs[$iEnreg]['sEnergiePortion'], $aEnregs[$iEnreg]['sGlucides'], $aEnregs[$iEnreg]['sProteines'], $aEnregs[$iEnreg]['sLipides'], $aEnregs[$iEnreg]['sFibres'], $aEnregs[$iEnreg]['sSodium']));

				}
				//Retourner le array d'objets de la classe Recette
				return $aoEnregs;
			}
		}
		return false;

    }//fin de la fonction

	/**
    * rechercher un enregistrement dans la table "recettes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUneRecetteParPortion(PDOLib $oPDOLib){
		//Réaliser la requête
		$sRequete = "
			SELECT *
			FROM recettes
			WHERE recettes.idPortion = :idPortion
			";
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idPortion", $this->getoPortion()->getidPortion(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idRecette'],$aEnregs['sNomRecette']);
				return true;
			}
		}
		return false;


	}//fin de la fonction

    /**
     * Recherche les information pour la selection de recette dans exercice recettes
     * @param PDOLib $oPDOLib
     * @return boolean (true si trouvé, false dans les autres cas)
     */
    public function rechercherInfoRecettes(PDOLib $oPDOLib){
        //Réaliser la requête
        $sRequete = "
			SELECT recettes.idRecette, sNomRecette, sNomMarque, ingredients.sNomIngredient, recettes_ingredients.idIngredient, marques.idMarque,poids.fPoidsA,poids.sUnitePoids , mesures.iMesure,mesures.sUnite
			FROM `recettes`
			INNER JOIN recettes_ingredients ON recettes_ingredients.idRecette = recettes.idRecette
			INNER JOIN ingredients ON ingredients.idIngredient = recettes_ingredients.idIngredient
			INNER JOIN marques ON marques.idMarque = recettes_ingredients.idMarque
            LEFT JOIN poids ON recettes_ingredients.idPoids = poids.idPoids
            LEFT JOIN mesures ON recettes_ingredients.idMesure = mesures.idMesure
			WHERE bVisible = 1
			ORDER BY recettes.idRecette
			";
        //Préparer la requête
        $oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

        //Lier les paramètres aux valeurs
        // $oPDOStatement->bindValue(":idPortion", $this->getoPortion()->getidPortion(), PDO::PARAM_INT);

        //Exécuter la requête
        $b = $oPDOStatement->execute();

        //Si la requête a bien été exécutée
        if($b == true){
            //Récupérer l'enregistrement (fetch)
            $aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);

            $iMax = count($aEnregs);
            $aoEnregs = array();
            if($iMax > 0){
                for($iEnreg=0;$iEnreg<$iMax;$iEnreg++) {
                    if (array_key_exists($aEnregs[$iEnreg]['idRecette'], $aoEnregs)) {
                        $aIngredients = array();

                        $aIngredients['sNomIngredient'] = $aEnregs[$iEnreg]['sNomIngredient'];
                        $aIngredients['idIngredient'] = $aEnregs[$iEnreg]['idIngredient'];
                        $aIngredients['sNomMarque'] = $aEnregs[$iEnreg]['sNomMarque'];
                        $aIngredients['idMarque'] = $aEnregs[$iEnreg]['idMarque'];
                        if($aEnregs[$iEnreg]['sUnitePoids'] !=NULL){
                            $aIngredients['iQuantite'] = $aEnregs[$iEnreg]['fPoidsA'];
                            $aIngredients['iMesure'] = $aEnregs[$iEnreg]['sUnitePoids'];
                        }
                        else{
                            $aIngredients['iQuantite'] = $aEnregs[$iEnreg]['iMesure'];
                            $aIngredients['iMesure'] = $aEnregs[$iEnreg]['sUnite'];
                        }
                        array_push($aoEnregs[$aEnregs[$iEnreg]['idRecette']]['Ingredients'], $aIngredients);
                    } else {
                        $aoEnregs[$aEnregs[$iEnreg]['idRecette']] = array();
                        $aoEnregs[$aEnregs[$iEnreg]['idRecette']]['idRecette'] = $aEnregs[$iEnreg]['idRecette'];
                        $aoEnregs[$aEnregs[$iEnreg]['idRecette']]['sNomRecette'] = $aEnregs[$iEnreg]['sNomRecette'];
                        $aoEnregs[$aEnregs[$iEnreg]['idRecette']]['Ingredients'] = array();
                        $aIngredients = array();

                        $aIngredients['sNomIngredient'] = $aEnregs[$iEnreg]['sNomIngredient'];
                        $aIngredients['idIngredient'] = $aEnregs[$iEnreg]['idIngredient'];
                        $aIngredients['sNomMarque'] = $aEnregs[$iEnreg]['sNomMarque'];
                        $aIngredients['idMarque'] = $aEnregs[$iEnreg]['idMarque'];
                        if($aEnregs[$iEnreg]['sUnitePoids'] !=NULL){
                            $aIngredients['iQuantite'] = $aEnregs[$iEnreg]['fPoidsA'];
                            $aIngredients['iMesure'] = $aEnregs[$iEnreg]['sUnitePoids'];
                        }
                        else{
                            $aIngredients['iQuantite'] = $aEnregs[$iEnreg]['iMesure'];
                            $aIngredients['iMesure'] = $aEnregs[$iEnreg]['sUnite'];
                        }

                        array_push($aoEnregs[$aEnregs[$iEnreg]['idRecette']]['Ingredients'], $aIngredients);
                    }
                }

                return $aoEnregs;
                // if($aEnregs !== false){
                // 	return $aEnregs;
                // }
            }
            return false;
        }
    }//fin de la fonction

		/**
    * rechercher un enregistrement dans la table "recettes"
     * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUnCustom(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM recettes
			INNER JOIN portions ON portions.idPortion = recettes.idPortion
			WHERE idRecette= :idRecette";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idRecette", $this->getidRecette(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idRecette'],$aEnregs['sNomRecette'],$aEnregs['sDescRecette'],$aEnregs['sTempsCuisson'], $aEnregs['sTemperatureCuisson']);
				$this->setsCategorie($aEnregs['sCategorie']);
				$this->setbVisible($aEnregs['bVisible']);
				$this->setoPortion(new Portion($aEnregs['idPortion'], $aEnregs['iNbPortions'], $aEnregs['sGrosseurPortion'], $aEnregs['sEnergiePortion'], $aEnregs['sGlucides'], $aEnregs['sProteines'], $aEnregs['sLipides'], $aEnregs['sFibres'], $aEnregs['sSodium']));

				return $this;
			}
		}

		return false;

    }//fin de la fonction




}//fin de la classe Recette
