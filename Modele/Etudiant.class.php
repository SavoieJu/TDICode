<?php
/**
 * Fichier Etudiant.class.php
 * Examens de TDI
 * @author Caroline Martin
 * @version Friday 5th of April 2019 08:44:28 AM
 */
class Etudiant {
	private $idEtudiant;
	private $sNomEtudiant;
	private $sPrenomEtudiant;

    /**
    * constructeur
	* @param integer $idEtudiant
	* @param string $sNomEtudiant
	* @param string $sPrenomEtudiant
	* @return void
    */
    public function __construct($idEtudiant=1,$sNomEtudiant="",$sPrenomEtudiant=""){
			$this->setidEtudiant($idEtudiant);
			$this->setsNomEtudiant($sNomEtudiant);
			$this->setsPrenomEtudiant($sPrenomEtudiant);


    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $idEtudiant
    * @return void
    */
    public function setidEtudiant($idEtudiant){
    	TypeException::estNumerique($idEtudiant);
    	$this->idEtudiant = $idEtudiant;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  integer
    */
    public function getidEtudiant(){
    	return $this->idEtudiant;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sNomEtudiant
    * @return void
    */
    public function setsNomEtudiant($sNomEtudiant){
    	TypeException::estChaineDeCaracteres($sNomEtudiant);
    	$this->sNomEtudiant = $sNomEtudiant;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsNomEtudiant(){
    	return $this->sNomEtudiant;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sPrenomEtudiant
    * @return void
    */
    public function setsPrenomEtudiant($sPrenomEtudiant){
    	TypeException::estChaineDeCaracteres($sPrenomEtudiant);
    	$this->sPrenomEtudiant = $sPrenomEtudiant;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsPrenomEtudiant(){
    	return $this->sPrenomEtudiant;
    }//fin de la fonction

    /**
    * ajoute un enregistrement dans la table "etudiants"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouter(PDOLib $oPDOLib){

		//Réaliser la requête
		$sRequete="
			INSERT etudiants
			(sNomEtudiant,sPrenomEtudiant)
			VALUES(:sNomEtudiant,:sPrenomEtudiant)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":sNomEtudiant", $this->getsNomEtudiant(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":sPrenomEtudiant", $this->getsPrenomEtudiant(), PDO::PARAM_STR);


		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){

			return (int)$oPDOLib->getoPDO()->lastInsertId();
		}

		return false;

    }//fin de la fonction

    /**
    * modifie un enregistrement dans la table "etudiants"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function modifier(PDOLib $oPDOLib){


		//Réaliser la requête
		$sRequete="
			UPDATE etudiants
			SET sNomEtudiant = :sNomEtudiant,sPrenomEtudiant = :sPrenomEtudiant
			WHERE idEtudiant= :idEtudiant";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs

		$oPDOStatement->bindValue(":sNomEtudiant", $this->getsNomEtudiant(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":sPrenomEtudiant", $this->getsPrenomEtudiant(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":idEtudiant", $this->getidEtudiant(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){

			return (int)$oPDOStatement->rowCount();
		}

		return false;

    }//fin de la fonction

    /**
    * supprime un enregistrement dans la table "etudiants"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement supprimé) ou un boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){


		//Réaliser la requête
		$sRequete="
			DELETE FROM etudiants
			WHERE idEtudiant= :idEtudiant";


		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idEtudiant", $this->getidEtudiant(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){

			return (int)$oPDOStatement->rowCount();
		}

		return false;

    }//fin de la fonction

    /**
    * rechercher un enregistrement dans la table "etudiants"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUn(PDOLib $oPDOLib){


		//Réaliser la requête
		$sRequete="
			SELECT *
			FROM etudiants
			WHERE idEtudiant= :idEtudiant";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idEtudiant", $this->getidEtudiant(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idEtudiant'],$aEnregs['sNomEtudiant'],$aEnregs['sPrenomEtudiant']);

				return true;
			}
		}

		return false;

    }//fin de la fonction

    /**
    * rechercher tous les enregistrements dans la table "etudiants"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTous(PDOLib $oPDOLib){


		//Réaliser la requête
		$sRequete="
			SELECT *
			FROM etudiants";

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
					$aoEnregs[$iEnreg] = new Etudiant(
						$aEnregs[$iEnreg]['idEtudiant'],$aEnregs[$iEnreg]['sNomEtudiant'],$aEnregs[$iEnreg]['sPrenomEtudiant']
					);
				}

				//Retourner le array d'objets de la classe Etudiant
				return $aoEnregs;
			}
		}

		return false;

    }//fin de la fonction

	/**
    * importer dans la table "etudiants"
    * @param PDOLib $oPDOLib
    * @return boolean (false si la importation s'est mal passée)
    */
    public function importerTous(PDOLib $oPDOLib, $sFichier){
    	//Réaliser la requête
		$sRequete="
			LOAD DATA LOCAL INFILE '".$sFichier."'
			INTO TABLE etudiants
			FIELDS TERMINATED BY ';'
			ENCLOSED BY '\"'
			LINES TERMINATED BY '\n'
			IGNORE 1 ROWS;";
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		return $b;
	}//fin de la fonction

	/**
	* rechercher un enregistrement dans la table "etudiants"
	* @param PDOLib $oPDOLib
	* @return boolean (true si trouvé, false dans les autres cas)
	*/
	public function rechercherUnCustom(PDOLib $oPDOLib){


	//Réaliser la requête
	$sRequete="
		SELECT *
		FROM etudiants
		WHERE idEtudiant= :idEtudiant";

	//Préparer la requête
	$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

	//Lier les paramètres aux valeurs
	$oPDOStatement->bindValue(":idEtudiant", $this->getidEtudiant(), PDO::PARAM_INT);

	//Exécuter la requête
	$b = $oPDOStatement->execute();

	//Si la requête a bien été exécutée
	if($b == true){
		//Récupérer l'enregistrement (fetch)
		$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
		if($aEnregs !== false){
			//Affecter les valeurs aux propriétés privées de l'objet
			$this->__construct($aEnregs['idEtudiant'],$aEnregs['sNomEtudiant'],$aEnregs['sPrenomEtudiant']);

			return $aEnregs;
		}
	}
}


/**
* rechercher un enregistrement dans la table "etudiants"
* @param PDOLib $oPDOLib
* @return boolean (true si trouvé, false dans les autres cas)
*/
public function rechercherUnCustomTwo(PDOLib $oPDOLib){


//Réaliser la requête
$sRequete="
	SELECT *
	FROM etudiants
	WHERE idEtudiant= :idEtudiant";

//Préparer la requête
$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

//Lier les paramètres aux valeurs
$oPDOStatement->bindValue(":idEtudiant", $this->getidEtudiant(), PDO::PARAM_INT);

//Exécuter la requête
$b = $oPDOStatement->execute();

//Si la requête a bien été exécutée
if($b == true){
	//Récupérer l'enregistrement (fetch)
	$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
	if($aEnregs !== false){
		//Affecter les valeurs aux propriétés privées de l'objet
		$this->__construct($aEnregs['idEtudiant'],$aEnregs['sNomEtudiant'],$aEnregs['sPrenomEtudiant']);

		return $this;
	}
}

return false;

}//fin de la fonction

}//fin de la classe Etudiant
