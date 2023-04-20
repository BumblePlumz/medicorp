<?php
namespace App\Models;

class PatientDO
{
    private int $idUser;
    private int $idPraticien;

    public function __construct($idUser, $idPraticien)
    {
        $this->idUser = $idUser;
        $this->idPraticien = $idPraticien;
    }

   

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of idPraticien
     */ 
    public function getIdPraticien()
    {
        return $this->idPraticien;
    }

    /**
     * Set the value of idPraticien
     *
     * @return  self
     */ 
    public function setIdPraticien($idPraticien)
    {
        $this->idPraticien = $idPraticien;

        return $this;
    }
}