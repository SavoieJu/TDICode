<?php
/**
 * Fichier Ingredients_marques_allergene.class.php
 * Gestion des allergènes
 * @author Caroline Martin
 * @version Friday 13th of September 2019 12:09:42 PM
 */
class Ingredients_marques_allergene {
	private $oRecette;
	
	private $oIngredient;
	private $oMarque;
	private $oAllergene;
	private $bPeutContenir;		
	
    /**
    * constructeur 
	* @param integer $idIngredient
	* @param integer $idMarque
	* @param integer $idAllergene
	* @param integer $bPeutContenir
	* @return void
    */
    public function __construct($idIngredient=1,$idMarque=1,$idAllergene=1,$bPeutContenir=1){
			$this->setoIngredient(new Ingredient($idIngredient));
			$this->setoMarque(new Marque($idMarque));
			$this->setoAllergene(new Allergene($idAllergene));
			$this->setbPeutContenir($bPeutContenir);
    	
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
    * @param integer $bPeutContenir
    * @return void
    */
    public function setbPeutContenir($bPeutContenir){     	
    	TypeException::estNumerique($bPeutContenir);
    	$this->bPeutContenir = $bPeutContenir;
    }//fin de la fonction
	
    /**
    * retourne la valeur de la propriété privée 
    * @param void
    * @return  integer
    */
    public function getbPeutContenir(){	   
    	return $this->bPeutContenir;
    }//fin de la fonction
		
    /**
    * ajoute un ou plusieurs enregistrements dans la table "ingredients_marques_allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le id de la dernière insertion) ou un boolean (false si l'insertion s'est mal passée)
    */
    public function ajouter(PDOLib $oPDOLib, $aAllergenes = false){		
		$iNbParam = count($aAllergenes['idAllergene']);
		
		if($aAllergenes != false){
			//Réaliser la requête
			$sRequete ="
			INSERT ingredients_marques_allergenes
			(idIngredient, idMarque, idAllergene, bPeutContenir)
			VALUES(:idIngredient_0, :idMarque_0,:idAllergene_0,:bPeutContenir_0)
			";
			
			
			for($i=1; $i< $iNbParam; $i++){
				$sRequete.="
					,(:idIngredient_".$i.", :idMarque_".$i.", :idAllergene_".$i.", :bPeutContenir_".$i.")
				";
			}
		
			
			//Préparer la requête
			$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
		
			for($i=0; $i< $iNbParam; $i++){
				//Lier les paramètres aux valeurs
				$oPDOStatement->bindValue(":idIngredient_".$i, $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
				$oPDOStatement->bindValue(":idMarque_".$i, $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
				$oPDOStatement->bindValue(":idAllergene_".$i, $aAllergenes['idAllergene'][$i], PDO::PARAM_INT);
				$oPDOStatement->bindValue(":bPeutContenir_".$i, $aAllergenes['bPeutContenir'][$i], PDO::PARAM_INT);
			}
			//Exécuter la requête
			$b = $oPDOStatement->execute();
			//var_dump($oPDOStatement->errorInfo());
			return $b;
		}
		return true;
		
		
		
    }//fin de la fonction
		
    /**
    * modifie un enregistrement dans la table "ingredients_marques_allergenes"
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement modifié) ou un boolean (false si la modification s'est mal passée)
    */
    public function modifier(PDOLib $oPDOLib){	   
    	//Réaliser la requête
		$sRequete="
			UPDATE ingredients_marques_allergenes
			SET idIngredient = :idIngredient,
				idMarque = :idMarque,
				idAllergene = :idAllergene,
				bPeutContenir = :bPeutContenir
			WHERE idIngredient = :idIngredient
			AND idMarque = :idMarque
			AND idAllergene = :idAllergene
			";
		
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
		
		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idAllergene", $this->getoAllergene()->getidAllergene(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":bPeutContenir", $this->getbPeutContenir(), PDO::PARAM_INT);
		
		
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		
		//Si la requête a bien été exécutée
		if($b == true){
			return (int)$oPDOStatement->rowCount();
		}
		return false;	
		
    }//fin de la fonction
		
    /**
    * supprime tous les allergènes dans la table "ingredients_marques_allergenes" d'un ingredient-marque
    * @param PDOLib $oPDOLib
    * @return integer (le nombre d'enregistrement supprimé) ou un boolean (false si la suppression s'est mal passée)
    */
    public function supprimer(PDOLib $oPDOLib){	   
		//Réaliser la requête
		$sRequete="
			DELETE FROM ingredients_marques_allergenes
			WHERE idIngredient= :idIngredient
			AND idMarque = :idMarque
			
			";
			
		
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
		
		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);		
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		
		//Si la requête a bien été exécutée
		if($b == true){			
			return (int)$oPDOStatement->rowCount();
		}		
		return false;	
		
    }//fin de la fonction
		
    /**
    * rechercher un enregistrement dans la table "ingredients_marques_allergenes"
    * @param PDOLib $oPDOLib
    * @return boolean (true si trouvé, false dans les autres cas)
    */
    public function rechercherUn(PDOLib $oPDOLib){	   
    	//Réaliser la requête
		$sRequete="
			SELECT * 
			FROM ingredients_marques_allergenes
			WHERE idIngredient= :idIngredient
			AND idMarque = :idMarque
			AND idAllergene = :idAllergene
			";
		
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
		
		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idAllergene", $this->getoAllergene()->getidAllergene(), PDO::PARAM_INT);
		
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		
		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer l'enregistrement (fetch)
			$aEnregs = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
			if($aEnregs !== false){
				//Affecter les valeurs aux propriétés privées de l'objet
				$this->setoIngredient($aEnregs['idIngredient'], $aEnregs['sNomIngredient']);
				$this->setoMarque($aEnregs['idMarque'], $aEnregs['sNomMarque']);
				$this->setoAllergene($aEnregs['idAllergene'], $aEnregs['sNomAllergene']);
				$this->setbPeutContenir($aEnregs['bPeutContenir']);				
				return true;
			}
		}		
		return false;	
		
    }//fin de la fonction
    
    
    
    /**
    * rechercher tous les enregistrements dans la table "ingredients_marques_allergenes"
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
    */
    public function rechercherTousLesAllergenes(PDOLib $oPDOLib){	   
    	//Réaliser la requête
		$sRequete="
			SELECT * 
			FROM ingredients_marques_allergenes
			INNER JOIN ingredients ON ingredients.idIngredient = ingredients_marques_allergenes.idIngredient
			INNER JOIN marques ON marques.idMarque = ingredients_marques_allergenes.idMarque
			INNER JOIN allergenes ON allergenes.idAllergene = ingredients_marques_allergenes.idAllergene
			WHERE ingredients.idIngredient= :idIngredient
			AND marques.idMarque = :idMarque
			ORDER BY allergenes.idAllergene";
		
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
						
		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer le array 
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
			
			$iMax = count($aEnregs);
			//var_dump($iMax);
			$aoEnregs = array(); 
			if($iMax > 0){
				
				for($iEnreg=0;$iEnreg<$iMax;$iEnreg++){
					$aoEnregs[$iEnreg] = new Ingredients_marques_allergene(
						$aEnregs[$iEnreg]['idIngredient'],$aEnregs[$iEnreg]['idMarque'],$aEnregs[$iEnreg]['idAllergene'],$aEnregs[$iEnreg]['bPeutContenir']
					);
					//Affecter les valeurs aux propriétés privées de l'objet
					$aoEnregs[$iEnreg]->setoIngredient(new Ingredient($aEnregs[$iEnreg]['idIngredient'], $aEnregs[$iEnreg]['sNomIngredient']));
					$aoEnregs[$iEnreg]->setoMarque(new Marque($aEnregs[$iEnreg]['idMarque'], $aEnregs[$iEnreg]['sNomMarque']));
					
					$aoEnregs[$iEnreg]->setoAllergene(new Allergene($aEnregs[$iEnreg]['idAllergene'], $aEnregs[$iEnreg]['sNomAllergene']));
					$aoEnregs[$iEnreg]->setbPeutContenir($aEnregs[$iEnreg]['bPeutContenir']);
				}
				//Retourner le array d'objets de la classe Ingredients_marques_allergene				
				return $aoEnregs;
			}
		}
		return false;	
		
    }//fin de la fonction
    
    /**
    * Rechercher tous les ingrédients avec leurs marques et leurs allèrgènes(id,sNomIngredient,sNomMarque,sNomAllergène)
    * @param PDOLib $oPDOLib
    * @return array ou boolean (false si la recherche s'est mal passée)
	* @author Daniel Fiola
    */
    public function rechercherTousLesProduitsMarquesAllergenes(PDOLib $oPDOLib, $JSRequest=false){	   
    	//Réaliser la requête
		$sRequete="
			SELECT *
            FROM ingredients
            INNER JOIN ingredients_marques_allergenes ON ingredients.idIngredient = ingredients_marques_allergenes.idIngredient
            INNER JOIN marques On ingredients_marques_allergenes.idMarque = marques.idMarque
            INNER JOIN allergenes ON ingredients_marques_allergenes.idAllergene = allergenes.idAllergene
            ORDER BY ingredients.idIngredient";
		
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
						
		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer le array 
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
			if($JSRequest){
				return json_encode($aEnregs);
			}
			$iMax = count($aEnregs);
			//var_dump($iMax);
			$aoEnregs = array(); 
			if($iMax > 0){
				
				for($iEnreg=0;$iEnreg<$iMax;$iEnreg++){
					$aoEnregs[$iEnreg] = new Ingredients_marques_allergene(
						$aEnregs[$iEnreg]['idIngredient'],$aEnregs[$iEnreg]['idMarque'],$aEnregs[$iEnreg]['idAllergene'],$aEnregs[$iEnreg]['bPeutContenir']
					);
					//Affecter les valeurs aux propriétés privées de l'objet
					$aoEnregs[$iEnreg]->setoIngredient(new Ingredient($aEnregs[$iEnreg]['idIngredient'], $aEnregs[$iEnreg]['sNomIngredient']));
					$aoEnregs[$iEnreg]->setoMarque(new Marque($aEnregs[$iEnreg]['idMarque'], $aEnregs[$iEnreg]['sNomMarque']));
					
					$aoEnregs[$iEnreg]->setoAllergene(new Allergene($aEnregs[$iEnreg]['idAllergene'], $aEnregs[$iEnreg]['sNomAllergene']));
					$aoEnregs[$iEnreg]->setbPeutContenir($aEnregs[$iEnreg]['bPeutContenir']);
				}
				//Retourner le array d'objets de la classe Ingredients_marques_allergene				
				return $aoEnregs;
			}
		}
		return false;	
		
    }//fin de la fonction
    
    public function rechercherTousLesProduitsMarquesAllergenesToJSON(PDOLib $oPDOLib){	   
    	//Réaliser la requête
		$sRequete="
			SELECT *
            FROM ingredients
            INNER JOIN ingredients_marques_allergenes ON ingredients.idIngredient = ingredients_marques_allergenes.idIngredient
            INNER JOIN marques On ingredients_marques_allergenes.idMarque = marques.idMarque
            INNER JOIN allergenes ON ingredients_marques_allergenes.idAllergene = allergenes.idAllergene
            ORDER BY ingredients.idIngredient, marques.idMarque";
		
		//Préparer la requête
		$oPDOStatement = $oPDOLib->getoPDO()->prepare($sRequete);
						
		//Lier les paramètres aux valeurs
		$oPDOStatement->bindValue(":idIngredient", $this->getoIngredient()->getidIngredient(), PDO::PARAM_INT);
		$oPDOStatement->bindValue(":idMarque", $this->getoMarque()->getidMarque(), PDO::PARAM_INT);
		
		//Exécuter la requête
		$b = $oPDOStatement->execute();
		//var_dump($oPDOStatement->errorInfo());
		//Si la requête a bien été exécutée
		if($b == true){
			//Récupérer le array 
			$aEnregs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
			
			
			//var_dump($iMax);
			//$aoTest={};
			$aoEnregs = array(); 
				return json_encode($aEnregs);
		}
		return false;	
		
    }//fin de la fonction
		
}//fin de la classe Ingredients_marques_allergene