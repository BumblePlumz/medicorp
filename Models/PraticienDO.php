<?php
namespace App\Models;

use DateTime;

class PraticienDO
{
    private int $id;
    private string $activite;
    private string $numeroAdeli;
    private int $actif;
    private DateTime $createdAt;
    private UserDO $userDO;
    private array $listePatients;

    // public function __construct($id, $activite, $numero_adeli, $actif, $userDO)
    // {
    //     $this->id = $id;
    //     $this->activite = $activite;
    //     $this->numero_adeli = $numero_adeli;
    //     $this->actif = $actif;
    //     $this->userDO = $userDO;
    // }

    public function __construct($activite, $numero_adeli, $userDO)
    {
        $this->activite = $activite;
        $this->numeroAdeli = $numero_adeli;
        $this->userDO = $userDO;
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of activite
     */ 
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * Set the value of activite
     *
     * @return  self
     */ 
    public function setActivite($activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get the value of numero_adeli
     */ 
    public function getNumeroAdeli()
    {
        return $this->numeroAdeli;
    }

    /**
     * Set the value of numero_adeli
     *
     * @return  self
     */ 
    public function setNumeroAdeli($numero_adeli)
    {
        $this->numeroAdeli = $numero_adeli;

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
     * Get the value of userDO
     */ 
    public function getUserDO()
    {
        return $this->userDO;
    }

    /**
     * Set the value of userDO
     *
     * @return  self
     */ 
    public function setUserDO($userDO)
    {
        $this->userDO = $userDO;
        return $this;
    }

    public function setUserID($id):self
    {
        $this->getUserDO()->setIdUser($id);
        return $this;
    }

    public function getUserID():int
    {
        return $this->userDO->getIdUser();
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
