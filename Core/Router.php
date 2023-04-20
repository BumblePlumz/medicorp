<?php

namespace App\Core;

use App\Controllers\RouterController;
use Exception;

class Router
{
    public function start()
    {
        // On démarre la session
        session_start();
        
        // http://Portfolio.local/controller/method/configs
        // http://Portfolio.local/rendezvous/details/xxx
        // http://Portfolio.local/index.php?p=rdv/details/xxx

        // On retire le "trailing slash" éventuel de l'URL
        // On récupère l'URL
        $uri = $_SERVER['REQUEST_URI'];

        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
            // Vérifie si la redirection est déjà en cours
            if (!isset($_SERVER['REDIRECT_STATUS']) || $_SERVER['REDIRECT_STATUS'] != 200) {
                
                // Dans ce cas on enlève le /
                // Autre méthode : $uri = substr($uri, 0, -1);
                $uri = rtrim($uri, '/'); 
        
                // On envoie une redirection permanente
                http_response_code(301);
        
                // On redirige vers l'URL sans /
                header('Location: ' . $uri);
                exit;
            }
        }

        // On gère les paramètres d'URL
        // p=controller/method/configs
        // On sépare les paramètres dans un tableau
        $configs = array();
        if (isset($_GET['p'])) {
            $configs = explode('/', $_GET['p']);
        }
        
        // Si on a au moins 1 paramètre
        if (isset($configs[0]) && $configs[0] != "") {

            // On récupère le nom du contrôleur à instancer
            // On met une majuscule en 1ère lettre, on ajouter le namespace complet avant et on ajoute "Controller" après
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($configs)) . 'Controller';

            /** Pour tester, on renvoie l'url dans un print_r et on voit bien que l'url utilisé appelle le controler du même nom :
            * print_r($controller);die;
            */

            // On instancie le contrôleur
            $controller = new $controller();

            // On récupère le 2ème paramètre d'URL si il existe pas on recherche le fichier index par défaut
            $action = (isset($configs[0])) ? array_shift($configs) : 'index';

            if (method_exists($controller, $action)) {
                /**
                 * ! Important !
                 * 1) Dans l'url on a récupéré les paramètres après "/public/xxx/yyy?zzz"
                 * 2) On va chercher le controller associé à xxxController
                 * 3) call_user_func_array() va aller chercher la fonction yyy dans xxxController
                 * 4) Condition ternaire si il y a des GETs(zzz) on les ajoutes à la fonction à exécuter en tant qu'attributs sinon on exécute la fonction sans rien
                 */

                // Si il reste des paramètres on les passe à la méthode
                // (isset($configs[0])) ? $controller->$action($configs) : $controller->$action(); // Cette façon de faire reçoit un tableau et demande de l'interpréter
                (isset($configs[0])) ? call_user_func_array([$controller, $action], $configs) : $controller->$action(); // Cette façon de faire peut reçevoir tous les types de données
            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
                die;
            }
        } else {

            // On n'a pas de paramètres
            // On instancie le contrôleur par défaut
            $controller = new RouterController();

            // $controller = new RouterController;
            // On appelle la méthode index
            $controller->index();
        }
    }
}
