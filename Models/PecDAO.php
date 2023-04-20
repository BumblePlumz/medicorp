<?php

namespace App\Models;

use App\Core\DataAccessObject;

class PecDAO extends DAO
{
    // Attributs
    private string $idPec = "id_pec";
    private string $type = "type";
    private string $duree = "duree";
    private string $prix = "prix";
    private string $idPraticien = "id_praticien";
    
    // Instance
    private static $instance;

    // Constructeur
    public function __construct()
    {
        parent::__construct("prise_en_charge", "id_pec");
    }
    // Pattern Singleton
    public static function getInstance():self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
    // Getter & Setter
    // Methods
    public function read($id):PecDO
    {
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $pecDO = null;

        $row = $stmt->fetch();
        if ($row) {
            $idPec = $row["id_pec"];
            $type = $row["type"];
            $duree = $row["duree"];
            $prix = $row["prix"];
            $idPraticien = $row["id_praticien"];

            $pecDO = new PecDO($type, $duree, $prix, $idPraticien);
            $pecDO->setId($idPec);
        }

        return $pecDO;
    }

    public function readAllByPraticien($id)
    {
        $data = [];
        $sql = "SELECT * FROM $this->table WHERE $this->idPraticien = :id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $pecDO = null;

        $rows = $stmt->fetchAll();
        if ($rows) {
            foreach ($rows as $row) {
                $idPec = $row["id_pec"];
                $type = $row["type"];
                $duree = $row["duree"];
                $prix = $row["prix"];
                $idPraticien = $row["id_praticien"];

                $pecDO = new PecDO($type, $duree, $prix, $idPraticien);
                $pecDO->setId($idPec);
                $data[] = $pecDO;
            }
        }   

        return $data;
    }

    public function create($objet):void
    {
        $sql = "INSERT INTO $this->table ($this->type, $this->duree, $this->prix, $this->idPraticien) VALUE (:typePec, :duree , :prix ,:idPraticien)";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $type = $objet->getType();
        $duree = $objet->getDuree();
        $prix = $objet->getPrix();
        $idPraticien = $objet->getIdPraticien();


        $stmt->bindParam(":typePec", $type);
        $stmt->bindParam(":duree", $duree);
        $stmt->bindParam(":prix", $prix);
        $stmt->bindParam(":idPraticien", $idPraticien);

        $stmt->execute();
    }

    public function update($objet):void
    {
        $sql = "UPDATE $this->table SET $this->type = :typePec, $this->duree = :duree, $this->prix = :prix, $this->idPraticien = :idPraticien) WHERE $this->primaryKey = :id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $id = $objet->getId();
        $type = $objet->getType();
        $duree = $objet->getDuree();
        $prix = $objet->getPrix();
        $idPraticien = $objet->getIdPraticien();
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":typePec", $type);
        $stmt->bindParam(":duree", $duree);
        $stmt->bindParam(":prix", $prix);
        $stmt->bindParam(":idPraticien", $idPraticien);

        $stmt->execute();
    }

    public function delete($objet):void
    {
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $id = $objet->getIdPatient();
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteById($id):void
    {
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}