<?php
namespace App\Models;

use App\Core\DataAccessObject;
use DateTime;

class PraticienDAO extends DAO 
{
    private string $id = "id";
    private string $activite = "activite";
    private string $numeroAdeli = "numero_adeli";
    private string $actif = "actif";
    private string $id_user = "id_user";

    // Instance
    protected static $instance = null;

    // Table de dépendance
    private string $patientTable = "patients";

    public function __construct()
    {
        parent::__construct("id", "praticien");
    }

    public static function getInstance():self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Créer la session de l'utilisateur
     * @return void
     */
    public function setSession($praticienDO){
        $_SESSION['user'] = [
            'idPraticien' => $praticienDO->getId(),
            'idUser' => $praticienDO->getUserID(),
            'email' => $praticienDO->getUserDO()->getEmail(),
        ];
    }

    public function findOneByIdUser($id):PraticienDO
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "SELECT * FROM $this->table WHERE id_user=:id";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id', $id);

        // On exécute la requête préparée
        $stmt->execute();

        $row = $stmt->fetch();

        $praticienDO = null;

        if ($row) {
            // On récupère les données
            $idPraticien = $row[$this->id];
            $activite = $row[$this->activite];
            $numeroAdeli = $row[$this->numeroAdeli];
            $actif = $row[$this->actif];
            $idUser = $row[$this->id_user];
    
            // On va chercher les données utilisateurs liées au praticien
            $userDAO = new UserDAO();
            $userDO = $userDAO->read($idUser);
    
            $praticienDO = new PraticienDO($activite, $numeroAdeli, $userDO);
            $praticienDO->setId($idPraticien)
                ->setActif($actif);

        }
        
        return $praticienDO;
    }

    /**
     * Lire un tuple "praticien" de la base donnée et sa dépendance "praticiens"
     * @param [int] $id
     * @return PraticienDO
     */
    public function read($id):PraticienDO
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey=:id";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id', $id);

        // On exécute la requête préparée
        $stmt->execute();

        // On récupère les données
        $row = $stmt->fetch();
        $activite = $row[$this->activite];
        $numeroAdeli = $row[$this->numeroAdeli];
        $actif = $row[$this->actif];
        $idUser = $row["id_user"];

        // On va chercher les données utilisateurs liées au praticien
        $userDAO = UserDAO::getInstance();
        $userDO = $userDAO->read($idUser);

        $praticienDO = new PraticienDO($activite, $numeroAdeli, $userDO);
        $praticienDO->setId($id)
            ->setActif($actif);
        
        return $praticienDO;
    }

    /**
     * Mettre à jour un tuple "praticien" dans la base de donnée
     * @param [PraticienDO] $objet
     * @return void
     */
    public function update($objet):void
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "UPDATE $this->table SET activite = :activite, numero_adeli = :numero_adeli, actif = :actif  WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $activite = $objet->getActivite();
        $adeli = $objet->getNumero_adeli();
        $actif = $objet->getActif();
        $praticien = $objet->getPraticienDO();
        $id = $praticien->getIdraticien();

        $stmt->bindParam(':activite', $activite);
        $stmt->bindParam(':numero_adeli', $adeli);
        $stmt->bindParam(':actif', $actif);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        // On met à jour la table praticien
        $praticienDAO = new praticienDAO();
        $praticienDAO->update($praticien);
    }
    /**
     * Creation d'un tuple "praticien" et "praticiens" dans la base de donnée
     * @param [PraticienDO] $objet
     * @return void/praticienDO $return dépend du paramètre return ? true : false;
     */
    public function create($objet, $return = false)
    {
        $userDAO = new UserDAO();
        $userDO = $objet->getUserDO();
        $userDAO->create($userDO);
        $id_user = $this->getLastKey();

        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->table (activite, numero_adeli, id_user) VALUE (:activite, :numero_adeli, :id_user)";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $activite = $objet->getActivite();
        $numero_adeli = $objet->getNumeroAdeli();

        $stmt->bindParam(':activite', $activite);
        $stmt->bindParam(':numero_adeli', $numero_adeli);
        $stmt->bindParam(':id_user', $id_user);

        $stmt->execute();

        if ($return == true){
            $id_praticien = $this->getLastKey();
            $praticienDO = new PraticienDO($activite, $numero_adeli, $userDO);
            $praticienDO->setId($id_praticien);
            $praticienDO->setUserID($id_user);
            return $praticienDO;
        }
    }

    /**
     * Suppression d'un tuple "praticien" et "praticiens" dans la base de donnée
     * @param [PraticienDO] $objet
     * @return void
     */
    public function delete($objet):void
    {
        
        $userDAO = new UserDAO();

        $userDO = $objet->getUserDO();
        $id = $objet->getUserID();

        $userDAO->delete($userDO);

        $sql = "DELETE FROM $this->table WHERE $this->primaryKey=:id";

        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function createPatient($objet):void
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->patientTable (id_user, id_praticien) VALUE (:id_user, :id_praticien)";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $idUser = $objet->getIdUser();
        $idPraticien = $objet->getIdPraticien();

        // On associe les paramètres
        $stmt->bindParam(":id_user", $idUser);
        $stmt->bindParam(":id_praticien", $idPraticien);

        // On exécute la requête préparée
        $stmt->execute();
    }
}
