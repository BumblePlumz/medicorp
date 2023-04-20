<?php
namespace App\Core;

use PDO;
use PDOException;

class DataAccessObject extends PDO
{
    // Instance unique de la classe
    private static $instance;

    // Informations de connexion
    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'medicorp';

    private function __construct()
    {
        // DSN de connexion
        $_dsn = 'mysql:dbname='.self::DBNAME.';host='.self::DBHOST;

        try{
            // On appelle le constructeur de la classe PDO
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);

            // Transition en utf-8
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');

            // Premier choix
            // A chaque fois qu'on effecture un FETCH, il sera de type ASSOC (tableau)
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Deuxième choix
            // A chaque fois qu'on effecture un FETCH, il sera de type OBJ (objet)
            // $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            // Déclanché une exception lors d'une erreur
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            die($e->getMessage());
        }

    }

    public static function getInstance():self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}
?>