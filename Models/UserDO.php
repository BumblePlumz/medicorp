<?php
namespace App\Models;

use DateTime;

class UserDO 
{
    private int $idUser;
    private string $nom;
    private string $prenom;
    private DateTime $dateNaissance;
    private string $adresse;
    private string $ville;
    private string $codePostal;
    private string $email;
    private string $telephone;
    private string $motDePasse;
    private int $actif;
    private DateTime $created_at;

    // public function __construct(int $id_user, string $nom, string $prenom, DateTime $date_naissance, string $ville, string $code_postal, string $email, string $telephone, string $mot_de_passe, int $actif, DateTime $u_created_at){
    //     $this->idUser = $id_user;
    //     $this->nom = $nom;
    //     $this->prenom = $prenom;
    //     $this->dateNaissance = $date_naissance;
    //     $this->ville = $ville;
    //     $this->codePostal = $code_postal;
    //     $this->email = $email;
    //     $this->telephone = $telephone;
    //     $this->motDePasse = $mot_de_passe;
    //     $this->actif = $actif;
    //     $this->created_at = $u_created_at;
    // }

    public function __construct(string $nom, string $prenom, DateTime $date_naissance, string $adresse, string $ville, string $code_postal, string $email, string $telephone, string $mot_de_passe){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $date_naissance;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->codePostal = $code_postal;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->motDePasse = $mot_de_passe;
    }

    /**
     * Get the value of id_user
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */ 
    public function setIdUser($id_user)
    {
        $this->idUser = $id_user;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of date_naissance
     */ 
    public function getDateNaissance()
    {

        return $this->dateNaissance->format("Y-m-d");
    }

    /**
     * Set the value of date_naissance
     *
     * @return  self
     */ 
    public function setDateNaissance($date_naissance)
    {
        $this->dateNaissance = $date_naissance;

        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of code_postal
     */ 
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set the value of code_postal
     *
     * @return  self
     */ 
    public function setCodePostal($code_postal)
    {
        $this->codePostal = $code_postal;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of mot_de_passe
     */ 
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set the value of mot_de_passe
     *
     * @return  self
     */ 
    public function setMotDePasse($mot_de_passe)
    {
        $this->motDePasse = $mot_de_passe;

        return $this;
    }

    /**
     * Get the value of actif
     */ 
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set the value of actif
     *
     * @return  self
     */ 
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get the value of u_created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at->format("Y-m-d H:i:s");
    }

    /**
     * Set the value of u_created_at
     *
     * @return  self
     */ 
    public function setCreated_at($u_created_at)
    {
        $this->created_at = $u_created_at;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }
}