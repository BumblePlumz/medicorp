<?php

namespace App;

class Autoloader 
{
    static function register()
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    static function autoload($class)
    {
        // On récupère dans $class la totalité du namespace de la classe concernée (App\xxx\xxx)
        // On retire App\ (__NAMESPACE__ renvoie App sans slash)
        $class = str_replace(__NAMESPACE__. '\\','',$class);

        // On remplace les \ par les /
        $class = str_replace('\\','/',$class); 

        // TODO : test
        // echo "class";
        // echo $class;
        // echo "<br>";

        // On vérifie si le fichier existe
        if(file_exists(__DIR__ . '/' . $class . '.php')){
            require __DIR__ . '/' . $class . '.php'; 
        }
    }
}