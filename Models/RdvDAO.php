<?php
namespace App\Models;

use App\Core\DataAccessObject;
use DateTime;

class RdvDao extends DAO
{
    // Instance
    protected static $instance = null;

    public function __construct()
    {
        parent::__construct("id","rendez_vous");
    }

    public static function getInstance():self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Lire un tuple "rendez_vous", "users" et "prise_en_charge" dans la base de donnée
     * @param [int] $id
     * @return void
     */
    public function read($id)
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
        $idUser = $row["id_user"];
        $idPec = $row["id_prise_en_charge"];
        $dateRdv = DateTime::createFromFormat('Y-m-d H:i:s', $row["date_rdv"]);
        $commentaire = $row["commentaire"];
        $actif = $row["actif"];
        $p_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $row["p_created_at"]);

        // On va chercher les données utilisateurs liées au rdv
        $userDAO = new UserDAO();
        $userDO = $userDAO->read($idUser);

        $pecDAO = new PecDAO();
        $pecDO = $pecDAO->read($idPec);

        return new RdvDO($id, $userDO, $pecDO, $dateRdv, $commentaire, $actif, $p_created_at);;
    }
    public function update($objet)
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "UPDATE $this->table SET id_user = :id_user, id_prise_en_charge = :id_prise_en_charge, date_rdv = :date_rdv, commentaire = :commentaire, actif = :actif WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        
        $id_user = $objet->getUserDO()->getId_user();
        $id_pec = $objet->getPecDO()->getId(); //////////////////////////////// !!!!!!!!!!!!!!!!!!! ////////////////////// Vérifier les DAO/DO (TODO : erwan)
        $date_rdv = $objet->getDateRdv();
        $com = $objet->getCommentaire();
        $actif = $objet->getActif();
        $id = $objet->getId();


        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_prise_en_charge', $id_pec);
        $stmt->bindParam(':date_rdv', $date_rdv);
        $stmt->bindParam(':commentaire', $com);
        $stmt->bindParam(':actif', $actif);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function create($objet)
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->table (id_user, id_prise_en_charge, date_rdv, commentaire, actif) VALUE (:id_user, :id_prise_en_charge, :date_rdv, :commentaire, :actif)";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $id_user = $objet->getUserDO()->getId_user();
        $id_pec = $objet->getPecDo()->getId();
        $date_rdv = $objet->getDateRdv()->format('Y-m-d H:i:s');
        $commentaire = $objet->getCommentaire();
        $actif = $objet->getActif();

        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_prise_en_charge', $id_pec);
        $stmt->bindParam(':date_rdv', $date_rdv);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':actif', $actif);

        $stmt->execute();
    }
    public function delete($objet)
    {
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey=:id";

        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $id = $objet->getId_user();
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }
}