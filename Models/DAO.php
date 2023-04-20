<?php

namespace App\Models;

use App\Core\DataAccessObject;
use App\Core\GlobalFunctions;

abstract class DAO
{
    // Table de la base de données
    protected $table;

    // Clé primaire
    protected $primaryKey;

    abstract function read($id);

    abstract function update($objet);

    abstract function delete($objet);

    abstract function create($objet);

    function __construct($key, $table)
    {
        $this->primaryKey = $key;
        $this->table = $table;
    }

    function getLastKey()
    {
        return DataAccessObject::getInstance()->lastInsertId();
        /* Version à la main qui récupère le max de la clé, qui n'assure pas que ce soit la bonne clé !
        $sql = "SELECT Max($this->key) as max FROM $this->table";
        $stmt = Connexion::getInstance()->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch();
        $newKey = $row["max"];
        return $newKey;*/
    }
}
