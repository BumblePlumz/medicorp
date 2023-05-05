<?php
namespace App\Models;

use App\Core\DataAccessObject;
use DateTime;

class PraticienDAO extends DAO 
{
    private string $nom = "nom";
    private string $prenom = "prenom";
    private string $date_naissance = "date_naissance";
    private string $adresse = "adresse";
    private string $ville = "ville";
    private string $code_postal = "code_postal";
    private string $email = "email";
    private string $telephone = "telephone";
    private string $mot_de_passe = "mot_de_passe";
    private string $activite = "activite";
    private string $numero_adeli = "numero_adeli";
    private string $actif = "actif";
    private string $date_creation = "date_creation";

    // Instance
    protected static $instance = null;

    // Table de dépendance
    private string $praticien_patient_table = "praticien_patient";

    public function __construct()
    {
        parent::__construct("praticien", "id_praticien");
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
    public function setSessionPraticien($praticienDO):void
    {
        $_SESSION['praticien'] = [
            'idPraticien' => $praticienDO->getIdPraticien(),
            'email' => $praticienDO->getEmail(),
            'profil' => ["reload" => false, "message" => "Message non défini"]
        ];
    }

    /**
     * Trouver un praticien par son email
     * @param string $email
     * @return object
     */
    public function findOneByEmail(string $email)
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $stmt->bindParam(":email",$email);
        $stmt->execute();

        $row = $stmt->fetch();
        $praticienDO = null;

        if ($row){
            $id_praticien = $row[$this->primaryKey];
            $nom = $row[$this->nom];
            $prenom = $row[$this->prenom];
            $date_naissance = DateTime::createFromFormat('Y-m-d', $row[$this->date_naissance]);
            $adresse = $row[$this->adresse];
            $ville = $row[$this->ville];
            $code_postal = $row[$this->code_postal];
            $email = $row[$this->email];
            $telephone = $row[$this->telephone];
            $mot_de_passe = $row[$this->mot_de_passe];
            $activite = $row[$this->activite];
            $numero_adeli = $row[$this->numero_adeli];
            $actif = $row[$this->actif];
            $date_creation = DateTime::createFromFormat('U', $row[$this->date_creation]);

            $praticienDO = new PraticienDO($nom, $prenom, $date_naissance, $adresse, $ville, $code_postal, $email, $telephone, $mot_de_passe, $activite, $numero_adeli);
            $praticienDO->setIdPraticien($id_praticien)
                        ->setActif($actif)
                        ->setDateCreation($date_creation);
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
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey=:id_praticien";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id_praticien', $id);

        // On exécute la requête préparée
        $stmt->execute();

        // On définit le praticien comme null
        $praticienDO = null;

        // On récupère les données
        $row = $stmt->fetch();
        if ($row){
            $nom = $row[$this->nom];
            $prenom = $row[$this->prenom];
            $date_naissance = DateTime::createFromFormat("Y-m-d", $row[$this->date_naissance]);
            $adresse = $row[$this->adresse];
            $ville = $row[$this->ville];
            $code_postal = $row[$this->code_postal];
            $email = $row[$this->email];
            $telephone = $row[$this->telephone];
            $mot_de_passe = $row[$this->mot_de_passe];
            $activite = $row[$this->activite];
            $numero_adeli = $row[$this->numero_adeli];
            $actif = $row[$this->actif];
            $date_creation = DateTime::createFromFormat('U', $row[$this->date_creation]);

            $praticien = new PraticienDO($nom, $prenom, $date_naissance, $adresse, $ville, $code_postal, $email, $telephone, $mot_de_passe, $activite, $numero_adeli);
            $praticien->setIdPraticien($id)
                        ->setActif($actif)
                        ->setDateCreation($date_creation);
            $praticienDO = $praticien;
        }
        return $praticienDO;
    }

    /**
     * Mettre à jour un tuple "praticien" dans la base de donnée
     * @param [PraticienDO] $objet
     * @return bool
     */
    public function update($objet):bool
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "UPDATE $this->table SET $this->nom = :nom, $this->prenom = :prenom, $this->date_naissance = :date_naissance, $this->adresse = :adresse, $this->ville = :ville, $this->code_postal = :code_postal, $this->email = :email, $this->telephone = :telephone, $this->mot_de_passe = :mot_de_passe, $this->activite = :activite, $this->numero_adeli = :numero_adeli, $this->actif = :actif  WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $id = $objet->getIdPraticien();
        $nom = $objet->getNom();
        $prenom = $objet->getPrenom();
        $date_naissance = $objet->getDateNaissance()->format('Y-m-d');
        $adresse = $objet->getAdresse();
        $ville = $objet->getVille();
        $code_postal = $objet->getCodePostal();
        $email = $objet->getEmail();
        $telephone = $objet->getTelephone();
        $mot_de_passe = $objet->getMotDePasse();
        $activite = $objet->getActivite();
        $numero_adeli = $objet->getNumeroAdeli();
        $actif = $objet->getActif();

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code_postal', $code_postal);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':activite', $activite);
        $stmt->bindParam(':numero_adeli', $numero_adeli);
        $stmt->bindParam(':actif', $actif);
        $stmt->bindParam(':id', $id);

        return $stmt->execute(); 
    }

    /**
     * Creation d'un tuple "praticien" et "praticiens" dans la base de donnée
     * @param [PraticienDO] $objet
     * @return bool return ? true : false
     */
    public function create($objet):bool
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->table ($this->nom, $this->prenom, $this->date_naissance, $this->adresse, $this->ville, $this->code_postal, $this->email, $this->telephone, $this->mot_de_passe, $this->activite, $this->numero_adeli) VALUE (:nom, :prenom, :date_naissance, :adresse, :ville, :code_postal, :email, :telephone, :mot_de_passe, :activite, :numero_adeli)";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $nom = $objet->getNom();
        $prenom = $objet->getPrenom();
        $date_naissance = $objet->getDateNaissance();
        $dateDeNaissancePrepared = $date_naissance->format('Y-m-d');
        $adresse = $objet->getAdresse();
        $ville = $objet->getVille();
        $code_postal = $objet->getCodePostal();
        $email = $objet->getEmail();
        $telephone = $objet->getTelephone();
        $mot_de_passe = $objet->getMotDePasse();
        $activite = $objet->getActivite();
        $numero_adeli = $objet->getNumeroAdeli();

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_naissance', $dateDeNaissancePrepared);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code_postal', $code_postal);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':activite', $activite);
        $stmt->bindParam(':numero_adeli', $numero_adeli);

        // $praticienDO = $stmt->execute(); 
        // if ($return == true){
        //     $id_praticien = $this->getLastKey();
        //     $praticienDO = new PraticienDO($nom, $prenom, $date_naissance, $adresse, $ville, $code_postal, $email, $telephone, $mot_de_passe, $activite, $numero_adeli);
        //     $praticienDO->setId_praticien($id_praticien)
        //                 ->setActif($actif)
        //                 ->setDate_creation($date_creation);
        // }
        // return $praticienDO;

        return $stmt->execute();
    }

    /**
     * Suppression d'un tuple "praticien" et "praticiens" dans la base de donnée
     * @param [PraticienDO] $objet
     * @return bool
     */
    public function delete($objet):bool
    {
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $id = $objet->getId_praticien();
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function readPatient($id)
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->praticien_patient_table (id_praticien, id_patient) VALUE (:id_praticien, :id_patient)";


    }

    /**
     * Création d'un tuple dans la table d'association praticien_patient
     * @param [PatientDO] $objet
     * @return boolean
     */
    public function createPatient(int $idPraticien, int $idPatient):bool
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->praticien_patient_table (id_praticien, id_patient) VALUE (:id_praticien, :id_patient)";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $idPraticien = $idPraticien;
        $idPatient = $idPatient;

        // On associe les paramètres
        $stmt->bindParam(":id_praticien", $idPraticien);
        $stmt->bindParam(":id_patient", $idPatient);

        // On exécute la requête préparée
        return $stmt->execute();
    }

    /**
     * Suppression d'un tuple dans la table d'association praticien_patient
     * @param [PraticienDO] $objet
     * @param [PatientDO] $objet
     * @return boolean
     */
    public function deletePatient($objetPraticien, $objetPatient):bool
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "DELETE FROM $this->praticien_patient_table WHERE id_praticien = :id_praticien AND id_patient = :id_patient";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $id_praticien = $objetPraticien->getId_praticien();
        $id_patient = $objetPatient->getId_patient();

        $stmt->bindParam(":id_praticien", $id_praticien);
        $stmt->bindParam(":id_patient", $id_patient);

        return $stmt->execute();
    }

    /**
     * Cherche dans la table d'association praticien/patient tous les patients d'un praticien
     * @param [int] $id
     * @return array
     */
    public function findAllPatientByIdPraticien($id):array
    {
        $data = [];
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "SELECT * FROM $this->praticien_patient_table WHERE id_praticien = :id";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id', $id);

        // On exécute la requête préparée
        $stmt->execute();

        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $data[] = $row["id_patient"];
        }
        return $data;
    }
}
