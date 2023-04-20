<?php
namespace App\Models;

use App\Core\DataAccessObject;

use PDO;
use Exception;

class PatientDAO extends DAO 
{
    // Instance
    protected static $instance = null;

    public function __construct()
    {
        parent::__construct(["id_user, id_praticien"], "patients");
    }
    
    public static function getInstance():self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Cherche dans la table d'association praticien/patient tous les patients d'un praticien
     * @param [int] $id
     * @return array
     */
    public function findAllByPraticien($id):array
    {
        $data = [];
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "SELECT * FROM $this->table WHERE id_praticien=:id";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id', $id);

        // On exécute la requête préparée
        $stmt->execute();

        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $data[] = $row["id_user"];
        }
        return $data;
    }
    public function findAllByUser($id){
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "SELECT * FROM $this->table WHERE id_user=:id";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id', $id);

        // On exécute la requête préparée
        $stmt->execute();

        $row = $stmt->fetch();
    }

    public function create($objet):void
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->table (id_user, id_praticien) VALUE (:id_user, :id_praticien)";

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

    public function read($id){
        throw new Exception("Can't touch this !");
    }
    public function delete($objet){
        throw new Exception("Can't touch this !");
    }
    public function update($objet){
        throw new Exception("Can't touch this !");
    }
}