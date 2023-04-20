<?php

namespace App\Models;

class PecDO 
{
    // Attributs
    private int $id;
    private string $type;
    private string $duree;
    private int $prix;
    private int $idPraticien;

    // Constructeur
    public function __construct(string $type, string $duree, int $prix, int $idPraticien){
        $this->type = $type;
        $this->duree = $duree;
        $this->prix = $prix;
        $this->idPraticien = $idPraticien;
    }
    
    // Getter & Setter
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
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of duree
     */ 
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set the value of duree
     *
     * @return  self
     */ 
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get the value of prix
     */ 
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     *
     * @return  self
     */ 
    public function setPrix($prix)
    {
        $this->prix = $prix;

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