<?php
/**
 * Fichier Allergene.class.php
 * Examens de TDI
 * @author Caroline Martin
 * @version Friday 5th of April 2019 08:44:28 AM
 */
class Allergene {
	private $idAllergene;
	private $sNomAllergene;
	private $bSourceGluten;


    /**
    * constructeur
	* @param integer $idAllergene
	* @param string $sNomAllergene
	* @param boolean $bSourceGluten
	* @return void
    */
    public function __construct($idAllergene=0,$sNomAllergene="",$bSourceGluten=0){
			$this->setidAllergene($idAllergene);
			$this->setsNomAllergene($sNomAllergene);
			$this->setbSourceGluten($bSourceGluten);
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $idAllergene
    * @return void
    */
    public function setidAllergene($idAllergene){
    	TypeException::estNumerique($idAllergene);
    	$this->idAllergene = $idAllergene;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  integer
    */
    public function getidAllergene(){
    	return $this->idAllergene;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sNomAllergene
    * @return void
    */
    public function setsNomAllergene($sNomAllergene){
    	TypeException::estChaineDeCaracteres($sNomAllergene);
    	$this->sNomAllergene = $sNomAllergene;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsNomAllergene(){
    	return $this->sNomAllergene;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param boolean $bSourceGluten
    * @return void
    */
    public function setbSourceGluten($bSourceGluten){
    	TypeException::estNumerique($bSourceGluten);
		TypeException::estBooleen($bSourceGluten);
    	$this->bSourceGluten = $bSourceGluten;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  boolean
    */
    public function getbSourceGluten(){
    	return $this->bSourceGluten;
    }//fin de la fonction

    /**
    * ajoute un enregistrement dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouter(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			INSERT allergenes
			(sNomAllergene,bSourceGluten)
			VALUES(:sNomAllergene,:bSourceGluten)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":sNomAllergene", $this->getsNomAllergene(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":bSourceGluten", $this->getbSourceGluten(), PDO::PARAM_BOOL);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOLib->getoPDO()->lastInsertId();
		}
		return false;

    }//fin de la fonction

    /**
    * modifie un enregistrement dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @param boolean $bSourceDeGluten
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function modifier(PDOLib $oPDOLib, $bSourceDeGluten=0){
    	//Réaliser la requête
        $sCol = "";
        if($bSourceDeGluten==0){
            $sCol = "sNomAllergene = :sNomAllergene, ";
        }
		$sRequete="
			UPDATE allergenes
			SET ".$sCol."
                bSourceGluten = :bSourceGluten
			WHERE idAllergene= :idAllergene";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs

        if($bSourceDeGluten==0){
            $oPDOStatement->bindValue(":sNomAllergene", $this->getsNomAllergene(), PDO::PARAM_STR);
        }
		$oPDOStatement->bindValue(":bSourceGluten", $this->getbSourceGluten(), PDO::PARAM_BOOL);
		$oPDOStatement->bindValue(":idAllergene", $this->getidAllergene(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction



    /**
    * supprime un enregistrement dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement supprimé) ou un boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			DELETE FROM allergenes
			WHERE idAllergene= :idAllergene";


		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idAllergene", $this->getidAllergene(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction

    /**
    * rechercher un enregistrement dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUn(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM allergenes
			WHERE idAllergene= :idAllergene";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idAllergene", $this->getidAllergene(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idAllergene'], $aEnregs['sNomAllergene'], $aEnregs['bSourceGluten']);
				return true;
			}
		}
		return false;

    }//fin de la fonction
	/**
    * rechercher un enregistrement dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUnParNom(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM allergenes
			WHERE LOWER(sNomAllergene) LIKE ('%".":sNomAllergene"."%')
			";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":sNomAllergene", $this->getsNomAllergene(), PDO::PARAM_STR);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idAllergene'], $aEnregs['sNomAllergene'], $aEnregs['bSourceGluten']);
				return true;
			}
		}
		return false;

    }//fin de la fonction
    /**
    * rechercher tous les enregistrements dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTous(PDOLib $oPDOLib ,$bPopulation=false){
    	//Se connecter à la base de données
		$oPDOLib = new PDOLib();
		//Réaliser la requête
		$sRequete="
			SELECT *
			FROM allergenes";

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
				foreach($aEnregs as $iEnreg => $aAllergene){
					$aoEnregs[$iEnreg] = new Allergene(
						$aAllergene['idAllergene'], $aAllergene['sNomAllergene'], $aAllergene['bSourceGluten']
					);
				}
				//Retourner le array d'objets de la classe Allergene
				if($bPopulation==true){
					echo '<pre>'.json_encode($aoEnregs).'</pre>';
					return json_encode($aoEnregs);

				}else{
					return $aoEnregs;
				}

			}
		}
		return false;

    }//fin de la fonction


    /**
    * rechercher tous les enregistrements dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTousJSON(PDOLib $oPDOLib){
    	//Se connecter à la base de données
		$oPDOLib = new PDOLib();
		//Réaliser la requête
		$sRequete="
			SELECT *
			FROM allergenes";

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

			return json_encode($aEnregs);
		}
		return false;

    }//fin de la fonction

		/**
    * rechercher un enregistrement dans la table "allergenes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUnCustom(PDOLib $oPDOLib) {
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM allergenes
			WHERE idAllergene= :idAllergene";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idAllergene", $this->getidAllergene(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idAllergene'], $aEnregs['sNomAllergene'], $aEnregs['bSourceGluten']);
				return $this;
			}
		}
		return false;

    }//fin de la fonction

}//fin de la classe Allergene
