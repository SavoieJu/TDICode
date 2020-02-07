<?php
/**
 * Fichier Groupe.class.php
 * Examens de TDI
 * @author Caroline Martin
 * @version Friday 5th of April 2019 08:44:28 AM
 */
class Groupe {
	private $idGroupe;
	private $sNomGroupe;
	private $dateGroupe;

    /**
    * constructeur
	* @param integer $idGroupe
	* @param string $sNomGroupe
	* @param string $dateGroupe
	* @return void
    */
    public function __construct($idGroupe=1,$sNomGroupe="",$dateGroupe=""){
			$this->setidGroupe($idGroupe);
			$this->setsNomGroupe($sNomGroupe);
			$this->setdateGroupe($dateGroupe);

    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param integer $idGroupe
    * @return void
    */
    public function setidGroupe($idGroupe){
    	TypeException::estNumerique($idGroupe);
    	$this->idGroupe = $idGroupe;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  integer
    */
    public function getidGroupe(){
    	return $this->idGroupe;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $sNomGroupe
    * @return void
    */
    public function setsNomGroupe($sNomGroupe){
    	TypeException::estChaineDeCaracteres($sNomGroupe);
    	$this->sNomGroupe = $sNomGroupe;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getsNomGroupe(){
    	return $this->sNomGroupe;
    }//fin de la fonction

    /**
    * affecte la valeur du paramètre a la propriété privée
    * @param string $dateGroupe
    * @return void
    */
    public function setdateGroupe($dateGroupe){
    	TypeException::estChaineDeCaracteres($dateGroupe);
    	$this->dateGroupe = $dateGroupe;
    }//fin de la fonction

    /**
    * retourne la valeur de la propriété privée
    * @param void
    * @return  string
    */
    public function getdateGroupe(){
    	return $this->dateGroupe;
    }//fin de la fonction

    /**
    * ajoute un enregistrement dans la table "groupes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouter(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			INSERT groupes
			(sNomGroupe,dateGroupe)
			VALUES(:sNomGroupe, :dateGroupe)
		";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":sNomGroupe", $this->getsNomGroupe(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":dateGroupe", $this->getdateGroupe(), PDO::PARAM_STR);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOLib->getoPDO()->lastInsertId();
		}
		return false;

    }//fin de la fonction

    /**
    * modifie un enregistrement dans la table "groupes"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function modifier(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			UPDATE groupes
			SET sNomGroupe = :sNomGroupe,dateGroupe = :dateGroupe
			WHERE idGroupe= :idGroupe";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs

		$oPDOStatement->bindValue(":sNomGroupe", $this->getsNomGroupe(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":dateGroupe", $this->getdateGroupe(), PDO::PARAM_STR);
		$oPDOStatement->bindValue(":idGroupe", $this->getidGroupe(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction

    /**
    * supprime un enregistrement dans la table "groupes"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement supprimé) ou un boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			DELETE FROM groupes
			WHERE idGroupe= :idGroupe";


		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getidGroupe(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;

    }//fin de la fonction

    /**
    * rechercher un enregistrement dans la table "groupes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUn(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM groupes
			WHERE idGroupe= :idGroupe";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getidGroupe(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idGroupe'],$aEnregs['sNomGroupe'],$aEnregs['dateGroupe']);
				return true;
			}
		}
		return false;

    }//fin de la fonction

    /**
    * rechercher tous les enregistrements dans la table "groupes"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTous(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM groupes";

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
					$aoEnregs[$iEnreg] = new Groupe(
						$aEnregs[$iEnreg]['idGroupe'],$aEnregs[$iEnreg]['sNomGroupe'],$aEnregs[$iEnreg]['dateGroupe']
					);
				}
				//Retourner le array d'objets de la classe Groupe
				return $aoEnregs;
			}
		}
		return false;

    }//fin de la fonction

		/**
    * rechercher un enregistrement dans la table "groupes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUnCustom(PDOLib $oPDOLib){
    	//Réaliser la requête
		$sRequete="
			SELECT *
			FROM groupes
			WHERE idGroupe= :idGroupe";

		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);

		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idGroupe", $this->getidGroupe(), PDO::PARAM_INT);

		//Exécuter la requête
		$b = $oPDOStatement->execute();

		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->__construct($aEnregs['idGroupe'],$aEnregs['sNomGroupe'],$aEnregs['dateGroupe']);
				return $this;
			}
		}
		return false;

    }//fin de la fonction




}//fin de la classe Groupe
