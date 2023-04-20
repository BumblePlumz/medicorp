<?php
namespace App\Models;

use DateTime;

class PraticienDO
{
    // Champ base de donnée
    private int $idPraticien;
    private string $nom;
    private string $prenom;
    private DateTime $dateNaissance;
    private string $adresse;
    private string $ville;
    private string $codePostal;
    private string $email;
    private string $telephone;
    private string $motDePasse;
    private string $activite;
    private string $numeroAdeli;
    private int $actif;
    private DateTime $dateCreation;

    // Table d'association
    private array $MapPatients = [];

    public function __construct(string $nom, string $prenom, DateTime $date_naissance, string $adresse, string $ville, string $code_postal, string $email, string $telephone, string $mot_de_passe,string $activite,string $numero_adeli)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $date_naissance;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->codePostal = $code_postal;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->motDePasse = $mot_de_passe;
        $this->activite = $activite;
        $this->numeroAdeli = $numero_adeli;
    }

    /**
     * Get the value of id_praticien
     * @return int
     */ 
    public function getIdPraticien():int
    {
        return $this->idPraticien;
    }

    /**
     * Set the value of id_praticien
     * @return  self
     */ 
    public function setIdPraticien(int $id_praticien):self
    {
        $this->idPraticien = $id_praticien;
        return $this;
    }

    /**
     * Get the value of nom
     * @return string
     */ 
    public function getNom():string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     * @return  self
     */ 
    public function setNom($nom):self
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get the value of prenom
     * @return string
     */ 
    public function getPrenom():string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     * @return  self
     */ 
    public function setPrenom($prenom):self
    {
        $this->prenom = $prenom;
        return $this;
    }
    

    /**
     * Get the value of date_naissance
     * @return DateTime
     */ 
    public function getDateNaissance():DateTime
    {
        return $this->dateNaissance;
    }

    /**
     * Set the value of date_naissance
     * @return  self
     */ 
    public function setDateNaissance($date_naissance):self
    {
        $this->dateNaissance = $date_naissance;
        return $this;
    }

    

    /**
     * Get the value of adresse
     * @return string
     */ 
    public function getAdresse():string
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     * @return  self
     */ 
    public function setAdresse($adresse):self
    {
        $this->adresse = $adresse;
        return $this;
    }

    

    /**
     * Get the value of ville
     * @return string
     */ 
    public function getVille():string
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     * @return  self
     */ 
    public function setVille($ville):self
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * Get the value of code_postal
     * @return string
     */ 
    public function getCodePostal():string
    {
        return $this->codePostal;
    }

    /**
     * Set the value of code_postal
     * @return  self
     */ 
    public function setCodePostal($code_postal):self
    {
        $this->codePostal = $code_postal;
        return $this;
    }

    /**
     * Get the value of email
     * @return string
     */ 
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     * @return  self
     */ 
    public function setEmail($email):self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of telephone
     * @return string
     */ 
    public function getTelephone():string
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     * @return  self
     */ 
    public function setTelephone($telephone):self
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * Get the value of mot_de_passe
     * @return string
     */ 
    public function getMotDePasse():string
    {
        return $this->motDePasse;
    }

    /**
     * Set the value of mot_de_passe
     * @return  self
     */ 
    public function setMotDePasse($mot_de_passe):self
    {
        $this->motDePasse = $mot_de_passe;
        return $this;
    }
    

    /**
     * Get the value of activite
     * @return string
     */ 
    public function getActivite():string
    {
        return $this->activite;
    }

    /**
     * Set the value of activite
     * @return  self
     */ 
    public function setActivite($activite):self
    {
        $this->activite = $activite;
        return $this;
    }
    

    /**
     * Get the value of numero_adeli
     * @return string
     */ 
    public function getNumeroAdeli():string
    {
        return $this->numeroAdeli;
    }

    /**
     * Set the value of numero_adeli
     * @return  self
     */ 
    public function setNumeroAdeli($numero_adeli):self
    {
        $this->numeroAdeli = $numero_adeli;
        return $this;
    }

    /**
     * Get the value of actif
     * @return int
     */ 
    public function getActif():int
    {
        return $this->actif;
    }

    /**
     * Set the value of actif
     * @return  self
     */ 
    public function setActif($actif):self
    {
        $this->actif = $actif;
        return $this;
    }

    /**
     * Get the value of date_creation
     * @return DateTime
     */ 
    public function getDateCreation():DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of date_creation
     * @return  self
     */ 
    public function setDateCreation(string $date_creation):self
    {
        $dateCreation = new DateTime($date_creation);
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * Get the value of listePatients
     * @return array
     */ 
    public function getMapPatients():array
    {
        return $this->MapPatients;
    }

    /**
     * Set the value of listePatients
     * @return  self
     */ 
    public function setMapPatients($listePatients):self
    {
        $this->MapPatients = $listePatients;
        return $this;
    }
}
