<?php
namespace App\Models;

use DateTime;

class RdvDO 
{
    private int $id;
    private UserDO $userDO;
    private PriseEnChargeModel $priseEnCharge;
    private string $dateRdv;
    private string $commentaire;
    private int $actif;
    private DateTime $created_at;

    public function __construct($id, $userDO, $pec, $dateRdv, $com, $actif, $created_at)
    {
        $this->id = $id;
        $this->$userDO = $userDO;
        $this->priseEnCharge = $pec;
        $this->dateRdv = $dateRdv;
        $this->commentaire = $com;
        $this->actif = $actif;
        $this->created_at = $created_at;
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

    /**
     * Get the value of priseEnCharge
     */ 
    public function getPriseEnCharge()
    {
        return $this->priseEnCharge;
    }

    /**
     * Set the value of priseEnCharge
     *
     * @return  self
     */ 
    public function setPriseEnCharge($priseEnCharge)
    {
        $this->priseEnCharge = $priseEnCharge;

        return $this;
    }

    /**
     * Get the value of dateRdv
     */ 
    public function getDateRdv()
    {
        return $this->dateRdv;
    }
    
    /**
     * Set the value of dateRdv
     *
     * @return  self
     */ 
    public function setDateRdv($dateRdv)
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    /**
     * Get the value of commentaire
     */ 
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of commentaire
     *
     * @return  self
     */ 
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

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
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }


}