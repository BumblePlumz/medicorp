<?php
namespace App\Core;

class AppFonctions 
{
    /**
     * Liste des feuilles de style à ajouter au head
     * @var array
     */
    public static $feuillesDeStyleAjoutees = array();
    
    /**
     * Liste des scripts à ajouter au head
     * @var array
     */
    public static $feuillesDeScriptAjoutees = array();

    /**
     * Ajoute une feuille de style au Header de default.php
     * @param string Chemin à partir du dossier /css/xxx/xxx.css
     * @return void
     */
    public static function addStyle($route):void
    {
        if (!in_array($route, self::$feuillesDeStyleAjoutees)) {
            // Démarrer la sortie en tampon
            ob_start(); 
            
            // Ajouter les balises HTML pour les feuilles de style CSS
            echo "<link rel='stylesheet' type='text/css' href='/assets/css".$route.".css'>";
            
            // Récupérer le contenu de la variable tampon et on la stock dans la propriété static
            array_push(self::$feuillesDeStyleAjoutees, ob_get_clean()); 
        }
    }
    /**
     * Undocumented function
     * @param string Chemin à partir du dossier /js/xxx/xxx.js
     * @param string Attribut defer/async
     * @return void
     */
    public static function addScript($route, $param):void
    {
        if (!in_array($route, self::$feuillesDeScriptAjoutees)) {
            
            // Démarrer la sortie en tampon
            ob_start();

            // Ajouter les balises HTML pour les scripts JS
            echo "<script src='/assets/js/".$route.".js' ".$param."></script>";

            // Récupérer le contenu HTML de la variable tampon et on la stock dans la propriété static
            array_push(self::$feuillesDeScriptAjoutees, ob_get_clean());
        }
    }

    /**
     * TODO
     * Undocumented function
     *
     * @param [type] $route
     * @return void
     */
    public static function controllerLink($route)
    {
        $racine = $_SERVER['DOCUMENT_ROOT'];

        // On ajoute l'url créé
        echo $racine."/Controllers/".$route;
    }

    /**
     * Fonction print_r personnalisé directement avec les balises <pre>
     * @param [objet] $data
     * @return void
     */
    public static function my_print_r($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}