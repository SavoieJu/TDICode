<?php
/**
 * Fichier Ingredient.class.php
 * Examens de TDI
 * @author Caroline Martin
 * @version Friday 5th of April 2019 08:44:28 AM
 */
class Ingredient {
	private $idIngredient;
	private $sNomIngredient;

    /**
    * constructeur
	* @param integer $idIngredient
	* @param string $sNomIngredient
	* @param string $sDescIngredient
	* @return void
    */
    public function __construct($idIngredient=0,$sNomIngredient=""){
			$this->setidIngredient($idIngredient);
			$this->setsNomIngredient($sNomIngredient);
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $idIngredient
    * @return void
    */
    public function setidIngredient($idIngredient){
    	TypeException::estNumerique($idIngredient);
    	$this->idIngredient = $idIngredient;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  integer
    */
    public function getidIngredient(){
    	return $this->idIngredient;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sNomIngredient
    * @return void
    */
    public function setsNomIngredient($sNomIngredient){
    	TypeException::estChaineDeCaracteres($sNomIngredient);
    	$this->sNomIngredient = $sNomIngredient;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsNomIngredient(){
    	return $this->sNomIngredient;
    }//fin de la fonction

    /**
    * ajoute un enregistrement dans la table "ingredients"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouter(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			INSERT ingredients
			(sNomIngredient)
			VALUES(:sNomIngredient)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":sNomIngredient", $this->getsNomIngredient(), PDO::PARAM_STR);


		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			$this->idIngredient = (int)$oPDOLib->getoPDO()->lastInsertId();
			return $this->idIngredient;
		}
		return false;

    }//fin de la fonction

    /**
    * modifie un enregistrement dans la table "ingredients"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function modifier(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			UPDATE ingredients
			SET sNomIngredient = :sNomIngredient
			WHERE idIngredient= :idIngredient";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs

		$oPDOStatement->bindValue(":sNomIngredient", $this->getsNomIngredient(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":idIngredient", $this->getidIngredient(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction

    /**
    * supprime un enregistrement dans la table "ingredients"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement supprimé) ou un boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			DELETE FROM ingredients
			WHERE idIngredient= :idIngredient";


		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getidIngredient(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction

    /**
    * rechercher un enregistrement dans la table "ingredients"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUn(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM ingredients
			WHERE idIngredient= :idIngredient";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getidIngredient(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idIngredient'],$aEnregs['sNomIngredient']);
				return true;
			}
		}
		return false;

    }//fin de la fonction

    /**
    * rechercher tous les enregistrements dans la table "ingredients"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTous(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM ingredients
			ORDER BY sNomIngredient";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		//void

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
					$aoEnregs[$iEnreg] = new Ingredient(
						$aEnregs[$iEnreg]['idIngredient'],$aEnregs[$iEnreg]['sNomIngredient']
					);
				}
				//Retourner le array d'objets de la classe Ingredient
				return $aoEnregs;
			}
		}
		return false;

    }//fin de la fonction

		/**
    * rechercher un enregistrement dans la table "ingredients"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUnCustom(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM ingredients
			WHERE idIngredient= :idIngredient";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getidIngredient(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idIngredient'],$aEnregs['sNomIngredient']);
				return $this;
			}
		}
		return false;

    }//fin de la fonction

}//fin de la classe Ingredient
