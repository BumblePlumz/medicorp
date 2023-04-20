<?php
namespace App\Models;

use App\Core\DataAccessObject;

use DateTime;

class UserDAO extends DAO 
{
    private string $id = "id_user";
    private string $nom = "nom";
    private string $prenom = "prenom";
    private string $dateNaissance = "date_naissance";
    private string $adresse = "adresse";
    private string $ville = "ville";
    private string $codePostal = "code_postal";
    private string $email = "email";
    private string $telephone = "telephone";
    private string $motDePasse = "mot_de_passe";
    private string $actif = "actif";
    private string $createdAt = "created_at";

    // Instance
    protected static $instance = null;

    public function __construct()
    {
        parent::__construct('id_user', "users");
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
    public function setSession($userDO){
        $_SESSION['user'] = [
            'id' => $userDO->getIdUser(),
            'email' => $userDO->getEmail(),
        ];
    }

    public function findOneByEmail(string $email){
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        
        $stmt = DataAccessObject::getInstance()->prepare($sql);
        $stmt->bindParam(":email",$email);
        $stmt->execute();

        $row = $stmt->fetch();
        $id = $row[$this->id];
        $nom = $row[$this->nom];
        $prenom = $row[$this->prenom];
        $date_naissance = DateTime::createFromFormat('Y-m-d', $row[$this->dateNaissance]);
        $adresse = $row[$this->adresse];
        $city = $row[$this->ville];
        $cp = $row[$this->codePostal];
        $email = $row[$this->email];
        $phone = $row[$this->telephone];
        $password = $row[$this->motDePasse];
        $actif = $row[$this->actif];
        $createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $row[$this->createdAt]);

        $userDO = new UserDO($nom, $prenom, $date_naissance, $adresse, $city, $cp, $email, $phone, $password);
        $userDO->setIdUser($id)
            ->setActif($actif)
            ->setCreated_at($createdAt);

        return $userDO;
    }

    /**
     * Lire un tuple "users" de la base donnée
     * @param [int] $id
     * @return UserDO
     */
    public function read($id):UserDO
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey=:id";

        // On récupère l'instance unique DAO et on prépare la requête
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        // On associe les paramètres
        $stmt->bindParam(':id', $id);

        // On exécute la requête préparée
        $stmt->execute();

        // On récupère 
        $row = $stmt->fetch();
        $nom = $row["nom"];
        $prenom = $row[$this->prenom];
        $date_naissance = DateTime::createFromFormat('Y-m-d', $row[$this->dateNaissance]);
        $adresse = $row[$this->adresse];
        $city = $row[$this->ville];
        $cp = $row[$this->codePostal];
        $email = $row[$this->email];
        $phone = $row[$this->telephone];
        $password = $row[$this->motDePasse];
        $actif = $row[$this->actif];
        $createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $row[$this->createdAt]);

        $userDO = new UserDO($nom, $prenom, $date_naissance, $adresse, $city, $cp, $email, $phone, $password);
        $userDO->setIdUser($id)
            ->setActif($actif)
            ->setCreated_at($createdAt);

        return $userDO;
    }

    /**
     * Mettre à jour un tuple "users" dans la base de donnée
     * @param [UserDO] $objet
     * @return void
     */
    public function update($objet):void
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "UPDATE $this->table SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, adresse = :adresse, ville = :ville, code_postal = :code_postal, email = :email, telephone = :telephone, mot_de_passe = :mot_de_passe, actif = :actif WHERE $this->primaryKey=:id";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $nom = $objet->getNom();
        $prenom = $objet->getPrenom();
        $date_naissance = $objet->getDateNaissance()->format('Y-m-d');
        $adresse = $objet->getAdresse();
        $ville = $objet->getVille();
        $cp = $objet->getCodePostal();
        $email = $objet->getEmail();
        $phone = $objet->getTelephone();
        $password = $objet->getMotDePasse();
        $actif = $objet->getActif();
        $id = $objet->getIdUser();

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code_postal', $cp);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $phone);
        $stmt->bindParam(':mot_de_passe', $password);
        $stmt->bindParam(':actif', $actif);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    /**
     * Créer un tuple "users" dans la base de donnée
     * @param [UserDo] $objet
     * @return void
     */
    public function create($objet):void
    {
        // On utilise le prepared statemet qui simplifie les typages
        $sql = "INSERT INTO $this->table (nom, prenom, date_naissance, adresse, ville, code_postal, email, telephone, mot_de_passe) VALUE (:nom, :prenom, :date_naissance, :adresse, :ville, :code_postal, :email, :telephone, :mot_de_passe)";
        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $nom = $objet->getNom();
        $prenom = $objet->getPrenom();
        $date_naissance = $objet->getDateNaissance()->format('Y-m-d');
        $adresse = $objet->getAdresse();
        $ville = $objet->getVille();
        $cp = $objet->getCodePostal();
        $email = $objet->getEmail();
        $phone = $objet->getTelephone();
        $password = $objet->getMotDePasse();

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code_postal', $cp);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $phone);
        $stmt->bindParam(':mot_de_passe', $password);

        $stmt->execute();
    }

    /**
     * Supprimer un tuple "users" dans la base de donnée
     * @param [UserDo] $objet
     * @return void
     */
    public function delete($objet):void
    {
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey=:id";

        $stmt = DataAccessObject::getInstance()->prepare($sql);

        $id = $objet->getIdUser();
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }


}